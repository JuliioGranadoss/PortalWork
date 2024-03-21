<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Worker extends Model
{
    use HasFactory;

    protected $table = 'workers';

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'dni',
        'email',
        'birth_date',
        'description',
        'address',
        'postal_code',
        'province',
        'location',
        'phone',
        'status'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date'
    ];

    /**
     * Get the status label.
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 0:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-danger">Baja</span></h5>';
                break;
            case 1:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-success">Alta</span></h5>';
                break;
            default:
                $label = 'Alta';
                break;
        }
        return $label;
    }

    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'worker_offers', 'worker_id', 'offer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('workers.status', '>', -1);
        });
    }

}
