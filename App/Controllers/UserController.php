<?php 

namespace App\Controllers;

use Core\Controller;
use App\Model\User;

class UserController extends Controller{

   public function getOne($id){
        $user = new User();
        $user = $user->getById($id[0]);
        var_dump($user);

    }


}
?>