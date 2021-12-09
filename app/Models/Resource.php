<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'owner_id','name'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
