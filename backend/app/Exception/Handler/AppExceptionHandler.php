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

namespace App\Exception\Handler;

use Throwable;
use App\Constants\ErrorCode;

use App\Kernel\Http\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;

class AppExceptionHandler extends ExceptionHandler
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
        $this->logger = $container->get(StdoutLoggerInterface::class);
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(format_throwable($throwable));
        return $this->response->fail(ErrorCode::SERVER_ERROR, ErrorCode::getMessage(ErrorCode::SERVER_ERROR));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
