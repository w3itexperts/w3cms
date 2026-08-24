<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Modules\SolarMitra\App\Models\MaterialCompany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Models\Notification;

class MaterialCategoriesController extends Controller
{

    public function list(Request $request, $id='')
    {

        $page_title = __('solarmitra::solarmitra.material_categories');

        $material_categories    = (new MaterialCategory)->generateCategoryTreeArray(Null, "_", ['id', 'title','gst','display_on_invoice','include_in_solar_kit','calculate_in_invoice','description', 'created_at']);
        $material_units    = MaterialUnit::get()->pluck('title','id')->toArray();

        if($material_categories)
        {
            $material_categories    = $this->paginate(collect($material_categories), config('Reading.nodes_per_page'));
        }

        $materialCategory = MaterialCategory::firstOrNew(['id' => $id]);
        $newCat = !$materialCategory->exists;

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
            ];

            $validationMsg = [
                'title.required'    => __('solarmitra::solarmitra.title_required'),
            ];

            $this->validate($request, $validation, $validationMsg);
            $maxOrder = MaterialCategory::max('order') ?? 0;
            $maxOrder += 1;
                
            $materialCategory->parent_id            = $request->parent_id ? $request->parent_id : Null;
            $materialCategory->title                = $request->title;
            $materialCategory->slug                 = Str::slug($request->title);
            $materialCategory->description          = $request->description;
            $materialCategory->unit_id              = $request->unit_id;
            $materialCategory->display_on_invoice       = $request->display_on_invoice ?? 0;
            $materialCategory->calculate_in_invoice     = $request->calculate_in_invoice ?? 0;
            $materialCategory->include_in_solar_kit     = $request->include_in_solar_kit ?? 0;
            $materialCategory->gst          = $request->gst ?? 0;
            $materialCategory->order        = $newCat ? $maxOrder : $materialCategory->order;
            $res                            = $materialCategory->save();

            if($res)
            {
                /* Send Event Notification */
                $notify_code = $newCat ? 'MATERIALCATEGORY-ANMC' : 'MATERIALCATEGORY-UMC';
                $notificationObj        = new Notification();
                $notificationObj->notification_entry($notify_code, $materialCategory->id, auth('business')->id(), config('constants.superadmin'));
                /* End Send Event Notification */

                $msg = $newCat ? __('solarmitra::solarmitra.material_cat_add_success') : __('solarmitra::solarmitra.material_cat_update_success');
                return redirect()->route('business.solarmitra.material_categories.list')->with('success', $msg);
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        }
        return view('solarmitra::business.material-categories.list',compact('page_title','material_categories','materialCategory','material_units'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $materialCategory = MaterialCategory::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('MATERIALCATEGORY-DMC', $materialCategory->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        $materialCategory->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.material_category_deleted_text'));
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

    /**
     * Admin moveup
     *
     * @param integer $id
     * @param integer $step
     * @return void
     * @access public
     */
    public function moveup($id, $step = 1)
    {

        $materialCategoryObj = new MaterialCategory();
        $res = $materialCategoryObj->moveUp($id, $step);
        if($res)
        {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.Moved_up_success'));
        }
        else
        {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.could_not_move_up'));
        }
    }

    /**
     * Admin moveup
     *
     * @param integer $id
     * @param integer $step
     * @return void
     * @access public
     */
    public function movedown($id, $step = 1)
    {

        $materialCategoryObj = new MaterialCategory();
        $res = $materialCategoryObj->moveDown($id, $step);
        if($res)
        {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.Moved_down_success'));
        }
        else
        {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.could_not_move_down'));
        }
    }
    
}
