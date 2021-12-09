<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class HybridFeedingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'poultry_id','date_of_feeding','feed_type',
        'feed_quantity','no_of_poultries'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }    
}
