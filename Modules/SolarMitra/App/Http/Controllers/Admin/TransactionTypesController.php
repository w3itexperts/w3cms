<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\SolarMitra\App\Models\TransactionType;

class TransactionTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request,$id=null)
    {
        $TransactionTypeQuery = TransactionType::query();
        $transactionType = $id ? TransactionType::find($id) : new TransactionType;

        if (request('title')) {
            $TransactionTypeQuery->where('title', 'Like','%'.request('title').'%');
        }
        
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $transactionType->title = $request->title;
            $transactionType->parent_id = $request->parent_id;
            $res = $transactionType->save();

            if ($res) {
                $msg = $id ? __('solarmitra::solarmitra.transaction_types_updated_text') : __('solarmitra::solarmitra.transaction_types_added_text');
                return redirect()->route('admin.solarmitra.transaction_types.list')->with('success', $msg);
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));

        }

        $list = TransactionType::get()->pluck('title','id');
        $transaction_types    = (new TransactionType)->generateTreeArray(Null, "_", ['id', 'parent_id','title', 'created_at']);

        if($transaction_types)
        {
            $transaction_types    = $this->paginate(collect($transaction_types), config('Reading.nodes_per_page'));
        }
        return view('solarmitra::admin.transactions_types.list',compact('list','transactionType','transaction_types','list'));
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $TransactionType = TransactionType::findOrFail($id)->delete();
        return redirect()->route('admin.solarmitra.transaction_types.list')->with('success', __('solarmitra::solarmitra.transaction_types_deleted_text'));
    }
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options =  array(
                        'path' => LengthAwarePaginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    );
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
