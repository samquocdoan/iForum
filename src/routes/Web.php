<?php

namespace App\Routes;

use App\Core\Router;
use Config\Database;

// require_once __DIR__ . '/../../vendor/autoload.php';

$initDb = new Database();

$db = $initDb->getConnection();

$router = new Router($db);

// Home
$router->get('/', 'HomeController@index');

// Get all post
$router->get('/posts', 'PostController@getAll');

// Get post by id
$router->get('/post/{postId}', 'PostController@getPostById');

// create account
$router->get('/user/create', 'UserController@create');
$router->post('/user/create', 'UserController@create');

// Login
$router->get('/user/login', 'UserController@login');
$router->post('/user/login', 'UserController@login');

// Delete user
$router->get('/user/delete', 'UserController@delete');


$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);