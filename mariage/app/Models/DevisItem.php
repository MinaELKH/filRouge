<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'devis_id',
        'service_name',
        'quantity',
        'unit_price',

    ];

    /**
     * Relation avec la table Devis
     */
    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }
    //prix de items
// app/Models/DevisItem.php

    public function getAmountAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

}
