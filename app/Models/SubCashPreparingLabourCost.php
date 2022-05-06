<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubCashPreparingLabourCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'crop_id','date_of_work','no_of_persons',
        'amount_paid'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
