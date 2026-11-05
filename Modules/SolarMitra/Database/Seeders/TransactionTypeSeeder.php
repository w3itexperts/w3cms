<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $getOrCreate = static function (?int $parentId, string $title, string $slug): int {
            $query = DB::table('transaction_types')->where('slug', $slug);

            if ($parentId === null) {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $parentId);
            }

            $existingId = $query->value('id');

            if ($existingId) {
                return (int) $existingId;
            }

            return (int) DB::table('transaction_types')->insertGetId([
                'parent_id' => $parentId,
                'title' => $title,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };

        // Level 1
        $incomeId = $getOrCreate(null, 'Income', 'income');
        $expenseId = $getOrCreate(null, 'Expense', 'expense');

        // Level 2: Income
        $salesId = $getOrCreate($incomeId, 'Sales', 'sales');
        $otherIncomeId = $getOrCreate($incomeId, 'Other Income', 'other-income');

        // Level 2: Expense
        $operationalExpensesId = $getOrCreate($expenseId, 'Operational Expenses', 'operational-expenses');
        $projectExpensesId = $getOrCreate($expenseId, 'Project Expenses', 'project-expenses');
        $hrExpensesId = $getOrCreate($expenseId, 'HR Expenses', 'hr-expenses');
        $otherExpensesId = $getOrCreate($expenseId, 'Other Expenses', 'other-expenses');

        $children = [
            [$salesId, 'Invoice Payment', 'invoice-payment'],
            [$salesId, 'Advance from Client', 'advance-from-client'],
            [$salesId, 'Direct Sale', 'direct-sale'],

            [$otherIncomeId, 'Loan Received', 'loan-received'],
            [$otherIncomeId, 'Interest Income', 'interest-income'],
            [$otherIncomeId, 'Investment', 'investment'],

            [$operationalExpensesId, 'Office Expenses', 'office-expenses'],
            [$operationalExpensesId, 'Transport Expenses', 'transport-expenses'],
            [$operationalExpensesId, 'Utility Bills', 'utility-bills'],

            [$projectExpensesId, 'Material Purchase', 'material-purchase'],
            [$projectExpensesId, 'Labor Payment', 'labor-payment'],
            [$projectExpensesId, 'Contractor Payment', 'contractor-payment'],

            [$hrExpensesId, 'Salary', 'salary'],
            [$hrExpensesId, 'Bonus', 'bonus'],

            [$otherExpensesId, 'Misc Expense', 'misc-expense'],
        ];

        foreach ($children as [$parentId, $title, $slug]) {
            $getOrCreate($parentId, $title, $slug);
        }
    }
}
