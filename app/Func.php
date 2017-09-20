<?php
if ( ! function_exists( 'full_uri' ) ) {
    function full_uri( $uri , $param = [] ) {
        return url( strtolower($uri) , $param  );
    }
}

if ( ! function_exists( 'extend' ) ) {
    /**
     * 扩展数组
     *
     * @param $config
     * @param $default
     *
     * @return mixed
     */
    function extend( $default , $config ) {
        foreach ( $default as $key => $val ) {
            if ( ! isset( $config [ $key ] ) || $config[ $key ] === '' ) {
                $config [ $key ] = $val;
            } else if ( is_array( $config [ $key ] ) ) {
                $config [ $key ] = extend( $val , $config [ $key ] );
            }
        }

        return $config;
    }
}

if ( ! function_exists( 'form_radios' ) ) {
    /**
     * 水平radios
     *
     * @param $name
     * @param $data
     * @param int $checked_value
     *
     * @return mixed|string
     */
    function form_radios( $name , $data , $checked_value = 0 ) {
        $html = '';
        foreach ( $data as $key => $val ) {
            $html .= '<label class="radio-inline"><input name="' . $name . '" type="radio" value="' . $key . '" >' . $val . '</label>';
        }

        if ( $checked_value >= 0 ) {
            $html = str_replace( 'value="' . $checked_value . '"' , "value='$checked_value' checked" , $html );
        }

        return $html;
    }
}

if ( ! function_exists( "ajax_arr" ) ) {
    /**
     * 生成需要返回 ajax 数组
     *
     * @param $msg        //消息
     * @param int $code   //0 正常 , > 0 错误
     * @param array $data //需要传递的参数
     *
     * @return array
     */
    function ajax_arr( $msg , $code = 500 , $data = [] ) {
        $arr = [
            'msg'  => $msg ,
            'code' => $code ,
        ];

        if ( $data !== '' ) {
            $arr['data'] = $data;
        }

        return $arr;
    }
}

if ( ! function_exists( 'form_options' ) ) {
    /**
     * 生成下拉选项
     *
     * @param $data
     * @param int $selected_value
     *
     * @return mixed|string
     */
    function form_options( $data , $selected_value = - 1 ) {
        $html = '';
        foreach ( $data as $key => $val ) {
            $html .= "<option value='$key'>$val</option>";
        }

        if ( $selected_value >= 0 ) {
            $html = str_replace( "value='$selected_value'" , "value='$selected_value' selected" , $html );
        }

        return $html;
    }

}

if ( ! function_exists( 'form_checkbox_rows' ) ) {
    /**
     * checkbox
     *
     * @param $name
     * @param $data
     * @param string $key
     * @param string $val
     * @param int $checked_value
     *
     * @return mixed|string
     */
    function form_checkbox_rows( $name , $data , $key = 'id' , $val = 'name' , $checked_value = 0 ) {
        $html = '';
        foreach ( $data as $item ) {
            $html .= '<label class="checkbox-inline"><input name="' . $name . '[]" type="checkbox" value="' . $item[ $key ] . '" >' .
                $item[ $val ] . '</label>';
        }

        if ( $checked_value >= 0 ) {
            $html = str_replace( 'value="' . $checked_value . '"' , "value='$checked_value' checked" , $html );
        }

        return $html;
    }
}

if ( ! function_exists( 'str2pwd' ) ) {
    /**
     * 字符串加密
     *
     * @param $str
     *
     * @return bool|string
     */
    function str2pwd( $str ) {
        return password_hash( $str , PASSWORD_BCRYPT , [ "cost" => 10 ] );
    }
}

if ( ! function_exists( 'json' ) ) {

    function json(Array $array){
        return response()->json($array);
    }

}
if( ! function_exists( 'api_result' ) ){

    function api_result( $msg, $code_or_data = 500, $data = [] ) {
        $result = [
            'msg' => $msg
        ];

        if ( is_array( $code_or_data ) ) {
            $result['code'] = 0;
            $data           = array_merge( $code_or_data, $data );
        } else {
            $result['code'] = $code_or_data;
        }

        if ( ! empty( $data ) ) {
            $result['data'] = $data;
        }

        return $result;
    }
}

if ( ! function_exists( 'rand_string' ) ) {
    /**
     * 生成随机字符串
     *
     * @param $length
     *
     * @return string
     */
    function rand_string( $length = 6 ) {
        $str    = NULL;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max    = strlen( $strPol ) - 1;

        for ( $i = 0; $i < $length; $i ++ ) {
            $str .= $strPol [ rand( 0 , $max ) ]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }
}