<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'category_id',
        'description',
        'amount',
        'received_at',
        'observation',
    ];


    protected $casts = [
        'received_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
