<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Ramsey\Uuid\Uuid;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // public $incrementing = false;
    // protected $primaryKey = "id";
    // protected $keyType = "string";

    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($model) {
        //     $model->{$model->getKeyName()} = Uuid::uuid6()->toString();
        // });
    }

    protected $fillable = [
        "name",
        "email",
        "email_verified_at",
        "password",
        "image",
    ];

    protected $casts = [
        "password" => "hashed",
    ];
    protected $appends = ["full_name","image"];

    public function getFullNameAttribute()
    {
        return "{$this->name}";
    }

    // public function userStore()
    // {
    //     return $this->hasOne(Store::class,"seller_id","id");
    // }

    // public function sellerOrders()
    // {
    //     return $this->hasMany(OrderProduct::class,"seller_id","id");
    // }
}
