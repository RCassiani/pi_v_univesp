<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name', 'class_id',
    ];

    public function classe() {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id');
    }

    public function getYearClassAttribute() {
        return $this->classe()->first()->year()->first()->name . " - " . $this->classe()->first()->name;
    }
}
