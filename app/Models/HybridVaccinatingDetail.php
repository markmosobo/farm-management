<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class HybridVaccinatingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'poultry_id','date_of_vaccinating','no_of_poultries',
        'vaccine_type','vaccine_quantity'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }    
}
