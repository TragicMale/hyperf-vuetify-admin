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

namespace App\Constants;

class Constants
{
    const TOKEN_FIELD = 'Authorization';

    const PERMISSION_DENIED = 'Permission denied';

    // 系统超级管理员id
    const SYS_ADMIN_ID = 1;

    const PERMISSION_DELIMITER = ' -> ';
}
