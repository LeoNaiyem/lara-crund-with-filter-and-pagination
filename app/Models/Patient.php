<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'mobile', 'dob', 'mob_ext', 'gender', 'profession'];
    public $timestamps=false;
}