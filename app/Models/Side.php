<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Side extends Model
{
    //# traits ##
    use HasTranslations;

    //# properties ##
    protected $table = 'sides';

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
        return $this->belongsToMany(Product::class, 'product_side')->withTimestamps();
    }
    //# scopes ##
    //# accessors and mutators ##
    //# search ##
    //# filter ##
    //# sort ##
    //# spatie media library ##
    //# local scope ##
}
