<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $pid 
 * @property int $seq 
 * @property string $name 
 * @property int $type 
 * @property string $path 
 * @property string $icon 
 * @property int $state 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pid', 'name', 'type', 'icon', 'path', 'state'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'pid' => 'integer', 'seq' => 'integer', 'type' => 'integer', 'state' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
