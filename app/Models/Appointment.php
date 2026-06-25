<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'institution',
        'demo_date',
        'demo_time',
        'notes',
        'status',
    ];
}
