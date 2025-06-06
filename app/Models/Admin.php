<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
// use Ramsey\Uuid\Uuid;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    // uncomment this if use uuid in db
    // public $incrementing = false;
    // protected $primaryKey = 'id';
    // protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($model) {
        //     $model->{$model->getKeyName()} = Uuid::uuid6()->toString();
        // });
    }
    // protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    protected $appends = ["full_name", "image"];

    public function getFullNameAttribute()
    {
        return "{$this->name}";
    }
}
