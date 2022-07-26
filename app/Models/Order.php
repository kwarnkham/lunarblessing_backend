<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($order) {
            $user = $order->user;
            if (is_null($user->mobile)) $user->mobile = $order->mobile;
            if (is_null($user->address)) $user->address = $order->address;
            if ($user->isDirty()) $user->save();
        });
    }

    protected $guarded = ['id'];
    protected $with = ['items'];

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

    public function scopeOf($query, User $user)
    {
        $query->where('user_id', $user->id);
    }
}
