<?php

namespace App\Controllers;

use App\Core\Application;
use App\Models\User;
use App\Validation\Validator;
use App\Helpers\Session;

class AuthController
{
    private Application $app;
    private User $userModel;
    private Session $session;

    public function __construct(Application $app, User $userModel, Session $session)
    {
        $this->app = $app;
        $this->userModel = $userModel;
        $this->session = $session;
    }

    public function showLogin(array $params = []): void
    {
        if ($this->session->has('user_id')) {
            header('Location: /dashboard');
            exit;
        }
        
        $this->render('auth/login', [
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function login(array $params = []): void
    {
        $input = $this->app->router()->getRouteParams();
        
        $validator = Validator::make($input, [
            'identifier' => 'required',
            'password' => 'required',
        ]);

        if (!$validator->validate()) {
            $this->render('auth/login', [
                'errors' => $validator->errors(),
                'old' => $input,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }

        $user = $this->userModel->findByEmailOrUsername($input['identifier']);

        if (!$user || !$this->userModel->verifyPassword($input['password'], $user['password'])) {
            $this->render('auth/login', [
                'errors' => ['identifier' => ['Ungültige Anmeldedaten.']],
                'old' => $input,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }

        if ($user['status'] !== 'active') {
            $this->render('auth/login', [
                'errors' => ['identifier' => ['Ihr Account ist deaktiviert.']],
                'old' => $input,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }

        // Regenerate session for security
        $this->session->regenerate(true);
        
        $this->session->set('user_id', $user['id']);
        $this->session->set('username', $user['username']);
        $this->session->set('email', $user['email']);
        $this->session->set('role', $user['role']);
        $this->session->set('permissions', $this->userModel->getPermissions()[$user['role']] ?? []);

        $this->userModel->updateLastLogin($user['id']);

        // Redirect based on role
        $redirect = $this->session->get('redirect_after_login');
        $this->session->forget('redirect_after_login');
        
        if ($redirect) {
            header('Location: ' . $redirect);
        } else {
            switch ($user['role']) {
                case 'owner':
                    header('Location: /owner');
                    break;
                case 'admin':
                case 'support':
                    header('Location: /admin');
                    break;
                default:
                    header('Location: /dashboard');
            }
        }
        exit;
    }

    public function showRegister(array $params = []): void
    {
        if ($this->session->has('user_id')) {
            header('Location: /dashboard');
            exit;
        }
        
        // Check if registration is allowed (not in maintenance, etc.)
        $wip = $this->app->config()->get('work_in_progress.enabled');
        if ($wip) {
            $this->render('auth/register_disabled', [
                'message' => $this->app->config()->get('work_in_progress.message'),
            ]);
            return;
        }
        
        $this->render('auth/register', [
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function register(array $params = []): void
    {
        $input = $this->app->router()->getRouteParams();
        
        $validator = Validator::make($input, [
            'username' => 'required|alpha_dash|min:3|max:32|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|password|confirmed',
        ], [
            'username.unique' => 'Dieser Benutzername ist bereits vergeben.',
            'email.unique' => 'Diese E-Mail-Adresse ist bereits registriert.',
        ]);

        if (!$validator->validate()) {
            $this->render('auth/register', [
                'errors' => $validator->errors(),
                'old' => $input,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }

        $userId = $this->userModel->create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => 'customer',
            'status' => 'active',
            'email_verified' => 0,
        ]);

        // Auto-login after registration
        $this->session->regenerate(true);
        $this->session->set('user_id', $userId);
        $this->session->set('username', $input['username']);
        $this->session->set('email', $input['email']);
        $this->session->set('role', 'customer');
        $this->session->set('permissions', $this->userModel->getPermissions()['customer'] ?? []);

        header('Location: /dashboard');
        exit;
    }

    public function logout(array $params = []): void
    {
        $this->session->destroy();
        header('Location: /');
        exit;
    }

    public function showForgotPassword(array $params = []): void
    {
        $this->render('auth/forgot_password', [
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function forgotPassword(array $params = []): void
    {
        $input = $this->app->router()->getRouteParams();
        
        $validator = Validator::make($input, [
            'email' => 'required|email',
        ]);

        if (!$validator->validate()) {
            $this->render('auth/forgot_password', [
                'errors' => $validator->errors(),
                'old' => $input,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }

        $user = $this->userModel->findByEmail($input['email']);
        
        // Always show success for security (don't reveal if email exists)
        $this->render('auth/forgot_password_sent', [
            'email' => $input['email'],
        ]);

        // TODO: Send password reset email
    }

    public function showResetPassword(array $params = []): void
    {
        $token = $params['token'] ?? '';
        
        // TODO: Validate token
        
        $this->render('auth/reset_password', [
            'token' => $token,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function resetPassword(array $params = []): void
    {
        $input = $this->app->router()->getRouteParams();
        
        $validator = Validator::make($input, [
            'token' => 'required',
            'password' => 'required|password|confirmed',
        ]);

        if (!$validator->validate()) {
            $this->render('auth/reset_password', [
                'errors' => $validator->errors(),
                'old' => $input,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }

        // TODO: Validate token and update password
        
        header('Location: /login?reset=success');
        exit;
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        include __DIR__ . "/../../public/pages/{$view}.php";
    }
}
