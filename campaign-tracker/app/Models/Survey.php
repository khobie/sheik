<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','polling_station_id','support_level','supporters_count','key_issues','specific_concerns','follow_up_required','follow_up_action','survey_notes','survey_date'
    ];

    protected $casts = [
        'follow_up_required' => 'boolean',
        'survey_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pollingStation(): BelongsTo
    {
        return $this->belongsTo(PollingStation::class);
    }
}
