<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Ramsey\Uuid\Uuid;

class User extends Authenticatable
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "phone",
        "image",
        // "remember_me",
        // "is_verified",
        "status",
    ];
    protected $appends = ["full_name"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "password" => "hashed",
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    // public function userOrders()
    // {
    //     return $this->hasMany(Order::class,"user_id","id");
    // }
}
