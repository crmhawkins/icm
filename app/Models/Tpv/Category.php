<?php

namespace App\Models\Tpv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_category';

    protected $fillable = [
        'name',
        'inactive',
        'image',
    ];

    protected $attributes = [
        'inactive' => 0,
    ];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}


