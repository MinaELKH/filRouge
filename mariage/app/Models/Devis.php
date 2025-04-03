<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'total_amount',
        'status',
    ];

    /**
     * Relation avec la table Reservations
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Relation avec la table DevisItems
     */
    public function devisItems()
    {
        return $this->hasMany(DevisItem::class);
    }
}
