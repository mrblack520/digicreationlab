<?php

declare(strict_types=1);

function adminConfig(): array
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/admin.php';
    }
    return $config;
}

function adminSessionStart(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function adminIsLoggedIn(): bool
{
    adminSessionStart();
    return !empty($_SESSION['admin_logged_in']);
}

function adminRequireLogin(): void
{
    if (!adminIsLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function adminLogin(string $username, string $password): bool
{
    adminSessionStart();
    $config = adminConfig();

    if ($username !== $config['username'] || !password_verify($password, $config['password_hash'])) {
        return false;
    }

    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = $username;
    return true;
}

function adminLogout(): void
{
    adminSessionStart();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

function adminFlash(string $type, string $message): void
{
    adminSessionStart();
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function adminGetFlash(): ?array
{
    adminSessionStart();
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
