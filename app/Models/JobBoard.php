<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBoard extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'job_boards';

    protected $fillable = [
        'name',
        'init',
        'end'
    ];
}
