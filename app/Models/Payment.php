<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function scopeFilter(Builder $query, $filters)
    {
        $query->when(
            array_key_exists('active', $filters) ?? false,
            fn ($q, $active) => $q->where('active', $active)
        );
    }
}
