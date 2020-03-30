<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $ptype 
 * @property string $v0 
 * @property string $v1 
 * @property string $v2 
 * @property string $v3 
 * @property string $v4 
 * @property string $v5 
 */
class CasbinRule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'casbin_rule';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer'];
}