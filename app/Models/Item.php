<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function feature()
    {
        return $this->hasOne(Feature::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
