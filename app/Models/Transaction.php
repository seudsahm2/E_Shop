<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'transactions';

    // The attributes that are mass assignable
    protected $fillable = [
        'transaction_id',
        'msisdn',
        'amount',
        'status',
    ];
}
