<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/9/14
 * Time: 10:18
 */
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\SysFunc;

class Index extends Backend{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->_initClassName( $this->controller );
    }

    public function index(Request $request){
        $this->_init( '首页' );

      //  var_dump($request->server());exit;
       return $this->_displayWithLayout('index/index');

    }


}