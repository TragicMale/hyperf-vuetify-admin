<?php

namespace App\Service;

use App\Constants\Constants;
use App\Kernel\Util\CasbinInstance;

class CasbinService
{
    /**
     * 设置用户权限
     *
     * @param mixed $userId
     * @param array $roles
     * @return void
     */
    public function setRolesForUser($userId, array $roles)
    {
        CasbinInstance::instance()->enforerInstance->deleteRolesForUser('user:' . $userId);
        foreach ($roles as $roleId) {
            CasbinInstance::instance()->enforerInstance->addRoleForUser('user:' . $userId, 'role:' . $roleId);
        }
    }

    /**
     * 获取用户权限
     *
     * @param mixed $userId
     * @return void
     */
    public function getRolesByUser($userId)
    {
        $roles = CasbinInstance::instance()->enforerInstance->getRolesForUser('user:' . $userId);
        return $this->decryptArray($roles, 'role:');
    }

    /**
     * 设置角色权限
     *
     * @param mixed $roleId
     * @param array $resources
     * @return void
     */
    public function setPermissionsForRole($roleId, array $resources)
    {
        CasbinInstance::instance()->enforerInstance->deletePermissionsForUser('role:' . $roleId);
        foreach ($resources as $resource) {
            [$path, $action] = explode(' -> ', $resource);
            CasbinInstance::instance()->enforerInstance->addPermissionForUser('role:' . $roleId, $path, $action);
        }
    }

    /**
     * 获取角色权限
     *
     * @param mixed $roleId
     * @return void
     */
    public function getPermissionsByRole($roleId)
    {
        $permissions = CasbinInstance::instance()->enforerInstance->getPermissionsForUser('role:' . $roleId);

        $result = [];
        foreach ($permissions as $p) {
            $result[] = $p[1] . Constants::PERMISSION_DELIMITER . $p[2];
        }
        return $result;
    }

    /**
     * 根据角色获取用户
     *
     * @param mixed $roleId
     * @return void
     */
    public function getUsersByRole($roleId)
    {
        $users = CasbinInstance::instance()->enforerInstance->getUsersForRole('role:' . $roleId);
        return $this->decryptArray($users, 'user:');
    }

    /**
     * 删除用户
     *
     * @param mixed $userId
     * @return void
     */
    public function deleteUser($userId): void
    {
        // CasbinInstance::instance()->enforerInstance->deletePermissionsForUser('role' . $userId);
        CasbinInstance::instance()->enforerInstance->deleteUser('user:' . $userId);
    }

    /**
     * 删除角色
     *
     * @param mixed $roleId
     * @return void
     */
    public function deleteRole($roleId): void
    {
        CasbinInstance::instance()->enforerInstance->deletePermissionsForUser('role' . $roleId);
        CasbinInstance::instance()->enforerInstance->deleteRole('role:' . $roleId);
    }

    /**
     * 删除权限
     *
     * @param string $resource
     * @param string $action
     * @return void
     */
    public function deletePermission($resource, $action)
    {
        return CasbinInstance::instance()->enforerInstance->deletePermission($resource, $action);
    }


    private function decryptArray(array $array, $padChar)
    {
        foreach ($array as &$item) {
            $item = intval(str_replace($padChar, '', $item));
        }
        unset($item);
        return $array;
    }
}
