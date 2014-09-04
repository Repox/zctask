<?php

require 'vendor/autoload.php';

session_save_path('/tmp');
session_start();

$router = new AltoRouter();

$router->map('GET','/', '\Zitcom\Controllers\IndexController.index', 'home');
$router->map('GET','/loggedin', '\Zitcom\Controllers\IndexController.loggedin', 'logged_in');

$router->map('GET','/dashboard', '\Zitcom\Controllers\AdminController.index', 'dashboard');
$router->map('GET','/createuser', '\Zitcom\Controllers\AdminController.createuser', 'create_user');
$router->map('GET','/creategroup', '\Zitcom\Controllers\AdminController.creategroup', 'create_group');
$router->map('GET','/user/edit/[i:id]', '\Zitcom\Controllers\AdminController.edituser', 'edit_user');
$router->map('GET','/group/edit/[i:id]', '\Zitcom\Controllers\AdminController.editgroup', 'edit_group');
$router->map('GET','/user/delete/[i:id]', '\Zitcom\Controllers\AdminController.deleteuser', 'delete_user');
$router->map('GET','/group/delete/[i:id]', '\Zitcom\Controllers\AdminController.deletegroup', 'delete_group');
$router->map('GET','/group/members/[i:id]', '\Zitcom\Controllers\AdminController.groupmembers', 'group_members');

$router->map('POST','/login', '\Zitcom\Controllers\LoginController.login', 'login_post');
$router->map('POST','/createuser', '\Zitcom\Controllers\AdminController.postcreateuser', 'create_user_post');
$router->map('POST','/creategroup', '\Zitcom\Controllers\AdminController.postcreategroup', 'create_group_post');
$router->map('POST','/user/edit/[i:id]', '\Zitcom\Controllers\AdminController.postedituser', 'edit_user_post');
$router->map('POST','/group/edit/[i:id]', '\Zitcom\Controllers\AdminController.posteditgroup', 'edit_group_post');

// Simple API version
$router->map('GET','/api/user/[i:id]', '\Zitcom\Controllers\ApiController.singleuser', 'edit_user');
$router->map('GET','/api/users', '\Zitcom\Controllers\ApiController.allusers', 'all_users');
$router->map('POST','/api/user', '\Zitcom\Controllers\ApiController.createuser', 'create_user');
$router->map('PUT','/api/user', '\Zitcom\Controllers\ApiController.updateuser', 'update_user');
$router->map('DEÆETE','/api/user/[i:id]', '\Zitcom\Controllers\ApiController.deleteuser', 'delete_user');


$router->map('GET','/api/group/[i:id]', '\Zitcom\Controllers\ApiController.singleuser', 'edit_user');
$router->map('GET','/api/group', '\Zitcom\Controllers\ApiController.allusers', 'all_users');
$router->map('POST','/api/group', '\Zitcom\Controllers\ApiController.createuser', 'create_user');
$router->map('PUT','/api/user', '\Zitcom\Controllers\ApiController.updateuser', 'update_user');
$router->map('DEÆETE','/api/user/[i:id]', '\Zitcom\Controllers\ApiController.deleteuser', 'delete_user');



$match = $router->match();
list($class, $method) = explode(".", $match['target']);
$controller = new $class;
$controller->$method($match['params']);

