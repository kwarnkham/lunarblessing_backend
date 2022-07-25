<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot([
            'quantity', 'sale_price', 'text', 'dimmed_lid'
        ])->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
