<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImprovedKienyejiProductOtherUse extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'date_of_retrieval','name','quantity_used'
    ];    
}
