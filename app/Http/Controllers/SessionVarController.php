<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionVarController extends Controller
{
    public function setRemainingSeconds(Request $request){
        Session::forget('remaining_seconds');
        Session::put('remaining_seconds', $request->query('seconds'));
        return response()->json(['message' => 'successfull'],200);
    }
    
    public function forgetRemainingSeconds(){
        Session::forget('remaining_seconds');
        return response()->json(['message' => 'successfull'],200);
    }

    public function setUserRavenAnswer(Request $request){
        $user_raven_answers = [];

        if(Session::has('user_raven_answers')){
            $user_raven_answers = Session::get('user_raven_answers');
            $user_raven_answers[$request->query('number')] = $request->query('selected_option');
            Session::forget('user_raven_answers');
        }else {
            for($i = 1; $i <= 60; $i++) $user_raven_answers[$i] = "null";
        }

        Session::put('user_raven_answers', $user_raven_answers);
        
        return response()->json(['message' => 'successfull'],200);
    }

    public function forgetUserRavenAnswer(){
        Session::forget('user_raven_answers');
        return response()->json(['message' => 'successfull'],200);
    }

    public function setUserCurrentSlide(Request $request){
        Session::forget('user_current_slide');
        Session::put('user_current_slide', $request->query('user_current_slide'));
        return response()->json(['message' => 'successfull'],200);
    }

    public function forgetUserCurrentSlide(){
        Session::forget('user_current_slide');
        return response()->json(['message' => 'successfull'],200);
    }

    public function setUserMdqAnswer(Request $request){
        $user_raven_answers = [];

        if(Session::has('user_mdq_answers')){
            $user_raven_answers = Session::get('user_mdq_answers');
            $user_raven_answers[$request->query('number')] = $request->query('selected_option');
            Session::forget('user_mdq_answers');
        }else {
            for($i = 1; $i <= 60; $i++) $user_raven_answers[$i] = "null";
        }

        Session::put('user_mdq_answers', $user_raven_answers);
        
        return response()->json(['message' => 'successfull'],200);
    }

    public function forgetUserMdqAnswer(){
        Session::forget('user_mdq_answers');
        return response()->json(['message' => 'successfull'],200);
    }
}
