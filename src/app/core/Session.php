<?php

namespace App\Core;

use Exception;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function generateToken(): string
    {
        self::start();
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    /**
     * 渡されたトークンを検証する
     *
     * @param string $token
     * @throws Exception
     */
    public static function validateToken(string $token): void
    {
        self::start();
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            throw new Exception('不正なアクセスです。');
        }
    }
}
