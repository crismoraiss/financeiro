<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'category_id',
        'description',
        'amount',
        'expense_type',
        'due_date',
        'paid_at',
        'status',
        'payment_method',
        'is_recurring',
        'observation',
        'installment_id',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'due_date' => 'date',
        'paid_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
