<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $code
 */
class Barcode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'barcodes';

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
        'code', 'product_id'
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
        'code' => 'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Relations

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}