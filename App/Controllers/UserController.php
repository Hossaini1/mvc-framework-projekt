<?php 

namespace App\Controllers;

use Core\Controller;
use App\Model\User;
use Core\View;

class UserController extends Controller{

   public function getOne($id){
        $user = new User();
        $user = $user->getById($id[0]);
        
       if ($user) {
        View::render("user/index.html", ['name' => $user->name, 'id'=> $user->id]);
       }else{
        View::render("404.html");
       }

    }






}
?>