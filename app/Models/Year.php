<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = [
        'name', 'image'
    ];

    public function classes() {
        return $this->hasMany(Classes::class, 'year_id');
    }
}
