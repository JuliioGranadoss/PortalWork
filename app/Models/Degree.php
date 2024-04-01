<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'degrees';

    protected $fillable = [
        'worker_id',
        'name',
        'institution',
        'start',
        'end',
        'score'
    ];

     /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'start' => 'date',
        'end' => 'date'
    ];

    public function worker()
    {
        return $this->hasMany(Worker::class);
    }
}
