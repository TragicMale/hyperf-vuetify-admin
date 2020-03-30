<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Kernel\Util\JwtInstance;
use App\Exception\BusinessException;
use App\Kernel\Util\CasbinInstance;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminMiddleware implements MiddlewareInterface
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
        $publicResources = ['/login'];
        if (in_array($request->getUri()->getPath(), $publicResources)) {
            return $handler->handle($request);
        }

        // get token value
        $token = $request->getHeaderLine(Constants::TOKEN_FIELD);
        if (empty($token)) {
            throw new BusinessException(ErrorCode::AUTH_INVALID);
        }

        // authenticate
        $userId = JwtInstance::instance()->decode($token)->getId();

        // check permission
        $enforcer = CasbinInstance::instance()->enforerInstance;
        $sub = 'user:' . $userId; // the user that wants to access a resource.
        $obj = $request->getUri()->getPath(); // the resource that is going to be accessed.
        $act = $request->getMethod(); // the operation that the user performs on the resource.
        if ($enforcer->enforce($sub, $obj, $act) === true) {
            return $handler->handle($request);
        } else {
            throw new BusinessException(ErrorCode::PERMISSION_DENIED);
        }
    }
}
