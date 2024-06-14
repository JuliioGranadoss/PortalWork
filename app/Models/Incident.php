<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 * @property string $description
 * @property int    $priority
 * @property int    $status
 * @property int    $created_at
 * @property int    $updated_at
 */
class Incident extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'incidents';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'creator_id', 'assigned_id', 'priority', 'status', 'created_at', 'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string', 'description' => 'string', 'priority' => 'int', 'status' => 'int', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * Get the status label.
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 1:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-warning">No asignado</span></h5>';
                break;
            case 2:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-primary">En progreso</span></h5>';
                break;
            case 3:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-info">En pausa</span></h5>';
                break;
            case 4:
                $label = '<h5 class="text-center"><span class="badge badge-pill success">Resuelto</span></h5>';
                break;

            default:
                $label = 'No asignado';
                break;
        }
        return $label;
    }

    /**
     * Get the priority label.
     */
    public function getPriorityLabel()
    {
        switch ($this->priority) {
            case 1:
                $label = '<h5 class="text-center text-danger"><i class="fa fas fa-chevron-circle-up"></i></h5>';
                break;
            case 2:
                $label = '<h5 class="text-center text-warning"><i class="fas fa-chevron-up"></i></h5>';
                break;
            case 3:
                $label = '<h5 class="text-center text-primary"><i class="fas fa-chevron-down"></i></h5>';
                break;

            default:
                $label = 'Baja';
                break;
        }
        return $label;
    }

    /**
     * Get the user.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user.
     */
    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('incidents.status', '>', -1);
        });
    }
}
