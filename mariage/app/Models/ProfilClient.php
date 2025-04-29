<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilClient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ville_id',
        'date_event',
        'budget',
        'budget_spent',
        'nombre_invites'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_event' => 'date',
        'budget' => 'decimal:2',
        'budget_spent' => 'decimal:2',
        'nombre_invites' => 'integer'
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ville associated with the profile.
     */
    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    /**
     * Get the remaining budget.
     *
     * @return float
     */
    public function getRemainingBudgetAttribute()
    {
        if (!$this->budget) {
            return 0;
        }

        $spent = $this->budget_spent ?: 0;
        return max(0, $this->budget - $spent);
    }

    /**
     * Get the budget spent percentage.
     *
     * @return float
     */
    public function getBudgetSpentPercentageAttribute()
    {
        if (!$this->budget || $this->budget <= 0) {
            return 0;
        }

        $spent = $this->budget_spent ?: 0;
        return min(100, ($spent / $this->budget) * 100);
    }
}
