<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'image', "price", "type"
    ];


    // concatenate "R" or "ZAR" currency to the price 
    public function getPriceAttribute($v)
    {
        return  $v;
    }
}