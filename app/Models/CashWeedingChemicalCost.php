<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class CashWeedingChemicalCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'chemical_type','crop_id','date_of_purchase',
        'quantity_bought','amount_paid'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
