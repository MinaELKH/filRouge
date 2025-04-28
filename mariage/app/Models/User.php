<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function services()
    {
    return $this->hasMany(Service::class);
    }


    public function isBanned()
    {
        return $this->is_banned;
    }
    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isPrestataire()
    {
        return $this->role === 'prestataire';
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isClient()
    {
        return $this->role === 'client';
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedServices()
    {
        return $this->belongsToMany(Service::class, 'favorites', 'user_id', 'service_id')->withTimestamps();
    }
    public function isFavorite($serviceId)
    {
        return $this->favorites()->where('service_id', $serviceId)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
