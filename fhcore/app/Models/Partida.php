<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Partida
 * @package App\Models
 * @version December 24, 2023, 3:22 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $partidaTimes
 * @property string $nome
 * @property string|\Carbon\Carbon $data_partida
 * @property integer $qtd_jogadores_time
 * @property integer $times_gerados
 */
class Partida extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'partida';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nome',
        'data_partida',
        'qtd_jogadores_time',
        'times_gerados'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'data_partida' => 'datetime',
        'qtd_jogadores_time' => 'integer',
        'times_gerados' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nome' => 'required|string|max:200',
        'data_partida' => 'required',
        'qtd_jogadores_time' => 'required|integer',
        // 'times_gerados' => 'required|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function partidaTimes()
    {
        return $this->hasMany(\App\Models\PartidaTime::class, 'partida_id');
    }
}
