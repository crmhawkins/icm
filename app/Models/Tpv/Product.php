<?php

namespace App\Models\Tpv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'image',
        'inactive',
    ];

    protected $attributes = [
        'inactive' => 0,
    ];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

