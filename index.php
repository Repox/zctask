<?php

require 'vendor/autoload.php';

session_save_path('/tmp');
session_start();

$router = new AltoRouter();

$router->map('GET','/', '\UserApp\Controllers\IndexController.index', 'home');
$router->map('GET','/loggedin', '\UserApp\Controllers\IndexController.loggedin', 'logged_in');

$router->map('GET','/dashboard', '\UserApp\Controllers\AdminController.index', 'dashboard');
$router->map('GET','/createuser', '\UserApp\Controllers\AdminController.createuser', 'create_user');
$router->map('GET','/creategroup', '\UserApp\Controllers\AdminController.creategroup', 'create_group');
$router->map('GET','/user/edit/[i:id]', '\UserApp\Controllers\AdminController.edituser', 'edit_user');
$router->map('GET','/group/edit/[i:id]', '\UserApp\Controllers\AdminController.editgroup', 'edit_group');
$router->map('GET','/user/delete/[i:id]', '\UserApp\Controllers\AdminController.deleteuser', 'delete_user');
$router->map('GET','/group/delete/[i:id]', '\UserApp\Controllers\AdminController.deletegroup', 'delete_group');
$router->map('GET','/group/members/[i:id]', '\UserApp\Controllers\AdminController.groupmembers', 'group_members');

$router->map('POST','/login', '\UserApp\Controllers\LoginController.login', 'login_post');
$router->map('POST','/createuser', '\UserApp\Controllers\AdminController.postcreateuser', 'create_user_post');
$router->map('POST','/creategroup', '\UserApp\Controllers\AdminController.postcreategroup', 'create_group_post');
$router->map('POST','/user/edit/[i:id]', '\UserApp\Controllers\AdminController.postedituser', 'edit_user_post');
$router->map('POST','/group/edit/[i:id]', '\UserApp\Controllers\AdminController.posteditgroup', 'edit_group_post');

// Simple API version
$router->map('GET','/api/user/[i:id]', '\UserApp\Controllers\ApiController.singleuser', 'api_edit_user');
$router->map('GET','/api/users', '\UserApp\Controllers\ApiController.allusers', 'api_all_users');
$router->map('POST','/api/user', '\UserApp\Controllers\ApiController.createuser', 'api_create_user');
$router->map('PUT','/api/user/[i:id]', '\UserApp\Controllers\ApiController.updateuser', 'api_update_user');
$router->map('DELETE','/api/user/[i:id]', '\UserApp\Controllers\ApiController.deleteuser', 'api_delete_user');


$router->map('GET','/api/group/[i:id]', '\UserApp\Controllers\ApiController.singlegroup', 'api_edit_group');
$router->map('GET','/api/groups', '\UserApp\Controllers\ApiController.allgroups', 'api_all_groups');
$router->map('POST','/api/group', '\UserApp\Controllers\ApiController.creategroup', 'api_create_group');
$router->map('PUT','/api/group/[i:id]', '\UserApp\Controllers\ApiController.updategroup', 'api_update_group');
$router->map('DELETE','/api/group/[i:id]', '\UserApp\Controllers\ApiController.deletegroup', 'api_delete_group');

if( $match = $router->match() )
{
    list($class, $method) = explode(".", $match['target']);
    $controller = new $class;
    $controller->$method($match['params']);
    exit;
}

header("HTTP/1.0 404 Not Found");
(new UserApp\Services\ViewMaker())->render('404');


