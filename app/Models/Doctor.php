<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'department_id', 'designation_id', 'phone', 'photo'];

    public function department(){
        return $this->belongsTo(Designation::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }
}