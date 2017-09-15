<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/9/14
 * Time: 10:18
 */
namespace App\Http\Controllers\Backend;

use App\Service\SysFuncPrivilegeService;
use App\Service\SysFuncService;
use App\Service\SysRoleService;
use App\Service\SysRolePermissionService;

use Illuminate\Http\Request;


class SysRole extends Backend{
    /**
     * SysRole constructor.
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->_initClassName( $this->controller );

        $this->service = SysFuncService::instance();
    }

    //页面入口
    public function index(Request $request) {
        $this->_init( '系统角色管理' );

        //uri
        $this->_addParam( 'uri', [
            'getPermission'    => full_uri( 'backend/sysrole/get_permission' ),
            'updatePermission' => full_uri( 'backend/sysrole/update_permission' )
        ] );

        //查询参数
        $this->_addParam( 'query', [
            'keyword'  => $request->input( 'keyword', '' ),
            'status'   => $request->input( 'status', '' ),
            'page'     => $request->input( 'page', 1 ),
            'pageSize' => $request->input( 'pageSize', 10 ),
            'sort'     => $request->input( 'sort', 'id' ),
            'order'    => $request->input( 'order', 'DESC' ),
        ] );


        //其他参数
        $this->_addParam( [
            'defaultRow' => $this->service->getDefaultRow(),
            'status'     => $this->service->status,
            'rank'       => $this->service->rank
        ] );

        //需要引入的 css 和 js
        $this->_addJsLib( 'static/plugins/dmg-ui/TableGrid.js' );


        return $this->_displayWithLayout('sysrole/index');
    }

    //读取
    function read(Request $request) {
        $param = [
            'status'   => $request->input( 'status', '' ),
            'keyword'  => $request->input( 'keyword', '' ),
            'page'     => $request->input( 'page', 1 ),
            'pageSize' => $request->input( 'pageSize', 10 ),
            'sort'     => $request->input( 'sort', 'id' ),
            'order'    => $request->input( 'order', 'DESC' ),
        ];

        $data['rows']   = $this->service->getByCond( $param );
        $param['count'] = TRUE;
        $data['total']  = $this->service->getByCond( $param );

        return json( ajax_arr( '查询成功', 0, $data ) );
    }


    function get_permission(Request $request) {
        $roleId = $request->input( 'roleId' );

        $SysFuncPrivilege      = SysFuncPrivilegeService::instance();
        $data['privilegeName'] = $SysFuncPrivilege->name;
        //取角色操作权限
        $SysRolePermission    = SysRolePermissionService::instance();
        $ret['privilegeData'] = $SysRolePermission->getByRole( $roleId );

        //取所有功能与操作
        $SysFunc          = SysFuncService::instance();
        $data['funcData'] = $SysFunc->getByCond( [
            'module'        => 'backend',
            'status'        => 1,
            'withPrivilege' => TRUE,
        ] );


        $View = new View();

        $View->assign( $data );
        $ret['html'] = $View->fetch( 'permission' );

        return $ret;
    }

    //更新授权
    function update_permission(Request $request) {
        $roleId       = $request->input( 'roleId' );
        $privilegeArr = $request->input( 'privilegeArr' );

        $SysRolePermission = SysRolePermissionService::instance();
        $ret               = $SysRolePermission->updateRolePermission( $roleId, $privilegeArr );

        return response()->json( $ret );
    }



}