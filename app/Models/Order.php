<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
            if (is_null($user->name)) $user->name = $order->name;
            if (is_null($user->address)) $user->address = $order->address;
            if ($user->isDirty()) $user->save();
        });
    }

    protected $guarded = ['id'];
    protected $with = ['items'];
    protected $appends = ['code'];

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn () => "#LBO066X" . $this->id . "X18" . $this->id * 49,
        );
    }

    public static function codeToId($code)
    {
        return explode("X", $code)[1];
    }


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

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function scopeOf($query, User $user)
    {
        if (!$user->isAdmin())
            $query->where('user_id', $user->id);
    }
}
