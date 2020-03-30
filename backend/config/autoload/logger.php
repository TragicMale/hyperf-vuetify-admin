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

$appEnv = env('APP_ENV', 'dev');
if ($appEnv == 'dev') {
    $handler = [
        'class' => Monolog\Handler\StreamHandler::class,
        'constructor' => [
            'stream' => 'php://stdout',
            'level' => Monolog\Logger::DEBUG,
        ],
    ];
} else {
    $handler = [
        'class' => Monolog\Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/hyperf.log',
            'level' => Monolog\Logger::INFO,
        ],
    ];
}

return [
    'default' => [
        'handler' => $handler,
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => null,
                'allowInlineLineBreaks' => true,
            ],
        ],
    ],
];
