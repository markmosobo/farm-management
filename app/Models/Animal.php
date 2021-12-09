<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id','name','type','description'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
