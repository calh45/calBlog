<?php


namespace App\Http\Controllers;


use App\Post;
use App\Twitter;

class apiTestController extends Controller
{

    public function exampleMethod(Post $foo, Twitter $t) {
        dd($t);
        return "this works";
    }
}