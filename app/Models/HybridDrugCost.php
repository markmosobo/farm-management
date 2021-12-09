<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class HybridDrugCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'poultry_id','drug_type','quantity_bought','amount_paid',
        'date_of_purchase'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }     
}
