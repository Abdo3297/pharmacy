<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model implements HasMedia
{
    ## traits ##
    use HasFactory, InteractsWithMedia;
    ## properties ##
    protected $table = 'chats';
    protected $primaryKey = 'id';
    protected $perPage = 10;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];
    ## relationships ##
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    ## scopes ##
    ## accessors and mutators ##
    public function message(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value == null ? null : Crypt::decrypt($value),
            set: fn($value) => $value == null ? null : Crypt::encrypt($value)
        );
    }
    ## search ##
    ## filter ##
    ## sort ##
    ## spatie media library ##
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('chat');
    }
    ## local scope ##
}
