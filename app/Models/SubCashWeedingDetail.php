<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubCashWeedingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'crop_id','date_of_weeding','acreage_weeded','chemical_type',
        'chemical_quantity','tools_used'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
