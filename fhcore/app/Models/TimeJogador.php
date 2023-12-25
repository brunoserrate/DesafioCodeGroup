<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TimeJogador
 * @package App\Models
 * @version December 25, 2023, 12:00 am UTC
 *
 * @property \App\Models\Jogador $jogador
 * @property \App\Models\Time $time
 * @property integer $jogador_id
 * @property integer $time_id
 */
class TimeJogador extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'time_jogador';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'jogador_id',
        'time_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'jogador_id' => 'integer',
        'time_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'jogador_id' => 'required|integer',
        'time_id' => 'required|integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function jogador()
    {
        return $this->belongsTo(\App\Models\Jogador::class, 'jogador_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function time()
    {
        return $this->belongsTo(\App\Models\Time::class, 'time_id');
    }
}
