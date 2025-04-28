<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'cover_image',
        'gallery',
        'category_id',
        'user_id',
        'ville_id',
        'status'
    ];

    protected $casts = [
        'gallery' => 'array',
        'archived' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);  // Une relation one-to-many
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'service_id', 'user_id')->withTimestamps();
    }
}

