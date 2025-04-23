<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'personne_contact',
        'email',
        'telephone',
        'type_telephone',
        'adresse',
        'logo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
