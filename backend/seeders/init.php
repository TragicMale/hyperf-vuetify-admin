<?php

declare(strict_types=1);

use App\Constants\State;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class Init extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('user')->insert([
            ['id' => 1, 'username' => 'admin', 'password' => password_hash('123456', PASSWORD_BCRYPT), 'state' => State::ENABLED],
            ['id' => 2, 'username' => 'test', 'password' => password_hash('123456', PASSWORD_BCRYPT), 'state' => State::ENABLED],
        ]);

        for ($i = 1; $i < 51; $i++) {
            Db::table('user')->insert([
                ['username' => 'test' . $i, 'password' => password_hash('123456', PASSWORD_BCRYPT), 'state' => State::ENABLED],
            ]);
        }

        Db::table('role')->insert([
            ['id' => 1, 'name' => '超级管理员', 'key' => 'administrator', 'remark' => '超级管理员', 'state' => State::ENABLED],
            ['id' => 2, 'name' => '测试角色', 'key' => 'test', 'remark' => '测试角色', 'state' => State::ENABLED],
        ]);
        for ($i = 1; $i < 51; $i++) {
            Db::table('role')->insert([
                ['name' => 'test' . $i, 'key' => 'test' . $i, 'remark' => '测试角色', 'state' => State::ENABLED],
            ]);
        }

        Db::table('menu')->insert([
            ['id' => 1, 'name' => '首页', 'type' => 1, 'pid' => 0, 'seq' => 0, 'path' => '/home', 'icon' => 'home', 'state' => State::ENABLED],
            ['id' => 2, 'name' => '系统设置', 'type' => 1, 'pid' => 0, 'seq' => 0, 'path' => '/system', 'icon' => 'cog', 'state' => State::ENABLED],
            ['id' => 3, 'name' => '用户管理', 'type' => 1, 'pid' => 2, 'seq' => 0, 'path' => '/system/user', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 4, 'name' => '查看', 'type' => 2, 'pid' => 3, 'seq' => 0, 'path' => 'user:query', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 5, 'name' => '编辑', 'type' => 2, 'pid' => 3, 'seq' => 0, 'path' => 'user:edit', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 6, 'name' => '角色分配', 'type' => 2, 'pid' => 3, 'seq' => 0, 'path' => 'user:setRole', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 7, 'name' => '删除', 'type' => 2, 'pid' => 3, 'seq' => 0, 'path' => 'user:delete', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 8, 'name' => '角色管理', 'type' => 1, 'pid' => 2, 'seq' => 0, 'path' => '/system/role', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 9, 'name' => '查看', 'type' => 2, 'pid' => 8, 'seq' => 0, 'path' => 'role:query', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 10, 'name' => '编辑', 'type' => 2, 'pid' => 8, 'seq' => 0, 'path' => 'role:edit', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 11, 'name' => '菜单分配', 'type' => 2, 'pid' => 8, 'seq' => 0, 'path' => 'role:setMenu', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 12, 'name' => '权限分配', 'type' => 2, 'pid' => 8, 'seq' => 0, 'path' => 'role:setResource', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 13, 'name' => '删除', 'type' => 2, 'pid' => 8, 'seq' => 0, 'path' => 'role:delete', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 14, 'name' => '菜单管理', 'type' => 1, 'pid' => 2, 'seq' => 0, 'path' => '/system/menu', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 16, 'name' => '编辑', 'type' => 2, 'pid' => 14, 'seq' => 0, 'path' => 'menu:edit', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 17, 'name' => '删除', 'type' => 2, 'pid' => 14, 'seq' => 0, 'path' => 'menu:delete', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 18, 'name' => '资源管理', 'type' => 1, 'pid' => 2, 'seq' => 0, 'path' => '/system/resource', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 19, 'name' => '查看', 'type' => 2, 'pid' => 18, 'seq' => 0, 'path' => 'resource:query', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 20, 'name' => '编辑', 'type' => 2, 'pid' => 18, 'seq' => 0, 'path' => 'resource:edit', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 21, 'name' => '删除', 'type' => 2, 'pid' => 18, 'seq' => 0, 'path' => 'resource:delete', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 23, 'name' => '级联菜单', 'type' => 1, 'pid' => 0, 'seq' => 0, 'path' => '', 'icon' => 'roman-numeral-1', 'state' => State::ENABLED],
            ['id' => 24, 'name' => '二级菜单', 'type' => 1, 'pid' => 23, 'seq' => 0, 'path' => '', 'icon' => '', 'state' => State::ENABLED],
            ['id' => 25, 'name' => '三级菜单1', 'type' => 1, 'pid' => 24, 'seq' => 0, 'path' => '', 'icon' => 'roman-numeral-3', 'state' => State::ENABLED],
            ['id' => 26, 'name' => '三级菜单2', 'type' => 1, 'pid' => 24, 'seq' => 0, 'path' => '', 'icon' => 'roman-numeral-3', 'state' => State::ENABLED],
        ]);

        for ($i = 0; $i < 22; $i++) {
            Db::table('role_menu')->insert(['role_id' => 1, 'menu_id' => $i + 1]);
        }
    }
}
