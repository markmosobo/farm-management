<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubPreparingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'crop_id','date_of_preparing','tools_used',
        'activity','acreage_prepared'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
