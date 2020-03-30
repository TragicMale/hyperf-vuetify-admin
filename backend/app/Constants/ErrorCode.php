<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("服务器错误")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("参数错误")
     */
    const PARAMS_INVALID = 422;

    /**
     * @Message("身份认证失败")
     */
    const AUTH_INVALID = 401;

    /**
     * @Message("无权访问")
     */
    const PERMISSION_DENIED = 403;
}
