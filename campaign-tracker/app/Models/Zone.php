<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['zone_name','zone_code'];

    public function electoralAreas(): HasMany
    {
        return $this->hasMany(ElectoralArea::class);
    }
}
