<?php

namespace Modules\AppManager\Http\Controllers;

use Illuminate\Http\Request;
use Modules\AppManager\Entities\DownloadHistory;
use DzHelper;
use Str;
use DB;
use Auth;

class DownloadHistoryController extends ModuleController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = __('common.downloadHistory');
        $resultQuery = DownloadHistory::query();
        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $list = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('appmanager::admin.download_history.index',compact('page_title','list'));
    }

    public function reports(Request $request)
    {
        $page_title = __('common.downloadHistory');
        $country_list = DownloadHistory::select('country_code','country', \DB::raw('COUNT(*) as total_downloads'))->groupBy('country')->orderBy('total_downloads','DESC')->get();
        $resObj = DownloadHistory::query();



        if($request->input('year')) {
            $resObj->where( DB::raw('YEAR(`created_at`)'), '=', $request->input('year') );
            $resObj->selectRaw('DATE_FORMAT(`created_at`, "%Y-%m") AS period, country_code, country, COUNT(`id`) AS total_items')
                ->groupByRaw('MONTH(`created_at`)')
                ->orderByRaw('MONTH(`created_at`)');
        }
        elseif($request->input('month')) {
            
            $resObj->where( DB::raw('DATE_FORMAT(`created_at`, "%Y-%m")'), '=', $request->input('month') );
            $resObj->selectRaw('DATE(`created_at`) AS period,country_code, country, COUNT(`id`) AS total_items')
                ->groupByRaw('DATE(`created_at`)')
                ->orderByRaw('DATE(`created_at`)');
        }
        elseif($request->input('date')) {
            
            $resObj->where( DB::raw('DATE_FORMAT(`created_at`, "%Y-%m-%d")'), '=', $request->input('date') );
            $resObj->selectRaw('created_at AS period, country_code, country, 1 AS total_items')
                ->orderByRaw('created_at');
        }
        else
        {
            $resObj->selectRaw('YEAR(`created_at`) AS period, country_code, country, COUNT(`id`) AS total_items')
                                    ->groupByRaw('YEAR(`created_at`)')
                                    ->orderByRaw('YEAR(`created_at`)');     
        }


        $resObj->addSelect('download_histories.*');
        $records        = $resObj->get();

        // dd($records);
        if(!empty($records)){ 
            foreach($records as $record){

                $graph_data[] = array(
                                    'x'=>$record['period'], 
                                    'y'=>$record['total_items']
                                );              
            }
        }

        return view('appmanager::admin.download_history.list',compact('page_title','country_list','graph_data','records'));
    }




}
