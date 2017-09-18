<?php
/**
 * Created by PhpStorm.
 * User: MR.Z < zsh2088@gmail.com >
 * Date: 2017/9/18
 * Time: 15:34
 */
namespace App\Service;



use App\Models\SysArea;

class SysAreaService extends BaseService {

    //引入 GridTable trait
    use \App\Traits\Service\GridTable;


    //状态
    public $status = [
        0 => '禁用',
        1 => '启用',
    ];

    //类实例
    private static $instance;

    //生成类单例
    public static function instance() {
        if ( self::$instance == NULL ) {
            self::$instance        = new SysAreaService();
            self::$instance->model = new SysArea();
        }

        return self::$instance;
    }

    //取默认值
    function getDefaultRow() {
        return [
            'id'     => '',
            'pid'    => '',
            'text'   => '',
            'tip'    => '',
            'status' => '0',
            'level'  => '0',
        ];
    }

    /**
     * 根据条件查询
     *
     * @param $param
     *
     * @return array|number
     */
    function getByCond( $param ) {
        $default = [
            'field'    => [],
            'keyword'  => '',
            'pid'      => '',
            'status'   => '',
            'page'     => 1,
            'pageSize' => 10,
            'sort'     => 'id',
            'order'    => 'ASC',
            'count'    => FALSE,
            'getAll'   => FALSE
        ];

        $param = extend( $default, $param );
        $this->model = $this->model->keyword( $param['keyword'])->status($param['status'])->pid($param['pid'])->getAll($param);


        if ( $param['count'] ) {
            return $this->model->count();
        }


        $data =  $this->model->orderBy( $param['sort'] ,  $param['order'])->get()->toArray();



        //echo $this->model->getLastSql();

        return $data ? $data : [];
    }

}