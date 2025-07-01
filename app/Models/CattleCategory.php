<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CattleCategory extends Model
{

    protected $connection = 'mysql_noprefix';
    public $timestamps = false;
    protected $table = 'core_cattle_categories';
    public $fillable = ['name'];
}
