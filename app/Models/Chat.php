<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model implements HasMedia
{
    ## traits ##
    use HasFactory, InteractsWithMedia, BroadcastsEvents;
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
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
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
    ## broadcast ##
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chatRoom'),
        ];
    }
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'mediaUrls' => $this->getMedia('chat')->map(function ($media) {
                return $media->getUrl();
            })->toArray()
        ];
    }
}
