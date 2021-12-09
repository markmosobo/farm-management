<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubCashCropSale extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'crop_id','quantity_sold','date_of_selling',
        'name_of_buyer','amount_due'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
