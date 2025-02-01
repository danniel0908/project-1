<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        return view('landing.welcome');
    }
    public function about(){
        return view('landing.about');
    }
    public function staff(){
        return view('landing.staff');
    }
}
