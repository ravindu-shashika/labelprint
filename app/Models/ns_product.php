<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ns_product extends Model
{
    use HasFactory;

    protected $table = 'ns_products';
    protected $guarded = [];

    public function attributes()
{
    return $this->hasOne(ns_products_attribute::class,'product_id','id');
}


}
