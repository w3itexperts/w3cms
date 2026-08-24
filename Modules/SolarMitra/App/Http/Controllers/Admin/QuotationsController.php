<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\Helper\SolarMitraHelper;

class QuotationsController extends Controller
{
    
    public function get_brands_by_category(Request $request)
    {
        $companies = SolarMitraHelper::getCompaniesByCategoryArr($request->category_id);
        
        $html = '<option value="">'.__('solarmitra::solarmitra.select_item').'</option>';
        
        foreach ($companies as $key => $value) {
            $html .= '<option value="'.$key.'">'.$value.'</option>';
        }
        return $html;
    }
}
