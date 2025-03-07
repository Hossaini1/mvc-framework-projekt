<?php 
// debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// htaccess datei ist für einstellungen von server apache, apache wenn run ist sucht zuerst htaccess datei welche cofigurationen da gibt mit welche bedingunen und versucht sie auszuführen und überschreibt apache configurationen.

// hier wir loaden die autoload hier und autoload lodet alle classen hier automatisch ! ohne autoload mussen wir manuel alle classen loaden weil php weiss nicht wo sind undere klassen.
// requure dirname(__DIR__) holt unsere pfad bis unsere ordner projekt zb. bis public danach wir geben rest pfad bis ziel ordner.
require dirname(__DIR__). "/vendor/autoload.php";

use Core\{Request, Router};

// Router::load('../routes/routes.php')->direct(Request::url(), Request::method());
Router::load('../routes/routes.php')->direct(Request::url(), Request::method());
?>