<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeTitle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'degree_titles';

    protected $fillable = [
        'name',
        'score'
    ];

}
