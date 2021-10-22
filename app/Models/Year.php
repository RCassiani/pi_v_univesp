<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'image'
    ];

    public function classes() {
        return $this->hasMany(Classes::class, 'year_id');
    }
}
