<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','privacy','termsCondition']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('welcome');
        return view('maintenance');
    }
    public function privacy()
    {
        return view('privacy');
    }
    public function termsCondition()
    {
        return view('terms');
    }
}
