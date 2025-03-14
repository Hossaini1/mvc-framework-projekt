<?php 



require dirname(__DIR__). "/vendor/autoload.php";





error_reporting(E_ALL);
set_exception_handler("Core\Error::exceptionHandler");
set_error_handler("Core\Error::errorHandler");


use Core\{Request, Router};
Router::load('../routes/routes.php')->direct(Request::url(), Request::method());
?>