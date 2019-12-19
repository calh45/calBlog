<?php


namespace App\Http\Controllers;


use App\Post;
use App\SkyScanner;

class apiTestController extends Controller
{

    public function exampleMethod(Post $foo, SkyScanner $t) {
        dd($t);
        return "this works";
    }
}