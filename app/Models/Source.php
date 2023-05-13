<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    /**
     * Scope a query to find source by name.
     */
    public function scopeFindByName(Builder $query, string $name)
    {
        return $query->where('name', $name)->first();
    }
}
