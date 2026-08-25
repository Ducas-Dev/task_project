<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task',
        'description',
        'status',
        'priorite',
        'date_echeance'
    ];
}
