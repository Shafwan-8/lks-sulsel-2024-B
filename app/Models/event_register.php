<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event_register extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_id',
        'status',
        'payment',
        'ticket_number',
    ];
}
