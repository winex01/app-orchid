<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, AsSource;
    use Filterable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'author'
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'title',
        'description',
        'body',
        'author'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
