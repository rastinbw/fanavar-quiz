<?php

namespace App\Http\Controllers;

use App\Includes\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    public function index()
    {
        $quizzes = Constant::$QUIZ_TYPES;

        return view('main', ['quizzes' => $quizzes]);
    }

    public function showLogin()
    {
        if(!Auth::check())
            return View::make('login');
        else
            return Redirect::to('/quiz/list');
    }

    public function doLogout()
    {
        Session::flush();
        Auth::logout(); 
        return Redirect::to('login'); 
    }

    public function doLogin(Request $request)
    {
        $rules = array(
            'email'    => 'required|email', 
            'password' => 'required|alphaNum|min:3' 
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator) 
                ->withInput($request->except('password')); 
        } else {

            $userdata = array(
                'email'     => $request->input('email'),
                'password'  => $request->input('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
                return Redirect::to('/quiz/list');
            } else {
                return Redirect::to('login');
            }
        }
    }
}
