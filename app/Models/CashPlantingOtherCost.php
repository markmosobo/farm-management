<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashPlantingOtherCost extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'date_of_payment','name','amount_paid'
    ];    
}
