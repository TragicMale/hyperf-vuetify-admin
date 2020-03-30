<?php

namespace App\Service;


use Hyperf\DbConnection\Db;
use App\Constants\Constants;
use App\Service\CasbinService;
use Hyperf\Di\Annotation\Inject;

class SystemService
{
    /**
     * @Inject()
     * @var CasbinService
     */
    private $casbinService;

    /**
     * 获取用户权限[菜单权限，按钮权限]
     * @param string $userId
     * @return string
     */
    public function getPermissions(int $userId): ?array
    {
        if ($userId == Constants::SYS_ADMIN_ID) {
            $menuList = Db::table('menu')->where('type', 1)
                ->orderBy('seq')
                ->orderBy('id')
                ->get()->keyBy('id')->toArray();


            $btnList = Db::table('menu')->where('type', 2)
                ->pluck('path')->toArray();
        } else {
            $roleIds = $this->casbinService->getRolesByUser($userId);
            $menuIds = Db::table('role_menu')->whereIn('role_id', $roleIds)->pluck('menu_id');
            $menuList = Db::table('menu')->whereIn('id', $menuIds)->where('type', 1)
                ->get()->keyBy('id')->toArray();

            $btnList = Db::table('menu')->whereIn('id', $menuIds)->where('type', 2)
                ->pluck('path')->toArray();
        }

        $menuList = array_map(function ($v) {
            return (array) $v;
        }, $menuList);
        $menuList = array_to_tree($menuList);

        return [
            'menuList' => $menuList,
            'btnList' => $btnList
        ];
    }
}
