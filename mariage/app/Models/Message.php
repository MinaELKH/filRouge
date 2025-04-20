<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'status',
        'read_at',
        'created_at',
        'updated_at',
        'reservation_id',
        'service_id' // 👈 ajoute bien aussi celui-ci si tu l'utilises
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relation avec le destinataire (un utilisateur)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
