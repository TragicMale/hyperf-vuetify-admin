<?php

declare(strict_types=1);

use App\Constants\State;
use App\Kernel\Util\CasbinInstance;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\ApplicationContext;
use Hyperf\HttpServer\Router\DispatcherFactory;

class Casbin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adapter = CasbinInstance::instance()->adapterInstance;
        $adapter->initTable();

        $enforcer = CasbinInstance::instance()->enforerInstance;

        $roleKey = 'role:1'; //默认管理员角色
        $userKey = 'user:2'; // 测试用户
        $enforcer->addRoleForUser($userKey, $roleKey);

        $container = ApplicationContext::getContainer();
        $router = $container->get(DispatcherFactory::class)->getRouter('http');
        [$routers] = $router->getData();

        $routes = [];
        foreach ($routers as $method => $items) {
            foreach ($items as $item) {
                $uri = $item->route;
                $routes[$uri][] = $method;
                $enforcer->addPermissionForUser($roleKey, $uri, $method);
            }
        }
        foreach ($routes as $uri => $methods) {
            if (count($methods) > 1) { #暴力判断
                $enforcer->addPermissionForUser($roleKey, $uri . '/*', 'GET');
                $enforcer->addPermissionForUser($roleKey, $uri . '/*', 'PATCH');
                $enforcer->addPermissionForUser($roleKey, $uri . '/*', 'DELETE');
            }
        }

        // 补充 /* 部分的权限
        $enforcer->addPermissionForUser($roleKey, '/sys/userRoles/*', 'GET');
        $enforcer->addPermissionForUser($roleKey, '/sys/userRoles/*', 'PATCH');
        $enforcer->addPermissionForUser($roleKey, '/sys/roleMenus/*', 'GET');
        $enforcer->addPermissionForUser($roleKey, '/sys/roleMenus/*', 'PATCH');
        $enforcer->addPermissionForUser($roleKey, '/sys/roleResources/*', 'GET');
        $enforcer->addPermissionForUser($roleKey, '/sys/roleResources/*', 'PATCH');

        $resources = [];
        $permissions = $enforcer->getPermissionsForUser($roleKey);
        foreach ($permissions as $item) {
            foreach (explode('|', $item[2]) as $action) {
                $resources[] = [
                    'path' => $item[1],
                    'action' => $action,
                ];
            }
        }
        Db::table('resource')->insert($resources);
    }
}
