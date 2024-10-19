<?php
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../../config/database.php';

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


$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);