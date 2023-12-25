<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PartidaTime
 * @package App\Models
 * @version December 25, 2023, 12:10 am UTC
 *
 * @property \App\Models\Partida $partida
 * @property \App\Models\Time $time
 * @property integer $partida_id
 * @property integer $time_id
 */
class PartidaTime extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'partida_time';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'partida_id',
        'time_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'partida_id' => 'integer',
        'time_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'partida_id' => 'required|integer',
        'time_id' => 'required|integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function partida()
    {
        return $this->belongsTo(\App\Models\Partida::class, 'partida_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function time()
    {
        return $this->belongsTo(\App\Models\Time::class, 'time_id');
    }
}
