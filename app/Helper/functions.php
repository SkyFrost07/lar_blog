<?php

function cando(){
    $args = func_get_args();
    return call_user_func_array(['Access', 'can'], $args);
}

function canAccess(){
    $args = func_get_args();
    return call_user_func_array(['Access', 'check'], $args);
}

function show_messes($txt_class=null, $box_class=null) {
    $result = '';
    if (Session::has('error_mess')) {
        $result = '<div class="alert alert-warning alert-dismissible border_box '.$box_class.'">'
                . '<div class="error_mess '.$txt_class.'">' . Session::get('error_mess') . '</div></div>';
        Session::forget('error_mess');
    }
    if (Session::has('succ_mess')) {
        $result = '<div class="alert alert-dismissible border_box '.$box_class.'">'
                . '<div class="succ_mess '.$txt_class.'">' . Session::get('succ_mess') . '</div></div>';
        Session::forget('succ_mess');
    }
    return $result;
}

/**
 * 
 * @param type $field field name
 * @param type $errors array errors
 * @return type
 */
function error_field($field) {
    $errors = Session::get('errors');
    if (count($errors) > 0) {
        if($errors->has($field)){
            return '<div class="help-block alert alert-danger">' . $errors->first($field) . '</div>';
        }
    }
    return '';
}

function makeToken($length=17, $model = null){
    $str = str_random($length);
    if($model){
        $token = $model->where('resetPasswdToken', $str)->first();
        if($token){
            $str = makeToken($length, $model);
        }
    }
    return $str;
}

function link_order($orderby) {
    $request = request();
    $route = $request->route()->getName();
    $order = 'asc';
    if ($request->has('order')) {
        if ($request->has('orderby')) {
            $c_orderby = $request->get('orderby');
            if ($c_orderby == $orderby) {
                $order = ($request->get('order') == 'asc') ? 'desc' : 'asc';
            }
        }
    }
    $args = array_merge($request->all(), ['orderby' => $orderby, 'order' => $order]);
    echo '<a href="' . route($route, $args) . '"><i class="fa fa-sort"></i></a>';
}

function selected($current, $values, $echo = true, $selected = "checked") {
    $result = false;
    if ($values) {
        if (is_object($values)) {
            foreach ($values as $item) {
                if ($item->id == $current) {
                    $result = true;
                    break;
                }
            }
        } elseif (is_array($values)) {
            if (in_array($current, $values)) {
                $result = true;
            }
        } else {
            if ($current == $values) {
                $result = true;
            }
        }
    }
    if ($result) {
        if ($echo)
            echo $selected;
        else
            return true;
    }else {
        return false;
    }
}
