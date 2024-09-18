<?php

// Start the session at the beginning of your script

class AuthModel
{
    private static string $table = 'AUTHENTIFICATION';

    public static function register(string $username, string $email, string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $codePersonnel = 'CODE_' . uniqid();

        try {
            Connexion::beginTransaction();

            $query1 = "INSERT INTO STRUCTURE (Type, Nom, Adresse) VALUES ('Club', 'Nom à Changer', 'Adresse à Changer')";
            Connexion::execute($query1);

            $structureId = Connexion::lastInsertId();

            $query2 = "INSERT INTO TENRAC (Code_personnel, Nom, Email, Grade, Rang, Titre, Dignite, Structure_Id) 
                    VALUES (?, ?, ?, 'Affilié', 'Novice', 'Philanthrope', 'Maitre', ?)";
            Connexion::execute($query2, [$codePersonnel, $username, $email, $structureId]);

            $tenracId = Connexion::lastInsertId();

            $query3 = "INSERT INTO AUTHENTIFICATION (Tenrac_Id, Username, Password) VALUES (?, ?, ?)";
            Connexion::execute($query3, [$tenracId, $username, $hashedPassword]);

            Connexion::commit();
                
            } catch (PDOException $e) {

                Connexion::rollBack();
                throw $e;
            }
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