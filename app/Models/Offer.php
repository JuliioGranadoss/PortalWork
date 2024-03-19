<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'status'
    ];

    
    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'worker_offers', 'offer_id', 'worker_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('offers.status', '>', -1);
        });
    }

}
