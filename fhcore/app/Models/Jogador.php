<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Jogador
 * @package App\Models
 * @version December 23, 2023, 2:24 am UTC
 *
 * @property \App\Models\PosicaoTime $posicaoTime
 * @property \Illuminate\Database\Eloquent\Collection $timeJogadors
 * @property string $nome
 * @property integer $nivel
 * @property integer $posicao_time_id
 */
class Jogador extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'jogador';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nome',
        'nivel',
        'posicao_time_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'nivel' => 'integer',
        'posicao_time_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nome' => 'required|string|max:200',
        'nivel' => 'required|integer',
        'posicao_time_id' => 'required|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function posicaoTime()
    {
        return $this->belongsTo(\App\Models\PosicaoTime::class, 'posicao_time_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function timeJogadors()
    {
        return $this->hasMany(\App\Models\TimeJogador::class, 'jogador_id');
    }
}
