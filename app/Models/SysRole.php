<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysRole extends Model
{
    public $table = 'sys_role';

    public $primaryKey = 'id';

    public $timestamps = false ;

    use \App\Traits\Service\Scope;
}
