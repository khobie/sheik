<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollingStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_code','station_name','electoral_area_id','location','agent_name','agent_phone','voter_population'
    ];

    public function electoralArea(): BelongsTo
    {
        return $this->belongsTo(ElectoralArea::class);
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class);
    }
}
