<?php
/**
 * Created by PhpStorm.
 * User: MR.Z < zsh2088@gmail.com >
 * Date: 2017/9/16
 * Time: 13:34
 */


namespace App\Service;

use App\Models\SysUser;
use App\Models\SysUserRole;
use Illuminate\Support\Facades\DB;


class SysUserService extends BaseService {

    //引入 GridTable trait
    use \App\Traits\Service\GridTable;

    //状态
    public $status = [
        0 => '禁用' ,
        1 => '启用' ,
    ];

    //类实例
    private static $instance;

    //生成类单例
    public static function instance() {
        if ( self::$instance == NULL ) {
            self::$instance        = new SysUserService();
            self::$instance->model = new SysUser();

        }

        return self::$instance;
    }

    /**
     * 取默认值
     *
     * @return array
     */
    function getDefaultRow() {
        return [
            'id'         => '' ,
            'module'     => 'backend' ,
            'username'   => '' ,
            'password'   => '' ,
            'icon'       => '' ,
            'email'      => '' ,
            'phone'      => '' ,
            'status'     => '1' ,
            'token'      => '' ,
            'created_at' => date( 'Y-m-d H:i:s' )
        ];
    }

    /**
     * 根据条件查询
     *
     * @param $params
     *
     * @return array|number
     */
    public function getByCond( $params ) {
        $default = [
            'field'     => [ '*' ] ,
            'module'    => 'backend' ,
            'keyword'   => '' ,
            'status'    => '' ,
            'merId'     => '' ,
            'page'      => 1 ,
            'pageSize'  => 10 ,
            'sort'      => 'id' ,
            'order'     => 'DESC' ,
            'getAll'    => FALSE ,
            'count'     => FALSE ,
            'withPwd'   => FALSE ,
            'withRoles' => FALSE ,
            'merchant'  => FALSE
        ];

        $params = extend( $default , $params );

        if ( $params['merchant'] ) {
            return $this->getMerSysUserByCond( $params );
        }

        $this->model = $this->model->status($params['status'])->module($params['module'])->keyword($params['keyword']);




        if ( $params['count'] ) {
            return $this->model->count();
        } else {
            $data =  $this->model
                 ->orderBy( $params['sort'] ,  $params['order'])->get()->toArray();

        }


        if ( ! $params['withPwd'] ) {
            foreach ( $data as &$item ) {
                unset( $item['password'] );
            }
        }

        if ( $params['withRoles'] ) {
            $data = $this->getRoles( $data );
        }

        return $data ? $data : [];
    }

    /**
     * todo 需要优化
     *
     * @param $data
     *
     * @return mixed
     */
    private function getRoles( $data ) {
        $SysUserRole = SysUserRoleService::instance();

        foreach ( $data as &$item ) {
            $item['roles'] = $SysUserRole->getByUser( $item['id'] );
        }

        return $data;
    }

    /**
     * 获取 MP 平台用户
     *
     * @param $params
     *
     * @return array
     */
    private function getMerSysUserByCond( $params ) {
        $model = db( 'mer_sys_user' );

        $model->alias( 'msu' )
            ->where( 'msu.mer_id' , $params['merId'] )
            ->join( 'sys_user u' , 'u.id = msu.sys_user_id' , 'left' );

        if ( $params['status'] !== '' ) {
            $model->where( 'u.status' , $params['status'] );
        }

        if ( $params['count'] ) {
            return $model->count();
        } else {
        //    $model->field( 'u.*' );

            if ( ! $params['getAll'] ) {
                $model->limit( ( $params['page'] - 1 ) * $params['pageSize'] , $params['pageSize'] );
            }


            $model->orderBy("u.{$params['sort']}", "{$params['order']}");

            $data = $model->get()->toArray();
//      echo $model->getLastSql();
        }

        if ( ! $params['withPwd'] ) {
            foreach ( $data as &$item ) {
                unset( $item['password'] );
            }
        }

        if ( $params['withRoles'] ) {
            $data = $this->getRoles( $data );
        }

        return $data ? $data : [];

    }

    /**
     * 更新密码
     *
     * @param $id
     * @param $data
     *
     * @return array
     */
    function uploadPwd( $id , $data ) {
        try {
            $this->model->where( 'id' , $id )->update( $data );

            return ajax_arr( '更新成功' , 0 );
        } catch ( \Exception $e ) {
            //echo $this->model->getLastSql();
            return ajax_arr( $e->getMessage() , 500 );
        }
    }

    /**
     * 添加数据
     *
     * @param $data
     *
     * @return array
     */
    public function insert( $data ) {
        DB::beginTransaction();
        try {
            if ( empty( $data ) ) {
                throw new \Exception( '数据不能为空' );
            }

            $roles = isset( $data['roles'] ) ? $data['roles'] : [];
            unset( $data['roles'] );
            $data['password'] = str2pwd( config( 'defaultPwd' ) );

            $id = $this->model->insertGetId( $data );
            if ( $id <= 0 ) {
                throw new \Exception( '创建用户失败' );
            }

            //更新用户角色
            if ( ! empty( $roles ) ) {
                $SysUserRole = SysUserRoleService::instance();
                $RoleResult  = $SysUserRole->updateByUser( $id , $roles );
                if ( $RoleResult['code'] > 0 ) {
                    throw new \Exception( $RoleResult['msg'] );
                }
            }

            DB::commit();

            return ajax_arr( '创建用户成功' , 0 , [ 'id' => $id ] );
        } catch ( \Exception $e ) {
            DB::rollback();

            return ajax_arr( $e->getMessage() , 500 );
        }
    }


    //更新
    function update( $id , $data ) {
        DB::beginTransaction();
        try {
            $roles = [];
            if ( isset( $data['roles'] ) ) {
                $roles = $data['roles'];
            }

            unset( $data['roles'] );
            $ret = $this->model->where( 'id' , $id )->update( $data );

            //更新用户角色
            $SysUserRole = SysUserRoleService::instance();
            $RoleResult  = $SysUserRole->updateByUser( $id , $roles );
            if ( $RoleResult['code'] > 0 ) {
                throw new \Exception( $RoleResult['msg'] );
            }

            DB::commit();

            return ajax_arr( '更新成功' , 0 );
        } catch ( \Exception $e ) {
            DB::rollback();

            //echo $this->model->getLastSql();
            return ajax_arr( $e->getMessage() , 500 );
        }
    }

    /**
     * 删除系统用户
     *
     * @param $id
     *
     * @return array
     */
    public function destroy( $id ) {
        try {
            if ( $id <= 2 ) {
                throw new \Exception( '系统用户不能删除' );
            }
            $model_user_role = new SysUserRole();
            //删除用户角色
            $model_user_role->destroy($id);

            //删除用户
            $this->model->destroy($id);

            return ajax_arr( '删除成功' , 0 );
        } catch ( \Exception $e ) {
            return ajax_arr( $e->getMessage() , 500 );
        }
    }

    /**
     * 重置密码
     *
     * @param $id
     * @param $pwd
     *
     * @return array
     */
    public function resetPwd( $id , $pwd ) {
        try {
            $data['password'] = str2pwd( $pwd );
            $row              = $this->model->where( 'id' , $id )->update( $data );
            if ( $row <= 0 ) {
                return ajax_arr( '未修改任何记录' , 500 );
            }

            return ajax_arr( '重置密码成功' , 0 );
        } catch ( \Exception $e ) {
            return ajax_arr( $e->getMessage() , 500 );
        }
    }
}