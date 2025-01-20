<?php

namespace App\Models\Salones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'caja_salon';

    /**
     * Atributos asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'salon_id',
        'fecha',
        'monto',
        'admin_user_id',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
