<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['pictures'];

    public function feature()
    {
        return $this->hasOne(Feature::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }
}
