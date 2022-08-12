<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sub_cat extends Model
{
   protected $table = 'sub_cat';
   protected $fillable = ['id','name','image','status','categories_id'];
   public $timestamps = false;

   public function products()
   {
       return $this->hasMany('App\models\product','sub_cat_id','id');
   }

}
