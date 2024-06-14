<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $created_at
 * @property int    $quantity
 * @property int    $type
 * @property int    $updated_at
 * @property string $name
 * @property int    $movement_id
 * @property int    $place_id
 * @property int    $personal_id
 */
class StockHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_histories';

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
        'created_at', 'name', 'product_id', 'quantity', 'type', 'updated_at', 'movement_id', 'place_id', 'personal_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp', 'name' => 'string', 'quantity' => 'int', 'type' => 'int', 'updated_at' => 'timestamp'
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
     * Get the type label.
     */
    public function getTypeLabel()
    {
        switch ($this->type) {
            case 0:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-danger">Salida</span></h5>';
                break;
            case 1:
                $label = '<h5 class="text-center"><span class="badge badge-pill badge-success">Entrada</span></h5>';
                break;
            default:
                $label = 'Entrada';
                break;
        }
        return $label;
    }

    // Relations
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function movement()
    {
        return $this->belongsTo(StockMovement::class, 'movement_id');
    }

    public function place()
    {
        return $this->belongsTo(StockPlace::class, 'place_id');
    }

    public function personal()
    {
        return $this->belongsTo(StockPersonal::class, 'personal_id');
    }
}
