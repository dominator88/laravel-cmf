<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SysUser extends Authenticatable
{
    use Notifiable;
    protected $table = 'sys_user';

    public $primaryKey = 'id';

    public $timestamps = FALSE;

    use \App\Traits\Service\Scope;

    public function username(){
        return 'username';
    }
}
