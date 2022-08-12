<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // protected $table = 'products';

    protected $fillable = ['id','name','price','code','stock','image','details','sub_cat_id'];
    public $timestamps = false;

    // protected $primayKey = 'product_id';

    public function getImageAttribute($value)
    {
        return url('/').'/uploads/products/'.$value;
    }
    
    public function sub_cat()
    {
       return $this->belongsTo('App\models\sub_cat','sub_cat_id','id');
    }
}
