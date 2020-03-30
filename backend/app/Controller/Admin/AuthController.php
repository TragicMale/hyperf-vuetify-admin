<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;
use App\Request\Admin\PasswordRequest;

class AuthController extends AbstractController
{
    /**
     * @Inject
     * @var AuthService
     */
    protected $authService;

    public function login()
    {
        $username = $this->request->input('username');
        $password = $this->request->input('password');

        $token = $this->authService->login($username, $password);
        return $this->response->success(['token' => $token]);
    }

    public function newPassword(PasswordRequest $request)
    {
        $validated = $request->validated();
        return $this->authService->newPassword($validated['old_password'], $validated['new_password']);
    }

    public function accountInfo()
    {
        return $this->getTokenUser();
    }
}
