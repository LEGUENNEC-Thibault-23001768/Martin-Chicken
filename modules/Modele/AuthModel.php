<?php

// Start the session at the beginning of your script

final class AuthModel
{
    private static string $table = 'AUTHENTIFICATION';


    public static function login(string $username, string $password): bool
    {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE username = ?";
            $result = Connexion::execute($query, [$username]);
            
            if (is_array($result) && count($result) === 1) {
                $user = $result[0];
                
                $storedPassword = $user['password'] ?? null;
                
                if ($storedPassword === null) {
                    error_log("Password column not found in user data");
                    return false;
                }
    
                // Use password_verify to check the password
                if (password_verify($password, $storedPassword)) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'] ?? null;
                    $_SESSION['username'] = $user['username'] ?? null;
                    return true;
                }
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
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

    public static function checkAuth() {
        if (!self::isLoggedIn()) {
            header($_SERVER['SERVER_PROTOCOL'] . "401 Unauthorized");
            header("Location: /");
            exit();
        }
    }

    public static function getCurrentUser(): ?array
    {
        if (self::isLoggedIn()) {
            return self::findById($_SESSION['user_id']);
        }
        return null;
    }

}