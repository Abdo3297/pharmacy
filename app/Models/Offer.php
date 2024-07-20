<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    ## traits ##
    use HasFactory, HasTranslations;
    ## properties ##
    protected $table = 'offers';
    protected $primaryKey = 'id';
    protected $perPage = 10;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date'
    ];
    public $translatable = [
        'name'
    ];
    ## relationships ##
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'offer_product')->withTimestamps();
    }
    ## scopes ##
    ## accessors and mutators ##
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i:s'),
        );
    }
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i:s'),
        );
    }
    public function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i:s'),
        );
    }
    public function endDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i:s'),
        );
    }
    ## search ##
    ## filter ##
    ## sort ##
    ## spatie media library ##
    ## local scope ##
}
