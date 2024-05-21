<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int    $status
 */
class StockPlace extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_places';

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
        'name', 'status'
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
    public $timestamps = false;
}
