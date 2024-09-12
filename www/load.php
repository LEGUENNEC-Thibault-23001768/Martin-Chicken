<?php

use data\superGlobal\Env;
use data\superGlobal\Get;
use data\superGlobal\Post;
use data\superGlobal\Session;

include __DIR__ . '/constants.php';
include __DIR__ . '/autoloader.php';

new Env();
new Get();
new Post();
new Session();