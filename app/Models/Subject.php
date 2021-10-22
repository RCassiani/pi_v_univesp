<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'class_id',
    ];

    public function classe()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id');
    }

    public function getYearClassAttribute()
    {
        return $this->classe()->first()->year_class;
    }
}
