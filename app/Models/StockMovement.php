<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $place_id
 * @property int    $personal_id
 * @property int    $status
 * @property string $created_at
 * @property string $updated_at
 */
class StockMovement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_movements';

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
        'place_id', 'personal_id', 'status', 'created_at', 'updated_at'
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
     * Get the status label.
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 0:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-danger">Inactivo</span></h5>';
                break;
            case 1:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-success">Activo</span></h5>';
                break;
            default:
                $label = 'Activo';
                break;
        }
        return $label;
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    // Relations
    public function place()
    {
        return $this->belongsTo(StockPlace::class, 'place_id');
    }

    public function personal()
    {
        return $this->belongsTo(StockPersonal::class, 'personal_id');
    }

    public function stockHistory()
    {
        return $this->hasMany(StockHistory::class, 'movement_id');
    }

}
