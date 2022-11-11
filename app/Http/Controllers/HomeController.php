<?php

namespace App\Http\Controllers;

use App\Interfaces\HomeInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['index','privacy','termsCondition','faq','help','successRegister']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('test')) {
            return view('welcome');
        }
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
