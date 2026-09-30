<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'name',
        'initial_amount',
        'target_amount',
        'deadline',
        'description',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
        'initial_amount' => 'decimal:2',
        'target_amount' => 'decimal:2',
    ];

    public function transactions()
    {
        return $this->hasMany(GoalTransaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Total depositado depois da criação da meta
    |--------------------------------------------------------------------------
    */

    public function getDepositedAmountAttribute()
    {
        return $this->transactions()
            ->where('type', 'deposit')
            ->sum('amount');
    }

    /*
    |--------------------------------------------------------------------------
    | Total retirado
    |--------------------------------------------------------------------------
    */

    public function getWithdrawnAmountAttribute()
    {
        return $this->transactions()
            ->where('type', 'withdrawal')
            ->sum('amount');
    }

    /*
    |--------------------------------------------------------------------------
    | Saldo atual da reserva
    |--------------------------------------------------------------------------
    */

    public function getCurrentAmountAttribute()
    {
        return
            $this->initial_amount
            + $this->deposited_amount
            - $this->withdrawn_amount;
    }

    /*
    |--------------------------------------------------------------------------
    | Valor final que queremos ter
    |--------------------------------------------------------------------------
    */

    public function getFinalTargetAttribute()
    {
        return
            $this->initial_amount
            + $this->target_amount;
    }


    public function getGoalProgressAmountAttribute()
    {
        return max(
            $this->current_amount - $this->initial_amount,
            0
        );
    }


    public function getRemainingAmountAttribute()
    {
        return max(
            $this->target_amount - $this->goal_progress_amount,
            0
        );
    }

    public function getProgressAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return min(
            ($this->goal_progress_amount / $this->target_amount) * 100,
            100
        );
    }
}
