<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class CashWeedingToolCost extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'crop_id','tool_type','quantity_bought','amount_paid','date_of_purchase'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
