<?php

namespace App\Models;

use App\Models\User;
use App\Orchid\Filters\EmailFilter;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $guarded = [];

    protected $allowedFilters = [
        'name' => Like::class,
        'user.email' => Like::class,
    ];

    protected $filtersApply = [
        'user.email'=> EmailFilter::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
