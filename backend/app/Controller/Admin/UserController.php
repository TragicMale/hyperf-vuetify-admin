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

use App\Model\User;
use Hyperf\DbConnection\Db;
use App\Service\CasbinService;
use Hyperf\Di\Annotation\Inject;
use App\Request\Admin\UserRequest;
use App\Controller\AbstractController;
use App\Exception\BusinessException;

class UserController extends AbstractController
{
    /**
     * @Inject
     * @var CasbinService
     */
    protected $casbinService;

    public function getModel()
    {
        return User::class;
    }

    public function index()
    {
        // sort paramters
        $perPage = intval($this->request->input('perPage'));
        $sortBy = $this->request->input('sortBy');
        $direction = $this->request->input('sortDirection');

        // query parameter
        $username = $this->request->input('username');
        $roleId = $this->request->input('role');
        $state = $this->request->input('state');

        // 角色查询
        $usersWithRole = [];
        if ($roleId) {
            $usersWithRole = $this->casbinService->getUsersByRole($roleId);
        }

        $paginator = User::query()
            ->where('id', '<>', 1) // 排除超级管理员
            ->when($username, function ($query, $username) {
                return $query->where('username', 'like', $username . '%');
            })
            ->when($roleId, function ($query, $roleId) use ($usersWithRole) {
                return $query->whereIn('id', $usersWithRole);
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

    public function save($id, UserRequest $request)
    {
        $validated = $request->validated();
        if ($id) {
            $user = User::query()->find($id);
        } else {
            $user = new User();
            $user->password = password_hash(config('default_user_password'), PASSWORD_BCRYPT);
        }
        if ($request->has('password')) {
            $user->password = password_hash($request->input('password'), PASSWORD_BCRYPT);
        }
        $user->fill($validated);

        $result = $user->save();
        return $this->response->success($result);
    }

    public function get(int $id)
    {
        $user = User::query()->find($id);
        return $this->response->success($user);
    }

    public function delete($id)
    {
        //TODO:分布式事务
        Db::transaction(function () use ($id) {
            User::destroy($id);
            $this->casbinService->deleteUser($id);
        });

        return $this->response->success(true);
    }

    public function getRoles($userId)
    {
        $roles = $this->casbinService->getRolesByUser($userId);
        return $this->response->success($roles);
    }

    public function setRoles($userId)
    {
        $roles = $this->request->input('roles');

        $this->casbinService->setRolesForUser($userId, $roles);

        return $this->response->success(true);
    }
}
