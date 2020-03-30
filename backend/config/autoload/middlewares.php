<?php

declare(strict_types=1);

use App\Middleware\AdminMiddleware;
use App\Middleware\CorsMiddleware;
use App\Middleware\LogMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'http' => [
        // CorsMiddleware::class,
        // LogMiddleware::class,
        AdminMiddleware::class,
        ValidationMiddleware::class
    ],
];
