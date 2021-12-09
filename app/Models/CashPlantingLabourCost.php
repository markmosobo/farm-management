<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class CashPlantingLabourCost extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'date_of_work','crop_id','no_of_persons','amount_paid'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
