<?php  
$router->get('','HomeController@home');
$router->get('/users','UserController@all');

?>