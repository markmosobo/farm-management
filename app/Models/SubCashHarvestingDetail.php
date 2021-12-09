<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubCashHarvestingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'crop_id','date_of_harvesting','tools_used','tools_usagerate','harvest_quantity','acreage_harvested'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
