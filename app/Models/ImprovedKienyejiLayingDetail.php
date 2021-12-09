<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class ImprovedKienyejiLayingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'poultry_id','poultry_code','no_of_eggs','date_of_laying'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }    
}
