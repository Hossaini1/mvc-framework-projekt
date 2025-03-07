<?php  
$router->get('','HomeController@home');
$router->get('user/{id}', 'UserController@getOne');
$router->get('users','UserController@all');


?>