<?php
/**
 * Created by PhpStorm.
 * User: MR.Z < zsh2088@gmail.com >
 * Date: 2017/9/21
 * Time: 09:43
 */
namespace  App\Traits\Service;

trait ScopeMer{

    public function scopeMerId($query , $param = ''){
        if($param)
            return $query->where('mer_id' , $param);
    }

}