<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/9/14
 * Time: 09:49
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SysBase extends  Controller{

    public $user       = NULL;
    public $merId      = '';
    public $baseUri    = '';
    public $module     = ''; //功能 不分大小写
    public $controller = ''; //控制器
    public $className  = ''; //控制器 区分大小写
    public $action     = ''; //操作
    public $service    = NULL;

    public $data = [
        'pageTitle'  => '' , //页面title
        'jsLib'      => [] , //自定义js uri
        'cssLib'     => [] , //自定义css uri
        'param'      => [   //页面需要用到的参数
            'uri' => [] ,
        ] ,
        'initPageJs' => TRUE , //是否加载本页面 js
        'jsCode'     => [ //其余js代码
            //"Layout.setSidebarMenuActiveLink('match');"
        ] ,
    ];


    public function __construct(Request $request)
    {
        $routeAction = Route::currentRouteAction();
        $routes = $this->parseRouteAction($routeAction);
        $this->baseUri = config('backend.baseUri');
        $this->module = $routes['module'];
        $this->controller = $routes['controller'];
        $this->action = $routes['action'];

    }

    private function parseRouteAction($routeAction){
       // $routeAction = 'App\Http\Controllers\Backend\SysFunc@index';
        preg_match('/^App\\\Http\\\Controllers\\\(?P<module>\w+)\\\(?P<controller>\w+)@(?P<action>\w+)/', $routeAction, $matches);

        return $matches;
    }

    public function _init($pageTitle = '新页面'){
        $currentBaseUri = "{$this->baseUri}{$this->module}/{$this->controller}/";

        $this->data['param']['pageTitle'] = $pageTitle;
        $this->data['param']['uri']       = [
            'base'    => $this->baseUri ,
            'module'  => "{$this->baseUri}{$this->module}/index/index" ,
            'img'     => config( 'custom.imgUri' ) ,
            'menu'    => "" ,
            'this'    => full_uri( $currentBaseUri . $this->action ) ,
            'chPwd'   => full_uri( "{$this->baseUri}{$this->module}/auth/changePassword" ) ,
            'read'    => full_uri( $currentBaseUri . 'read' ) ,
            'insert'  => full_uri( $currentBaseUri . 'insert' ) ,
            'update'  => full_uri( $currentBaseUri . 'update' , [ 'id' => '' ] ) ,
            'destroy' => full_uri( $currentBaseUri . 'destroy' ) ,
        ];

    }

    public function _initClassName( $className ){

     //   $classNameArr    = explode( '/' , $className );
     //   $this->className = $classNameArr[ count( $classNameArr ) - 2 ];
        $this->className = $className;

    }


    /**
     * 生成页面js uri
     *
     * @return string
     */
    public function _getPageJsPath() {
        //$js_file_name = substr( preg_replace( '/[A-Z]/', '_\0', $this->className ), 1 );

        return "static/js/{$this->module}/{$this->className}.js";
    }

    public function _addJsLib($uri){
        $this->data['jsLib'][] = $uri;
    }

    public function _addJsCode($code){
        $this->data['jsCode'][] = $code;
    }

    public function _addCssLib($uri){
        $this->data['cssLib'][] = $uri;
    }

    public function _addCssCode($code){
        $this->data['jsCode'][] = $code;
    }

    public function _addParam( $key , $value = '' ){
        if ( is_array( $key ) ) {
            foreach ( $key as $k => $v ) {
                $this->data['param'][ $k ] = $v;
            }
        } else {
            if ( is_array( $value ) ) {
                if ( isset( $this->data['param'][ $key ] ) ) {
                    $this->data['param'][ $key ] = array_merge( $this->data['param'][ $key ] , $value );
                } else {
                    $this->data['param'][ $key ] = $value;
                }
            } else {
                $this->data['param'][ $key ] = $value;
            }
        }
    }

    public function _addData($key ,$value){
        if ( is_array( $key ) ) {
            foreach ( $key as $k => $v ) {
                $this->data[ $k ] = $v;
            }
        } else {
            if ( is_array( $value ) ) {
                if ( isset( $this->data[ $key ] ) ) {
                    $this->data[ $key ] = array_merge( $this->data[ $key ] , $value );
                } else {
                    $this->data[ $key ] = $value;
                }
            } else {
                $this->data[ $key ] = $value;
            }
        }
    }

    public function _makeJs(){
        $html = [];

        //引用页面JS文件
        if ( $this->data['initPageJs'] ) {
            $this->data['jsLib'][]  = $this->_getPageJsPath();
            $this->data['jsCode'][] = $this->className . '.init();';
        }
        foreach ( $this->data['jsLib'] as $item ) {
            $html[] = '<script src="' . $item . '" type="text/javascript"></script>';
        }

        $html[] = '<script type="text/javascript">';
        $html[] = 'var Param = ' . json_encode( $this->data['param'] );
        $html[] = '$(function(){';

        foreach ( $this->data['jsCode'] as $row ) {
            $html[] = $row;
        }

        $html[] = '});';
        $html[] = '</script>';

        return join( "\n" , $html );
    }

    public function _makeCss(){
        $html = [];
        foreach ( $this->data['cssLib'] as $item ) {
            $html[] = '<link href="' . $item . '" rel="stylesheet">';
        }

        return join( "\n" , $html );
    }

    public function _empty(){

    }

    public function upload(){

    }

    public function read_album(){

    }

    public function read_album_catalog(){

    }

    public function read_area(){

    }

    public function insert(){
        $data = request()->except('_token');
        return response()->json($this->service->insert($data));
    }

    public function update(){
        $id   = request()->id;
        $data = request()->except('_token');

        return response()->json( $this->service->update( $id , $data ) );
    }

    public function destroy(){
        $data = request()->all();
        return response()->json( $this->service->destroy( $data['ids']));
    }


}