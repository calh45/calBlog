<?php


namespace App\Http\Controllers;


use App\Activity;
use Illuminate\Support\Facades\Auth;

/**
 * Class ActivityController
 * @package App\Http\Controllers
 */
class ActivityController
{

    /**
     * Creates and returns Activity view with appropriate variables
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $activitiesToReturn = Activity::all(); //All Activity models
        $currentLoggedIn = Auth::user(); //Current logged in user

        return view("activity", ["activities" => $activitiesToReturn, "currentLoggedIn" => $currentLoggedIn]);
    }
}