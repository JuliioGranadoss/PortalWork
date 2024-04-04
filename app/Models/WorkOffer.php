<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOffer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'worker_offers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'worker_id',
        'offer_id',
    ];

    /**
     * Get the worker associated with the worker offer.
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * Get the offer associated with the worker offer.
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
