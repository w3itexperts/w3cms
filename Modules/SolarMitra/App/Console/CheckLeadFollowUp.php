<?php

namespace Modules\SolarMitra\App\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\SolarMitra\App\Models\LeadFollowUp;
use Modules\SolarMitra\App\Models\LeadFollowUpLog;
use Carbon\Carbon;

class CheckLeadFollowUp extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'solarmitra:check-lead-followup';

    /**
     * The console command description.
     */
    protected $description = 'This Command check older follow up logs and set to Missed.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();
        $activeRules = LeadFollowUp::where('is_active', 1)->get();

        foreach ($activeRules as $rule) {
            
            if(!$rule->lead) continue;

            $pendingLogs = LeadFollowUpLog::where('followup_id', $rule->id)->where('status', 1)->get();

            foreach ($pendingLogs as $log) {

                if (Carbon::createFromFormat(config('solarmitra.date_time_format'),$log->scheduled_at)->lt($today)) {
                    $log->status = 3;
                    $log->completed_at = $today->format(config('solarmitra.date_time_format'));
                    $log->save();
                }

                if ($rule->repeat_followup != 1) {

                    $nextExists = LeadFollowUpLog::where('followup_id', $rule->id)->where('status', 1)->exists();

                    if (!$nextExists) {

                        $nextDate = match ($rule->repeat_followup) {
                            2 => Carbon::createFromFormat(config('solarmitra.date_time_format'),$log->scheduled_at)->copy()->addWeek()->format(config('solarmitra.date_time_format')),
                            3 => Carbon::createFromFormat(config('solarmitra.date_time_format'),$log->scheduled_at)->copy()->addMonth()->format(config('solarmitra.date_time_format')),
                            4 => Carbon::createFromFormat(config('solarmitra.date_time_format'),$log->scheduled_at)->copy()->addMonths(3)->format(config('solarmitra.date_time_format')),
                            5 => Carbon::createFromFormat(config('solarmitra.date_time_format'),$log->scheduled_at)->copy()->addYear()->format(config('solarmitra.date_time_format')),
                            default => null,
                        };
                        if ($nextDate) {
                            LeadFollowUpLog::create([
                                'lead_id' => $rule->lead_id,
                                'followup_id' => $rule->id,
                                'scheduled_at' => $nextDate,
                                'status' => 1,
                                'remarks' => $log->remarks,
                            ]);
                        }
                    }
                }
            }
        }

        $this->info('Follow-ups processed successfully.');
        \Log::info('Follow-ups processed successfully.');
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
