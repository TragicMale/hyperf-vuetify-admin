<?php

namespace App\Service;


use App\Model\User;
use App\Constants\State;
use App\Constants\ErrorCode;
use App\Kernel\Util\JwtInstance;
use App\Exception\BusinessException;

class AuthService
{
    /**
     * 用户登录
     * @param string $username
     * @return string
     */
    public function login(string $username, string $password): ?string
    {
        $user = User::query()->where('username', $username)->first();

        if (empty($user) || !password_verify($password, $user->password)) {
            throw new BusinessException(ErrorCode::AUTH_INVALID, '用户名或密码错误');
        }
        if ($user->state !== State::ENABLED) {
            throw new BusinessException(ErrorCode::AUTH_INVALID, '该用户已禁用');
        }

        try {
            $token = JwtInstance::instance()->encode($user);
        } catch (\Throwable $th) {
            throw new BusinessException(ErrorCode::AUTH_INVALID, 'token生成失败');
        }
        return $token;
    }

    /**
     * 修改密码
     * @param string $username
     * @return string
     */
    public function newPassword($oldPassword, $newPassword)
    {
        $user = JwtInstance::instance()->build()->getUser();
        if (!password_verify($oldPassword, $user->password)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, '旧密码错误');
        }
        $user->password = password_hash($newPassword, PASSWORD_BCRYPT);
        return $user->save();
    }
}
