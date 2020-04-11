<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name', 'class_id',
    ];

    public function classes() {
        return $this->hasOne('App\Models\Classes', 'id', 'class_id');
    }
}
