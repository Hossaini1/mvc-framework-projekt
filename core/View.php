<?php 
namespace Core;

class View{
    public static function render($template, $args=[]){

        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/App/Views');
            $twig = new \Twig\Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}

?>