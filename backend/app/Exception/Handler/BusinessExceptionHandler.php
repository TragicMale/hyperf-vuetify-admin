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
use App\Kernel\Log\Log;
use App\Kernel\Http\Response;
use App\Exception\BusinessException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;

class BusinessExceptionHandler extends ExceptionHandler
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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
        $this->logger = logger();
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 阻止异常冒泡
        $this->stopPropagation();

        // $this->logger->warning(format_throwable($throwable));
        $this->logger->info(
            sprintf(
                '%s:%s(%s) in %s:%s',
                get_class($throwable),
                $throwable->getMessage(),
                $throwable->getCode(),
                $throwable->getFile(),
                $throwable->getLine()
            )
        );

        return $this->response->fail($throwable->getCode(), $throwable->getMessage());
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BusinessException;
    }
}
