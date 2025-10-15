<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectoralArea extends Model
{
    use HasFactory;

    protected $fillable = ['area_name','area_code','zone_id'];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function pollingStations(): HasMany
    {
        return $this->hasMany(PollingStation::class);
    }
}
