<?php

namespace App\Models;

use App\Services\Telegram;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($order) {
            $user = $order->user;
            if (is_null($user->mobile) && User::where('mobile', $order->mobile)->doesntExist()) $user->mobile = $order->mobile;
            if (is_null($user->name)) $user->name = $order->name;
            if (is_null($user->address)) $user->address = $order->address;
            if ($user->isDirty()) $user->save();
            Telegram::sendMessage("<a href='" . $order->url() . "'>New order</a>", 1391365941);
        });

        static::updated(function ($order) {
            $user = $order->user;
            if ($user->telegram_id && $user->telegram_notify) {
                $message = $message = "Your <a href='" . $order->url() . "'>order</a> has been";

                switch ($order->status) {
                    case 2:
                        $message .= " confirmed";
                        break;
                    case 3:
                        $message .= " dispatched";
                        break;
                    case 4:
                        $message .= " completed";
                        break;
                    default:
                        return;
                }
                Log::info($message);
                Telegram::sendMessage($message, $user->telegram_id);
            }
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
        return explode("X", $code)[1] ?? false;
    }

    public function url()
    {
        return config('app')['client'] . '/order-details/' . $this->id;
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

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['order_in'] ?? false, function ($q, $orderIn) {
            $q->orderBy('id', $orderIn);
        });

        $query->when($filters['status'] ?? false, function ($q, $status) {
            $q->where('status', $status);
        });

        $query->when($filters['mobile'] ?? false, function ($q, $mobile) {
            $q->where('mobile', $mobile);
        });

        $query->when($filters['code'] ?? false, function ($q, $code) {
            $id = static::codeToId($code);
            $q->where('id', $id);
        });
    }
}
