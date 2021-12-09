<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class CashHarvestingTransportCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'crop_id','transport_type','date_of_transaction','harvest_quantity','amount_paid'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
