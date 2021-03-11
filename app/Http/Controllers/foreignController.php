<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;

class foreignController extends Controller
{

public function index(){

   $user=user::find(4)->phone;
   echo "<pre>";
   echo $user;
   echo "<pre>";

}
}
