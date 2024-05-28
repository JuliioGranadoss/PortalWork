<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Worker extends Model
{
    use HasFactory;

    protected $table = 'workers';

    protected $fillable = [
        'user_id',
        'file_id',
        'announcement',
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
        'phone2',
        'status',
        'driving_license_B',
        'driving_license_A',
        'job_id',
        'jobboard_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'announcement' => 'date:Y-m-d',
        'birth_date' => 'date:Y-m-d',
        'file_id' => 'int'
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

    public function getDrivingLicenseBLabel()
    {
        switch ($this->driving_license_B) {
            case 0:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-danger">No</span></h5>';
                break;
            case 1:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-success">Si</span></h5>';
                break;
            default:
                $label = 'Si';
                break;
        }
        return $label;
    }

    public function getDrivingLicenseALabel()
    {
        switch ($this->driving_license_A) {
            case 0:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-danger">No</span></h5>';
                break;
            case 1:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-success">Si</span></h5>';
                break;
            default:
                $label = 'Si';
                break;
        }
        return $label;
    }

    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }

    public function experiencies()
    {
        return $this->hasMany(Experience::class);
    }

    public function skills()
    {
        return $this->hasMany(Other::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'worker_offers', 'worker_id', 'offer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function jobBoard()
    {
        return $this->belongsTo(JobBoard::class, 'jobboard_id');
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
