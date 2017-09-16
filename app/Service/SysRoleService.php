<?php
/**
 * SysRole Service
 *
 * @author MR.Z << zsh2088@gmail.com >>
 * @version 2.0 2017-09-15
 */

namespace App\Service;

use App\Models\SysRole;

class SysRoleService extends BaseService {

    //引入 GridTable trait
    use \App\Traits\Service\GridTable;


    //状态
    var $status = [
        0 => '禁用',
        1 => '启用',
    ];

    var $rank = [
        1  => '1级',
        2  => '2级',
        3  => '3级',
        4  => '4级',
        5  => '5级',
        6  => '6级',
        7  => '7级',
        8  => '8级',
        9  => '9级',
        10 => '10级',
    ];

    var $mp_rank = [
        1 => '1级',
        2 => '2级',
        3 => '3级',
        4 => '4级',
        5 => '5级',
    ];
    //类实例
    private static $instance;

    //生成类单例
    public static function instance() {
        if ( self::$instance == NULL ) {
            self::$instance        = new SysRoleService();
            self::$instance->model = new SysRole();
        }

        return self::$instance;
    }

    //取默认值
    function getDefaultRow() {
        return [
            'id'     => '',
            'sort'   => '99',
            'type'   => 'backend',
            'mer_id' => '0',
            'name'   => '',
            'status' => '1',
            'desc'   => '',
            'expand' => '',
            'rank'   => '1',
        ];
    }

    //根据条件查询
    function getByCond( $param ) {
        $default = [
            'field'    => '',
            'keyword'  => '',
            'status'   => '',
            'module'   => 'backend',
            'page'     => 1,
            'pageSize' => 10,
            'sort'     => 'id',
            'order'    => 'DESC',
            'count'    => FALSE,
            'getAll'   => FALSE
        ];

        $param = extend( $default, $param );

        if ( ! empty( $param['keyword'] ) ) {
            $this->model = $this->model->where( 'name', 'like', "%{$param['keyword']}%" );
        }

        $this->model->where( 'rank', 'lt', 10 );
        if ( $param['module'] !== '' ) {
            $this->model =  $this->model->where( 'module', $param['module'] );
        }

        if ( $param['status'] !== '' ) {
            $this->model = $this->model->where( 'status', $param['status'] );
        }


        if ( $param['count'] ) {
            return $this->model->count();
        } else {
       //     $this->model = $this->model->select( $param['field'] );

            if ( $param['getAll'] === FALSE ) {
              $this->model =  $this->model->skip( ( $param['page'] - 1 ) * $param['pageSize'])->take( $param['pageSize'] );
            }

           
            $this->model = $this->model->orderBy(  $param['order'] ,$param['sort'] );
            $data =  $this->model->get()->toArray();

            return $data;
            //echo $this->model->getLastSql();
        }
    }

    /**
     * 根据模块获取角色
     *
     * @param $module
     *
     * @return mixed
     */
    function getByModule( $module ) {

        $data = $this->model
            ->where( 'id', 'neq', config( 'superAdminId' ) )
            ->where( 'module', $module )
            ->order( 'rank desc' )
            ->get()->toArray();

        //echo $this->model->getLastSql();
        return $data ;
    }
}