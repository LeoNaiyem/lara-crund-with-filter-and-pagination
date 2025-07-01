<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cattle extends Model
{
    protected $connection = 'mysql_noprefix';
    public $timestamps = false;
    protected $table = 'core_cattles';

    protected $fillable = ['name', 'region', 'dob', 'color', 'description', 'photo', 'gender', 'cattle_category_id'];
}