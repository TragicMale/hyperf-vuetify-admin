<?php

declare(strict_types=1);

namespace App\Kernel\Util;

use Casbin\Enforcer;
use CasbinAdapter\Database\Adapter;
use Hyperf\Utils\Traits\StaticInstance;

class CasbinInstance
{
    use StaticInstance;

    public $adapterInstance;
    public $enforerInstance;

    private function __construct()
    {
        $config = [
            'type'     => env('DB_DRIVER'), // mysql,pgsql,sqlite,sqlsrv
            'hostname' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'hostport' => env('DB_PORT'),
        ];
        $adapter = new Adapter($config);
        $this->adapterInstance = $adapter;
        $this->enforerInstance = new Enforcer(config('casbin_model_path'), $adapter);
    }
}
