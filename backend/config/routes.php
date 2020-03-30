<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

// Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::post('/login', 'App\Controller\Admin\AuthController@login');

Router::addGroup(
    '/',
    function () {
        Router::get('permissions', 'App\Controller\Admin\SystemController@getPermissions');
        Router::get('roles', 'App\Controller\Admin\SystemController@getAllRoles');
        Router::get('menus', 'App\Controller\Admin\SystemController@getAllMenus');
        Router::get('resources', 'App\Controller\Admin\SystemController@getAllResources');

        // 密码修改
        Router::get('account', 'App\Controller\Admin\AuthController@accountInfo');
        Router::put('account/password', 'App\Controller\Admin\AuthController@newPassword');

        // users
        Router::get('sys/users', 'App\Controller\Admin\UserController@index');
        Router::get('sys/users/{id}', 'App\Controller\Admin\UserController@get');
        Router::post('sys/users', 'App\Controller\Admin\UserController@save');
        Router::patch('sys/users/{id}', 'App\Controller\Admin\UserController@save');
        Router::delete('sys/users/{id}', 'App\Controller\Admin\UserController@delete');
        Router::get('sys/userRoles/{userId}', 'App\Controller\Admin\UserController@getRoles');
        Router::patch('sys/userRoles/{userId}', 'App\Controller\Admin\UserController@setRoles');

        // roles
        Router::get('sys/roles', 'App\Controller\Admin\RoleController@index');
        Router::get('sys/roles/{id}', 'App\Controller\Admin\RoleController@get');
        Router::post('sys/roles', 'App\Controller\Admin\RoleController@save');
        Router::patch('sys/roles/{id}', 'App\Controller\Admin\RoleController@save');
        Router::delete('sys/roles/{id}', 'App\Controller\Admin\RoleController@delete');
        Router::get('sys/roleMenus/{roleId}', 'App\Controller\Admin\RoleController@getMenus');
        Router::patch('sys/roleMenus/{roleId}', 'App\Controller\Admin\RoleController@setMenus');
        Router::get('sys/roleResources/{roleId}', 'App\Controller\Admin\RoleController@getResources');
        Router::patch('sys/roleResources/{roleId}', 'App\Controller\Admin\RoleController@setResources');

        // menus
        Router::get('sys/menus', 'App\Controller\Admin\MenuController@index');
        Router::get('sys/menus/{id}', 'App\Controller\Admin\MenuController@get');
        Router::post('sys/menus', 'App\Controller\Admin\MenuController@save');
        Router::patch('sys/menus/{id}', 'App\Controller\Admin\MenuController@save');
        Router::delete('sys/menus/{id}', 'App\Controller\Admin\MenuController@delete');

        // resources
        Router::get('sys/resources', 'App\Controller\Admin\ResourceController@index');
        Router::get('sys/resources/{id}', 'App\Controller\Admin\ResourceController@get');
        Router::post('sys/resources', 'App\Controller\Admin\ResourceController@save');
        Router::patch('sys/resources/{id}', 'App\Controller\Admin\ResourceController@save');
        Router::delete('sys/resources/{id}', 'App\Controller\Admin\ResourceController@delete');
    },
);
