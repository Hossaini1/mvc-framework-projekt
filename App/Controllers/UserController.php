<?php 

namespace App\Controllers;

use Core\Controller;
use App\Model\User;
use Core\View;

class UserController extends Controller{

   public function getOne($id){
        $user = new User();
        $user = $user->getById($id[0]);
        
       
        View::render("user/index.html", ['name' => $user->name, 'id'=> $user->id]);
     

       

    }

    public function all (){
      $user = new User();
      $users = $user->getAll();

      View::render("user/list.html",['users' => $users]);
    }






}
?>