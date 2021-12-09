<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poultry;

class KienyejiTreatingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'poultry_id','date_of_treating','no_of_poultries',
        'drug_type','drug_quantity'
    ];

    public function poultry()
    {
        return $this->belongsTo(Poultry::class);
    }     
}
