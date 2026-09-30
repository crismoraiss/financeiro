<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    protected $fillable = [
        'person_name',
        'description',
        'amount',
        'due_date',
        'received_at',
        'status',
        'observation',
    ];

    protected $casts = [
        'due_date' => 'date',
        'received_at' => 'date',
    ];
}
