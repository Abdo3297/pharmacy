<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Pharmacy extends Model implements HasMedia
{
    use HasFactory,HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'name',
    ];

    public $translatable = [
        'name',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pharmacyLogo')->singleFile();
        $this->addMediaCollection('pharmacyCarousel');
    }
}
