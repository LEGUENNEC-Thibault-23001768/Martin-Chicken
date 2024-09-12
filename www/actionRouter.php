<?php

use data\superGlobal\Post;
use service\Authentification;

switch(Post::$action) {
    case 'register' :
        Authentification::register(Post::$name, Post::$password);
        break;
    case 'login' :
        Authentification::login(Post::$name, Post::$password);
        break;
    default :
        $action = Post::$action;
        throw new Exception("Unknown action : $action");
}