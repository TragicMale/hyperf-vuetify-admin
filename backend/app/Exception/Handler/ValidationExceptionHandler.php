<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use Throwable;
use App\Kernel\Http\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Validation\ValidationException;
use Hyperf\ExceptionHandler\ExceptionHandler;

class ValidationExceptionHandler extends ExceptionHandler
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->response = $container->get(Response::class);
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $body = $throwable->validator->errors()->first();

        return $this->response->fail($throwable->status, $body)
            ->withStatus($throwable->status);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
