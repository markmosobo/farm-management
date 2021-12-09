<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class ImprovedKienyejiPoultrySale extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'date_of_sale','no_sold','amount_got','poultry_id'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }     
}
