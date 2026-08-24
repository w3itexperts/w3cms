<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Channel;
use Illuminate\Support\Str;

class SourcesController extends Controller
{
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.sources');
        $sources = Source::whereNull('business_id')->orWhere('business_id', 0)
                    ->when($request->filled('name'), function ($q) use ($request) {
                        $q->where('name', 'Like', '%'.$request->name.'%');
                    })
                    ->paginate(config('Reading.nodes_per_page'));

        return view('solarmitra::admin.sources.index', compact('sources','page_title'));
    }

    public function create()
    {
        $page_title = __('solarmitra::solarmitra.create_source');
        $channels = Channel::whereNull('business_id')->orWhere('business_id', 0)
                    ->where('is_active', 1)->pluck('title', 'id')->toArray();

        $source = new Source();

        return view('solarmitra::admin.sources.form', compact('source', 'channels', 'page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Source::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'type'        => $request->type,
            'channel_id'  => $request->channel_id,
            'is_active'   => $request->is_active ?? 1,
            'business_id' => null,
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.source_created_successfully'), 'reload' => true]);
        }

        return redirect()->route('admin.solarmitra.sources.index')->with('success', __('solarmitra::solarmitra.source_created_successfully'));
    }

    public function edit($id)
    {
        $page_title = __('solarmitra::solarmitra.edit_source');
        $source = Source::whereNull('business_id')->orWhere('business_id', 0)->findOrFail($id);

        $channels = Channel::whereNull('business_id')->orWhere('business_id', 0)
                    ->where('is_active', 1)->pluck('title', 'id')->toArray();

        return view('solarmitra::admin.sources.form', compact('source', 'channels', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $source = Source::whereNull('business_id')->orWhere('business_id', 0)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $source->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'type'        => $request->type,
            'channel_id'  => $request->channel_id,
            'is_active'   => $request->is_active ?? 1,
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.source_updated_successfully'), 'reload' => true]);
        }

        return redirect()->route('admin.solarmitra.sources.index')->with('success', __('solarmitra::solarmitra.source_updated_successfully'));
    }

    public function destroy($id)
    {
        $source = Source::whereNull('business_id')->orWhere('business_id', 0)->findOrFail($id);
        $source->delete();

        return redirect()->back()->with('success', __('solarmitra::solarmitra.source_deleted_successfully'));
    }
}