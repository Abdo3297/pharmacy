<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements HasMedia, FilamentUser
{
    ## traits ##
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    ## properties ##
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $perPage = 10;
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'email_verified_at',
        'gender',
        'is_admin',
        'birth',
        'provider',
        'provider_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];
    ## relationships ##
    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'users_favourites')->withTimestamps();
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    ## scopes ##
    ## accessors and mutators ##
    public function birth(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d'),
        );
    }
    ## search ##
    ## filter ##
    ## sort ##
    ## spatie media library ##
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('userProfile')->singleFile();
    }
    ## local scope ##
    public function scopeCurrentUser($query)
    {
        $query->where('id', auth()->user()->id);
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }
}
