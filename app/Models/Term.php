<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Term extends Model
{
    //# traits ##
    use HasFactory,HasTranslations;

    //# properties ##
    protected $table = 'terms';

    protected $primaryKey = 'id';

    protected $perPage = 10;

    public $timestamps = true;

    public $incrementing = true;

    protected $fillable = [
        'key',
        'value',
    ];

    public $translatable = [
        'key',
        'value',
    ];
    //# relationships ##
    //# scopes ##
    //# accessors and mutators ##
    //# search ##
    //# filter ##
    //# sort ##
    //# spatie media library ##
    //# local scope ##
}
