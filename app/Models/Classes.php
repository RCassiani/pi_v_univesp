<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'name', 'image', 'year_id'
    ];

    public function subjects() {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function year() {
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }

    public function getYearClassAttribute() {
        return $this->year()->first()->name . " - " . $this->name;
    }
}
