<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    protected $table = 'others';

    protected $fillable = [
        'name',
        'description',
        'score'
    ];

    public function worker()
    {
        return $this->hasMany(Worker::class);
    }
}