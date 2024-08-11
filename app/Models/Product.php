<?php

namespace App\Models;

use App\Models\Filters\PriceFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Lacodix\LaravelModelFilter\Enums\SearchMode;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;
use Lacodix\LaravelModelFilter\Traits\IsSortable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    //# traits ##
    use HasFilters, HasTranslations, InteractsWithMedia, IsSearchable, IsSortable;

    //# traits ##
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $perPage = 10;

    public $timestamps = true;

    public $incrementing = true;

    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'no_units',
        'barcode',
        'stock',
        'alert',
    ];

    public $translatable = [
        'name',
        'description',
    ];

    //# relationships ##
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
    }

    public function sideEffects(): BelongsToMany
    {
        return $this->belongsToMany(Side::class, 'product_side')->withTimestamps();
    }

    public function indications(): BelongsToMany
    {
        return $this->belongsToMany(Indication::class, 'indication_product')->withTimestamps();
    }

    public function favouritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_favourites')->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')->withTimestamps();
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'offer_product')->withTimestamps();
    }

    //# scopes ##
    //# accessors and mutators ##
    //# search ##
    protected array $searchable = [
        'name' => SearchMode::LIKE,
        'barcode' => SearchMode::EQUAL,
    ];

    //# filter ##
    protected array $filters = [
        PriceFilter::class,
    ];

    //# sort ##
    protected array $sortable = [
        'name',
        'unit_price',
    ];

    //# spatie media library ##
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('productImages')->singleFile();
    }
    //# local scope ##
}
