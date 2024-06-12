<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'others';

    protected $fillable = [
        'worker_id',
        'name',
        'description',
    ];

    public function worker()
    {
        return $this->hasMany(Worker::class);
    }
}
