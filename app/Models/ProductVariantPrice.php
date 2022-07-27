<?php

namespace App\Models;
use App\Models\ProductVariant;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    protected $fillable = [
        'price', 'stock'
    ];

    public function productVariant(){
        return $this->hasMany(ProductVariant::class,'id','product_variant_one');
    }

}
