<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCashHarvestingOtherCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'name','date_of_payment','amount_paid'
    ];

}
