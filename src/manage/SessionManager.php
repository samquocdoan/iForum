<?php

namespace App\Manage;

class SessionManager
{
    public static function start($session_lifetime = 3600)
    {
        session_set_cookie_params([
            'lifetime' => $session_lifetime,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
        ]);
        session_start();
    }

    public static function set($key, $values)
    {
        $_SESSION[$key] = $values;
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    public static function isExpired($timeout)
    {
        if ($_SESSION['last_activity'] && (time() - $_SESSION['last_activity'] > $timeout)) {
            return true;
        }
        return false;
    }

    public static function updateLastActivity()
    {
        $_SESSION['last_activity'] = time();
    }
}
