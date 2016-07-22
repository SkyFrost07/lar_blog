<?php

namespace App\Composers;

class AdMenuComposer {

    public function compose($view) {
        $menus = [
            ['name' => trans('menu.posts'), 'route' => 'post.index', 'route_params' => ['status' => 1], 'cap' => 'read_posts'],
            ['name' => trans('menu.cats'), 'route' => 'cat.index', 'cap' => 'manage_cats'],
            ['name' => trans('menu.tags'), 'route' => 'tag.index', 'cap' => 'manage_tags'],
            ['name' => trans('menu.files'), 'route' => 'file.index', 'cap' => 'read_files'],
            ['name' => trans('menu.menucats'), 'route' => 'menucat.index', 'cap' => 'manage_menus'],
            ['name' => trans('menu.users'), 'route' => 'user.index', 'route_params' => ['status' => 1], 'cap' => 'read_users'],
            ['name' => trans('menu.roles'), 'route' => 'role.index', 'cap' => 'manage_roles'],
            ['name' => trans('menu.caps'), 'route' => 'cap.index', 'cap' => 'manage_caps']
        ];

        $view->with('admenus', $menus);
    }

}
