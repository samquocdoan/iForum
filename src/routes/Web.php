<?php

namespace App\Routes;

use App\Core\Router;
use Config\Database;

$initDb = new Database();

$db = $initDb->getConnection();

$router = new Router($db);

// Home
$router->get('/', 'PostController@getPosts');
$router->get('/newest', 'PostController@getPosts');
$router->get('/oldest', 'PostController@getPosts');
$router->get('/popularity', 'PostController@getPosts');
$router->get('/tags', 'TagController@index');

$router->get('/posts/{postId}', 'PostController@getPostById');

// Profile
$router->get('/user/profile', 'UserController@profile');

// create account
$router->get('/user/create', 'UserController@create');
$router->post('/user/create', 'UserController@create');

// Login
$router->get('/user/login', 'UserController@login');
$router->post('/user/login', 'UserController@login');

// Delete user
$router->get('/user/delete', 'UserController@delete');

// Update user information
$router->post('/user/update', 'UserController@update');
$router->post('/user/update-password', 'UserController@updatePassword');
$router->get('/user/update-password', 'UserController@updatePassword');

// Test Send mail
$router->put('/user/create', 'UserController@create');
$router->get('/tags/{tagName}', 'TagController@index');
$router->get('/{sort}/{page}', 'PostController@getPosts');
$router->get('/{sort}/{timeFrame}/{page}', 'PostController@getPosts');

$router->get('/tags/{tagName}/{sort}/{page}', 'TagController@index');
$router->get('/tags/{tagName}/{sort}/{timeFrame}/{page}', 'TagController@index');

$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);