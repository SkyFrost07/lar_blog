<?php

function nested_admenus($items) {
    $html = '<ul>';
    foreach ($items as $item) {
        if (cando($item['cap'])) {
            $html .= '<li>';
            $route_params = (isset($item['route_params'])) ? $item['route_params'] : [];
            $html .= '<a href="' . route($item['route'], $route_params) . '">' . $item['name'] . '</a>';
            if (isset($item['childs']) && $childs = $item['childs']) {
                $html .= nested_admenus($childs);
            }
            $html .= '</li>';
        }
    }
    $html .= '</ul>';

    return $html;
}
?>

{!! nested_admenus($admenus) !!}