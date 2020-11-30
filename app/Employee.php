<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'address',
        'salary', 'phone', 'join_date',
        'nid', 'image',
    ];
}
