<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerGoodsCatalog extends Model
{
    public $table = 'mer_goods_catalog';

    public $primaryKey = 'id';

    public $timestamps = false;

    use \App\Traits\Service\Scope,\App\Traits\Service\ScopeMer;

    public function scopeKeyword($query , $param){
        if($param !== '')
            return $query->where('text' , 'like' , "%{$param}%");
    }
    //
}
