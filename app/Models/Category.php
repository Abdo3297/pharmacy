<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    //# traits ##
    use HasTranslations,InteractsWithMedia;

    //# properties ##
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $perPage = 10;

    public $timestamps = true;

    public $incrementing = true;

    protected $fillable = [
        'name',
    ];

    public $translatable = [
        'name',
    ];

    //# relationships ##
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product')->withTimestamps();
    }

    //# scopes ##
    //# accessors and mutators ##
    //# search ##
    //# filter ##
    //# sort ##
    //# spatie media library ##
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('categoryImages')->singleFile();
    }
    //# local scope ##
}
