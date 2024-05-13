<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'experiences';

    protected $fillable = [
        'worker_id',
        'name',
        'company',
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
        'start' => 'date:Y-m-d',
        'end' => 'date:Y-m-d'
    ];

    public function worker()
    {
        return $this->hasMany(Worker::class);
    }
}
