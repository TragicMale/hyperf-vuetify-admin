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

namespace App\Controller\Admin;

use App\Model\Menu;
use App\Model\Role;
use App\Model\Resource;
use App\Constants\Constants;
use App\Service\SystemService;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;

class SystemController extends AbstractController
{
    /**
     * @Inject
     * @var SystemService
     */
    protected $systemService;

    public function getPermissions()
    {
        $permissions = $this->systemService->getPermissions($this->getTokenId());

        return $this->response->success($permissions);
    }


    public function getAllMenus()
    {
        $menus = Menu::query()->where('state', 1)
            ->orderBy('seq')
            ->get(['id', 'pid', 'type', 'name', 'path', 'icon'])
            ->toArray();

        $menus = array_to_tree($menus, 'id', 'pid');

        return $this->response->success($menus);
    }

    public function getAllRoles()
    {
        $roles = Role::query()->where('state', 1)->get(['id', 'name'])
            ->toArray();
        return $this->response->success($roles);
    }

    public function getAllResources()
    {
        $resources = Resource::query()->get();
        $result = [];
        foreach ($resources as $resource) {
            $result[] = [
                'id' => $resource->id,
                'p' => $resource->path . Constants::PERMISSION_DELIMITER . $resource->action,
            ];
        }
        return $this->response->success($result);
    }
}
