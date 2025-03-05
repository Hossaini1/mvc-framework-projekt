<?php 
// hier wir loaden die autoload hier und autoload lodet alle classen hier automatisch ! ohne autoload mussen wir manuel alle classen loaden weil php weiss nicht wo sind undere klassen.
// requure dirname(__DIR__) holt unsere pfad bis unsere ordner projekt zb. bis public danach wir geben rest pfad bis ziel ordner.
require dirname(__DIR__). "/vendor/autoload.php";

use Core\{Request, Router};

Router::load('../routes/routes.php')->direct(Request::url(), Request::method());

?>