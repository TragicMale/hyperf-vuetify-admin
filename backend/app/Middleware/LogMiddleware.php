<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\Constants;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine(Constants::TOKEN_FIELD);
        $path = $request->getUri()->getPath();
        $action = $request->getMethod();
        $headers = $request->getHeaders();
        $server = $request->getServerParams();

        $response =  $handler->handle($request);

        var_dump([
            'user-agent' => $headers['user-agent'][0],
            'referer' => $headers['referer'][0],

            'remote_addr' => $server['x-real-ip'] ?? $server['remote_addr'],
            'request_time' => date('Y-m-d H:i:s', $server['request_time']),

            'token' => $token,
            'path' => $path,
            'action' => $action,
            'response_code' => $response->getStatusCode(),
        ]);

        return $response;
    }
}
