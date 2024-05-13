<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @property int    $id
 * @property int    $position
 * @property int    $created_at
 * @property int    $updated_at
 * @property string $title
 * @property string $alt
 * @property string $description
 * @property string $source
 * @property string $filename
 * @property string $mime_type
 * @property string $slug
 */
class File extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

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
        'title', 'alt', 'description', 'source', 'filename', 'mime_type', 'position', 'status', 'slug', 'created_at', 'updated_at'
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
        'id' => 'int', 'title' => 'string', 'alt' => 'string', 'description' => 'string', 'source' => 'string', 'filename' => 'string', 'mime_type' => 'string', 'position' => 'int', 'slug' => 'string', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
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
     * The "booted" method of the model.
     */
    // protected static function booted(): void
    // {
    //     static::addGlobalScope('ancient', function (Builder $builder) {
    //         $builder->where('files.status', '>', -1);
    //     });
    // }

    public function worker()
    {
        return $this->hasOne(Worker::class);
    }
}
