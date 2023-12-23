<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PosicaoTime
 * @package App\Models
 * @version December 23, 2023, 3:37 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $jogadors
 * @property string $nome
 */
class PosicaoTime extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'posicao_time';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nome'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nome' => 'required|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jogadors()
    {
        return $this->hasMany(\App\Models\Jogador::class, 'posicao_time_id');
    }
}
