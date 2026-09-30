<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'description',
        'card_name',
        'installment_amount',
        'total_installments',
        'paid_installments',
        'due_day',
        'first_due_date',
        'status',
        'observation',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'first_due_date' => 'date',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
