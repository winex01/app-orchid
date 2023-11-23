<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'author',
        'hero',
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

    /**
     * Name of columns to which http filter can be applied
     *
     * @var array
     */
    protected $allowedFilters = [
        'title' => Like::class,
        'description' => Like::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Mutator for the 'hero' attribute
    public function setHeroAttribute($value)
    {
        $filteredValue = str_replace('//', '/', $value);
        $this->attributes['hero'] = $filteredValue;
    }
}
