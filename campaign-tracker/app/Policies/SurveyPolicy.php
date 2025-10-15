<?php

namespace App\Policies;

use App\Models\Survey;
use App\Models\User;

class SurveyPolicy
{
    public function view(User $user, Survey $survey): bool
    {
        if ($user->role === 'ADMIN') return true;
        if ($user->role === 'POLLING_AGENT') return $survey->user_id === $user->id;
        $surveyZoneId = optional($survey->pollingStation->electoralArea->zone)->id;
        if ($user->role === 'ZONAL_COORDINATOR') return $user->zone_id === $surveyZoneId;
        // Extend with area-based ownership as needed
        if ($user->role === 'AREA_COORDINATOR') return true; // placeholder
        return false;
    }
}
