<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pharmacy extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia, HasTranslations;
    protected $fillable = [
        'name'
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
