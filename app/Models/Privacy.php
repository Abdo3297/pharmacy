<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Privacy extends Model
{
    ## traits ##
    use HasFactory,HasTranslations;
    ## properties ##
    protected $table = 'privacies';
    protected $primaryKey = 'id';
    protected $perPage = 10;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'content',
    ];
    public $translatable = [
        'content'
    ];
    ## relationships ##
    ## scopes ##
    ## accessors and mutators ##
    ## search ##
    ## filter ##
    ## sort ##
    ## spatie media library ##
    ## local scope ##
}
