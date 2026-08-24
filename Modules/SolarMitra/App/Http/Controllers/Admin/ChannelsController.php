<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\Channel;
use Illuminate\Support\Str;

class ChannelsController extends Controller
{
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.channel');
        $channels = Channel::whereNull('business_id')->orWhere('business_id', 0)
                    ->when($request->filled('search'), function ($q) use ($request) {
                        $q->where('title', 'Like', '%'.$request->search.'%');
                    })
                    ->paginate(config('Reading.nodes_per_page'));

        return view('solarmitra::admin.channels.index', compact('channels','page_title'));
    }

    public function create()
    {
        $page_title = __('solarmitra::solarmitra.create_channel');
        $channel = new Channel();

        return view('solarmitra::admin.channels.form', compact('channel','page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Channel::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'is_active'   => $request->is_active ?? 1,
            'business_id' => null,
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.channel_created'), 'reload' => true]);
        }

        return redirect()->route('admin.solarmitra.channels.index')->with('success', __('solarmitra::solarmitra.channel_created'));
    }

    public function edit($id)
    {
        $page_title = __('solarmitra::solarmitra.create_channel');
        $channel = Channel::whereNull('business_id')->orWhere('business_id', 0)->findOrFail($id);

        return view('solarmitra::admin.channels.form', compact('channel','page_title'));
    }

    public function update(Request $request, $id)
    {
        $channel = Channel::whereNull('business_id')->orWhere('business_id', 0)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $channel->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'is_active'   => $request->is_active ?? 1,
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.channel_updated'), 'reload' => true]);
        }

        return redirect()->route('admin.solarmitra.channels.index')->with('success', __('solarmitra::solarmitra.channel_updated'));
    }

    public function destroy($id)
    {
        $channel = Channel::whereNull('business_id')->orWhere('business_id', 0)->findOrFail($id);
        $channel->delete();

        return redirect()->back()->with('success', __('solarmitra::solarmitra.channel_deleted'));
    }
}