<?php

declare(strict_types=1);

namespace App\Kernel\Util;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\User;
use Firebase\JWT\JWT;
use Hyperf\Utils\Traits\StaticInstance;

class JwtInstance
{
    use StaticInstance;

    const KEY = 'Hyperf-admin';

    /**
     * @var int
     */
    public $id;

    /**
     * @var User
     */
    public $user;

    public function encode(User $user)
    {
        $this->id = $user->id;
        $this->user = $user;
        return JWT::encode([
            'iss' => 'vuetify-admin', //签发者 可选
            'iat' => time(), //签发时间
            'exp' => time() + config("sys_token_exp"),
            'id' => $user->id
        ], self::KEY);
    }

    public function decode(string $token): self
    {
        try {
            $decoded = (array) JWT::decode($token, self::KEY, ['HS256']);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            logger('jwt')->error($e->getMessage());
            throw new BusinessException(ErrorCode::AUTH_INVALID, $e->getMessage());
        } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
            logger('jwt')->error($e->getMessage());
            throw new BusinessException(ErrorCode::AUTH_INVALID, $e->getMessage());
        } catch (\Throwable $e) {
            logger('jwt')->error($e->getMessage());
            throw new BusinessException(ErrorCode::SERVER_ERROR, $e->getMessage());
        }
        if ($id = $decoded['id'] ?? null) {
            $user = User::query()->find($id);
            if (empty($user)) {
                throw new BusinessException(ErrorCode::AUTH_INVALID, '用户不存在或已禁用');
            }
            $this->user = $user;
            $this->id = $id;
        }
        return $this;
    }

    public function build(): self
    {
        if (empty($this->id)) {
            throw new BusinessException(ErrorCode::AUTH_INVALID);
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        if ($this->user === null && $this->id) {
            $this->user = User::query()->find($id);
        }
        return $this->user;
    }
}
