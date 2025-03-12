<?php 
namespace App\Controllers;
use Core\View;

class HomeController{

    public function home(){
        
        View::render("index.html");
    }

}

?>