<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'event_date',
        'status'
    ];

    /*
     * client
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // je utlise ca dans generet de pdf

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
