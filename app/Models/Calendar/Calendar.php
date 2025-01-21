<?php

namespace App\Models\Calendar;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'calendar_feed';

    /**
     * Atributos asignados en masa. Por seguridad.
     *
     * @var array
     */
    protected $fillable = [
        'googleCalendarId',
        'color',
        'textColor',
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

