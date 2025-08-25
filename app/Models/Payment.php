<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transbank_token',
        'status',
        'monto',
        'response_code',
        'authorization_code',
        'response_data',
    ];

    protected $casts = [
        'response_data' => 'array',
        'monto' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}