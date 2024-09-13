<?php

// Start the session at the beginning of your script

class AuthModel
{
    private static string $table = 'AUTHENTIFICATION';

    public static function register(string $username, string $email, string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . self::$table . " (username, email, password) VALUES (?, ?, ?)";
        $result = Connexion::execute($query, [$username, $email, $hashedPassword]);

    }

    public static function login(string $username, string $password): bool
    {
        $query = "SELECT * FROM " . self::$table . " WHERE username = ?";
        $result = Connexion::execute($query, [$username]);
        
        if (count($result) === 1) {
            $user = $result[0];

            if ($user["password"] == $password) {
            //if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }
        return false;
    }

    public static function logout(): void
    {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function getCurrentUser(): ?array
    {
        if (self::isLoggedIn()) {
            return self::findById($_SESSION['user_id']);
        }
        return null;
    }

}