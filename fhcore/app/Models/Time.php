<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Time
 * @package App\Models
 * @version December 24, 2023, 3:25 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $partidaTimes
 * @property \Illuminate\Database\Eloquent\Collection $timeJogadors
 * @property string $nome
 */
class Time extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'time';
    
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
        'nome' => 'required|string|max:200',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function partidaTimes()
    {
        return $this->hasMany(\App\Models\PartidaTime::class, 'time_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function timeJogadors()
    {
        return $this->hasMany(\App\Models\TimeJogador::class, 'time_id');
    }
}
