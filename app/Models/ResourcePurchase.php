<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;

class ResourcePurchase extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'resource_id','date_of_purchasing','purchase_quantity',
        'amount_paid','source_of_purchase'
    ];

    public function resource()
    {
       return $this->belongsTo(Resource::class);
    }
}
