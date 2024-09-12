<?php

namespace service;

use data\database\UserTable;
use domain\User;
use exception\ActionException;

class Authentification
{
    public static function register(string $login, string $password): void
    {
        $user = new User($login, $password);
        if(UserTable::exists($user)) {
            throw new ActionException("User already exists", '/register');
        }

        UserTable::insert($user);
    }
    public static function login(string $login, string $password): void
    {
        $user = new User($login, $password);
        $password = $user->hashPassword();

        $user = UserTable::select($user);
        if(empty($user)) {
            throw new ActionException("User $login does not exist", 'login');
        }

        if($password !== $user->getPassword()) {
            throw new ActionException("Password is incorrect", 'login');
        }
    }
}