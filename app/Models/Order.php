<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    //# traits ##

    //# properties ##
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $perPage = 10;

    public $timestamps = true;

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_id',
        'payment_status',
        'payment_type',
    ];

    //# relationships ##
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items')->withPivot(['quantity', 'unit_price', 'total_price'])->withTimestamps();
    }

    //# scopes ##
    //# accessors and mutators ##
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

    //# search ##
    //# filter ##
    //# sort ##
    //# spatie media library ##
    //# local scope ##
    public function scopeOrderUser($query, int $userId)
    {
        $query->where('user_id', $userId);
    }
}
