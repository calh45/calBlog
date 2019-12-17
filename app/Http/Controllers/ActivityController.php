<?php


namespace App\Http\Controllers;


use App\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityController
{

    public function index() {
        $activitiesToReturn = Activity::all();
        $currentLoggedIn = Auth::user();

        return view("activity", ["activities" => $activitiesToReturn, "currentLoggedIn" => $currentLoggedIn]);
    }
}