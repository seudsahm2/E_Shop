<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'country',
        'address',
        'town',
        'zipcode',
        'phone_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
