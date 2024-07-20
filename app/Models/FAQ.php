<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    ## traits ##
    use HasFactory,HasTranslations;
    ## properties ##
    protected $table = 'faqs';
    protected $primaryKey = 'id';
    protected $perPage = 10;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'question',
        'answer'
    ];
    public $translatable = [
        'question',
        'answer'
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
