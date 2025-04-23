<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'status',
    ];
    // Définir la relation avec le modèle Item
    public function devisItems()
    {
        return $this->hasMany(devisItem::class);
    }

    // Relation avec la réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    protected function prestataire(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation->service->user,
        );
    }

    // Relation avec le client via la réservation
    public function client()
    {
        return $this->hasOneThrough(
            User::class,
            Reservation::class,
            'id',         // Clé primaire de la table reservations
            'id',         // Clé primaire de la table users
            'reservation_id', // Clé étrangère dans la table devis
            'user_id'     // Clé étrangère dans la table reservations
        );
    }

    // Relation avec le service via la réservation
    public function service()
    {
        return $this->hasOneThrough(
            Service::class,
            Reservation::class,
            'id',         // Clé primaire de la table reservations
            'id',         // Clé primaire de la table services
            'reservation_id', // Clé étrangère dans la table devis
            'service_id'  // Clé étrangère dans la table reservations
        );
    }
    protected function category(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation->service->category,
        );
    }


    public function getTotalAmountAttribute()
    {
        return $this->devisItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

}
