<?php

function cando() {
    $args = func_get_args();
    return call_user_func_array(['Access', 'can'], $args);
}

function canAccess() {
    $args = func_get_args();
    return call_user_func_array(['Access', 'check'], $args);
}

function show_messes($txt_class = null, $box_class = null) {
    $result = '';
    if (Session::has('error_mess')) {
        $result = '<div class="alert alert-warning alert-dismissible border_box ' . $box_class . '">'
                . '<div class="error_mess ' . $txt_class . '">' . Session::get('error_mess') . '</div></div>';
        Session::forget('error_mess');
    }
    if (Session::has('succ_mess')) {
        $result = '<div class="alert alert-dismissible border_box ' . $box_class . '">'
                . '<div class="succ_mess ' . $txt_class . '">' . Session::get('succ_mess') . '</div></div>';
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
        if ($errors->has($field)) {
            return '<div class="help-block alert alert-danger">' . $errors->first($field) . '</div>';
        }
    }
    return '';
}

function makeToken($length = 17, $model = null) {
    $str = str_random($length);
    if ($model) {
        $token = $model->where('resetPasswdToken', $str)->first();
        if ($token) {
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

function isActive($route, $status = null, $active = 'active') {
    $request = request();
    $current_route = $request->route()->getName();
    if ($route == $current_route) {
        if ($request->has('status')) {
            $current_status = $request->get('status');
            if ($status == $current_status) {
                return $active;
            }
            return null;
        }
        return $active;
    }
    return null;
}

// Languages
function hasLang($code) {
    return Lang::hasLang($code);
}

function switch_lang_url($locale) {
    $request = request();
    if (!hasLang($locale)) {
        $locale = config('app.fallback_locale');
    }
    app()->setLocale($locale);
    $segments = $request->segments();
    $segments[0] = $locale;
    return implode('/', $segments);
}

function localActive($code, $active = 'active') {
    $current_code = app()->getLocale();
    if ($code == $current_code) {
        return $active;
    }
    return null;
}

function get_langs() {
    return Lang::all();
}

function current_lang() {
    return Lang::current();
}

function current_lang_id() {
    return Lang::current()->id;
}

function current_locale() {
    return app()->getLocale();
}

function nested_option($items, $selected = 0, $parent = 0, $depth = 0) {
    $html = '';
    $intent = str_repeat('-- ', $depth);
    if (!is_array($selected)) {
        $selected = [$selected];
    }
    if ($items) {
        foreach ($items as $item) {
            if ($item->parent_id == $parent) {
                $select = in_array($item->id, $selected) ? 'selected' : '';
                $html .= '<option value="' . $item->id . '" ' . $select . '>' . $intent . $item->pivot->name . '</option>';
                $html .= nested_option($items, $selected, $item->id, $depth + 1);
            }
        }
    }
    return $html;
}

function list_menu_types() {
    return [
        0 => trans('menu.custom'),
        1 => trans('menu.post'),
        2 => trans('menu.page'),
        3 => trans('menu.cat'),
        4 => trans('menu.tag')
    ];
}

function makeRandDir($length=16, $model){
    $dir = str_random($length);
    $item = $model->where('rand_dir', $dir)->first();
    if($item){
        $dir = makeRandDir($length, $model);
    }
    return $dir;
}
