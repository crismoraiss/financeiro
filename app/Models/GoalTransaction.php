<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalTransaction extends Model
{
    protected $fillable = [
        'goal_id',
        'type',
        'amount',
        'transaction_date',
        'observation',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
