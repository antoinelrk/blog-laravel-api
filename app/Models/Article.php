<?php

namespace App\Models;

use App\Models\Scopes\WithCategory;
use App\Traits\FileManager;
use App\Traits\SlugTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, FileManager, SlugTrait;

    protected static function booted ()
    {
        static::addGlobalScope(new WithCategory);
    }

    protected $fillable = [
        'title',
        'content_raw',
        'image_path',
        'category_id',
        'is_visible'
    ];

    public $hidden = [
        'image_path',
        'user_id',
        'category_id'
    ];

    public $appends = [
        'image',
        'slug'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public function getSlugAttribute (): string
    {
        return $this->id . '-' . Str::slug($this->title);
    }

    public function getImageAttribute (): string
    {
        return $this->ajustUrl($this->image_path);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }
}
