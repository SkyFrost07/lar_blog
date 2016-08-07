<?php

function nested_admenus($items, $depth=0) {
    $html = '<ul '.(($depth==0) ? 'id="menu_bar"' : 'class="menu_childs"').'>';
    foreach ($items as $item) {
        if (cando($item['cap'])) {
            $route_params = (isset($item['route_params'])) ? $item['route_params'] : [];
            $html .= '<li class="'.isRoute($item['route']).'">';
            $has_childs = (isset($item['childs']) && $item['childs']);
            $html .= '<a href="' . route($item['route'], $route_params) . '"><i class="fa '.(isset($item['icon']) ? $item['icon'] : 'fa-circle').'"></i> <span>'. $item['name'] .'</span> '.($has_childs ? '<b class="fa fa-angle-down"></b>' : '').'</a>';
            if ($has_childs) {
                $html .= nested_admenus($item['childs'], $depth+1);
            }
            $html .= '</li>';
        }
    }
    $html .= '</ul>';

    return $html;
}
?>

{!! nested_admenus($admenus) !!}