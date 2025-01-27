<?php

namespace App\Models\Calendar;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Api extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'api_google';

    /**
     * Atributos asignados en masa. Por seguridad.
     *
     * @var array
     */
    protected $fillable = [
        'api_key'
    ];

    /**
     * Atributos que deben mutarse a fechas.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

}

