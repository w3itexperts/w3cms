<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use Modules\SolarMitra\App\Models\BusinessConfigMaster;
use Modules\SolarMitra\App\Models\ConfigMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Notification;

class BusinessConfigMasterController extends Controller
{

    /**
     * form created by added config fields
     */
    public function manage(Request $request)
    {
        if($request->isMethod('post'))
        {
            $configuration_master = ConfigMaster::select('id','display_title','field_value','field_key')->get()->keyBy('id')->toArray();
            foreach ($request->ConfigMaster as $config) {
                $ConfigId = $config['id'];
                $ConfigKey = collect($config)->except('id')->keys()->first();
                $ConfigValue = isset($config[$ConfigKey]) ? $config[$ConfigKey] : null;

                $ConfigMaster = $configuration_master[$ConfigId];
                

                if (isset($ConfigValue) && !is_null($ConfigValue) && $ConfigMaster['field_value'] !== $ConfigValue) {

                    BusinessConfigMaster::updateOrCreate(
                        [
                            'config_master_id' => (int) $ConfigId,
                            'business_id' => (int) app('currentBusinessId'),
                        ],
                        [
                            'display_title' => $ConfigMaster['display_title'],
                            'field_key' => $ConfigMaster['field_key'],
                            'field_value' => $ConfigValue,
                        ]
                    );
                }elseif(isset($ConfigValue) && !is_null($ConfigValue) && $ConfigMaster['field_value'] === $ConfigValue){
                    BusinessConfigMaster::where([
                        'config_master_id' => (int) $ConfigId,
                        'business_id' => (int) app('currentBusinessId'),
                    ])->delete();
                }

            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BUSINESSCONFIGMASTER-BCU', app('currentBusinessId'), auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', __('solarmitra::solarmitra.configs_saved_successfully'));

        }

        $page_title = __('solarmitra::solarmitra.configurations');
        $businessId = app('currentBusinessId');
        $configurations = ConfigMaster::with([
                            'business_config_master' => function ($q) use ($businessId) {

                                    $q->where('business_id', $businessId);

                            }
                        ])->get()->groupBy('module_code');
        
        return view('solarmitra::business.business_config_master.manage',compact('page_title','configurations'));
    }

    public function reset_business_configs(Request $request)
    {
        BusinessConfigMaster::where('business_id',app('currentBusinessId'))->delete();

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('BUSINESSCONFIGMASTER-BCR', app('currentBusinessId'), auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        return redirect()->back()->with('success', __('solarmitra::solarmitra.business_configs_reset_successfully'));
    }
}
