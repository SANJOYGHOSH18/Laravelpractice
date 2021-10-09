<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    public $timestamps = false;

    protected $fillable = [
     'cid' , 'parent_id', 'prod_name', 'prod_price' , 'prod_variant' , 'item_no' , 'prod_image', 'prod_description'
    ];


}
