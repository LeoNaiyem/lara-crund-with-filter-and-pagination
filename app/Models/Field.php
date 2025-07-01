<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'message',
        'gender',
        'uploaded_file',
        'country',
        'subscribe_newsletter',
        'birth_date',
        'age',
        'email'
    ];
}
