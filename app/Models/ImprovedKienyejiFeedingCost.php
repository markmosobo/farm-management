<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class ImprovedKienyejiFeedingCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'poultry_id','feed_type','quantity_bought','amount_paid'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }    
}
