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
        $this->middleware('auth', ['except' => ['index','privacy','termsCondition','faq','help','successRegister']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
    public function privacy()
    {
        return view('privacy');
    }
    public function termsCondition()
    {
        return view('terms');
    }
    public function faq() {
        return view('faq');
    }
    public function help() {
        return view('help');
    }
    public function successRegister() {
        return view('auth.success-register');
    }

}
