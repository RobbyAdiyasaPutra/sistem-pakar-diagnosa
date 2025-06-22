<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; // Tambahkan ini jika menggunakan slug otomatis

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_url',
        'tags',
        'author_id',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    /**
     * The "booted" method of the model.
     * Digunakan untuk otomatis membuat slug saat disimpan.
     */
    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            $article->slug = Str::slug($article->title);
        });

        static::updating(function (Article $article) {
            if ($article->isDirty('title')) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get the author (user) of the article.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}