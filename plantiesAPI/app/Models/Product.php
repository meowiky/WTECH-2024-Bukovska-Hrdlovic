<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['stock_quantity', 'image_path', 'price', 'name', 'info', 'number_sold', 'care_level'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
