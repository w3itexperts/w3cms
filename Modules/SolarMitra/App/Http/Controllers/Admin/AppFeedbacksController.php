<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\AppFeedback;

class AppFeedbacksController extends Controller
{
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.app_feedbacks');

        $feedbacks = AppFeedback::query()
            ->with('business', 'user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('module_name', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('feedback_type'), function ($query) use ($request) {
                $query->where('feedback_type', $request->feedback_type);
            })
            ->when($request->filled('priority'), function ($query) use ($request) {
                $query->where('priority', $request->priority);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(config('Reading.nodes_per_page'));

        return view('solarmitra::admin.app_feedbacks.index', compact('page_title', 'feedbacks'));
    }
}