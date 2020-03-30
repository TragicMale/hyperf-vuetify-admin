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

use App\Model\Role;
use App\Model\RoleMenu;
use Hyperf\DbConnection\Db;
use App\Service\CasbinService;
use Hyperf\Di\Annotation\Inject;
use App\Request\Admin\RoleRequest;
use App\Controller\AbstractController;

class RoleController extends AbstractController
{
    /**
     * @Inject
     * @var CasbinService
     */
    protected $casbinService;

    public function index()
    {
        // sort paramters
        $perPage = intval($this->request->input('perPage'));
        $sortBy = $this->request->input('sortBy');
        $direction = $this->request->input('sortDirection');

        // query parameter
        $name = $this->request->input('name');
        $key = $this->request->input('key');
        $state = $this->request->input('state');

        $paginator = Role::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', $name . '%');
            })
            ->when($key, function ($query, $key) {
                return $query->where('key', 'like', $key . '%');
            })
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
            })
            ->when($sortBy, function ($query, $sortBy) use ($direction) {
                return $query->orderBy($sortBy, $direction);
            }, function ($query) {
                return $query->orderBy('id', 'desc');
            })
            ->paginate($perPage);

        return $this->response->success([
            'total' => $paginator->total(),
            'data' => $paginator->items(),
        ]);
    }

    public function get(int $id)
    {
        $role = Role::query()->find($id);
        return $this->response->success($role);
    }

    public function save($id, RoleRequest $request)
    {
        $validated = $request->validated();

        if ($id) {
            $role = Role::query()->find($id);
        } else {
            $role = new Role();
        }

        $role->fill($validated);

        $result = $role->save();
        return $this->response->success($result);
    }

    public function delete($id)
    {
        // TODO
        Db::transaction(function () use ($id) {
            Role::destroy($id);
            RoleMenu::query()->where('role_id', $id)->delete();
            $this->casbinService->deleteRole($id);
        });
        return $this->response->success(true);
    }

    public function getMenus($roleId)
    {
        $menus = RoleMenu::query()->where('role_id', $roleId)->where('is_dir', 0)->pluck('menu_id');
        return $this->response->success($menus);
    }

    public function setMenus($roleId)
    {
        $menus = $this->request->input('menus');
        $menusWithParents = $this->request->input('menusWithParents');

        $menus = array_unique($menus);
        $menusWithParents = array_unique($menusWithParents);

        $menuArr = [];
        foreach ($menusWithParents as $menuId) {
            $menuArr[] = [
                'role_id' => $roleId,
                'menu_id' => $menuId,
                'is_dir' => in_array($menuId, $menus) ? 0 : 1,
            ];
        }

        Db::transaction(function () use ($roleId, $menuArr) {
            Db::table('role_menu')->where('role_id', $roleId)->delete();
            Db::table('role_menu')->insert($menuArr);
        });
        return $this->response->success(true);
    }

    public function getResources($roleId)
    {
        $resources = $this->casbinService->getPermissionsByRole($roleId);
        return $this->response->success($resources);
    }

    public function setResources($roleId)
    {
        $resources = $this->request->input('resources');
        $this->casbinService->setPermissionsForRole($roleId, $resources);
        return $this->response->success(true);
    }
}
