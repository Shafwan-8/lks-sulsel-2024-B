<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'date_start',
        'date_end',
        'price',
        'description',
    ];
}
