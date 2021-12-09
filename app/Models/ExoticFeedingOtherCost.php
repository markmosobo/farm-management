<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExoticFeedingOtherCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'amount_paid','name','date_of_payment'
    ];    
}
