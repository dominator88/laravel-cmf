<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerAlbumCatalog extends Model
{
    public $table = 'mer_album_catalog';

    public $primaryKey = 'id';

    public $timestamps = FALSE;

    use \App\Traits\Service\Scope;

    public function scopeKeyword( $query , $param){
        if($param)
            return $query->where('name' , 'like' , "%{$param}%");
    }

    public function scopeMerId( $query , $param){
        if($param === ''){
            return $query->whereNull('mer_id');
        }else{
            return $query->where('mer_id' , $param);
        }
    }
    //
}
