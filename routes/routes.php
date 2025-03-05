<?php  
$router->get('','HomeController@home');
$router->get('/users/{id}','UserController@all');

?>