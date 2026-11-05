<?php

namespace Modules\SolarMitra\Observers;

use Modules\SolarMitra\App\Models\CampaignLead;
use Modules\SolarMitra\App\Models\CampaignActivities;

class CampaignLeadObserver
{
    public function saved(CampaignLead $lead)
    {
        if ($lead->campaign_activity_id) {
            $activity = CampaignActivities::find($lead->campaign_activity_id);
            $activity?->syncLeadCount();
        }
    }

    public function deleted(CampaignLead $lead)
    {
        if ($lead->campaign_activity_id) {
            $activity = CampaignActivities::find($lead->campaign_activity_id);
            $activity?->syncLeadCount();
        }
    }
}