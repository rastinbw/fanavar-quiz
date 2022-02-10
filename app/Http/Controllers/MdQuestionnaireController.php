<?php

namespace App\Http\Controllers;

use App\Includes\Constant;
use App\Includes\MdqHelper;
use App\Models\MdItem;
use App\Models\UserMdqTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;

class MdQuestionnaireController extends Controller
{
    public function index(Request $request){
        // to prevent back bug
        if(Session::has('age')){
            if(Session::get('age') != $request->query('age')){
                $this->forgetSessions();
                $this->setEmptySheet($request->query('age'));
                $this->setTransaction($request->query('age'));
                Session::put('age', $request->query('age'));
            }
        }else { Session::put('age', $request->query('age')); }


        // set empty sheet
        if(!Session::has('user_mdq_answers')){
            $this->setEmptySheet($request->query('age'));
        }
        
        // set transaction
        if (!Session::has('current_user_mdq_transaction_id')) {
           $this->setTransaction($request->query('age'));
        }

        $mdq_items = MdItem::where('level', $request->query('age'))->get(['question', 'level']);

        // for($i = 52; $i < 72; $i++){
        //     $item = MdItem::find($i);
        //     $item->exercises = json_encode([
        //         [
        //             "content" => "یک سیب کوچک و یک سیب بزرگ یا یک میوه ی مشابه آن را انتخاب کنید و مفهوم کوچک و بزرگ را به کودک آموزش دهید.",
        //             "image" => "/images/mdq-exercies-images/1.png"
        //         ],
        //         [
        //             "content" => "تعدادی مکعب پلاستیکی را انتخاب کنید و سعی کنید با نشان دادن مکعب بزرگ و کوچک تدریجا کودک را با مفهوم بزرگ و کوچک آشنا کنید.",
        //             "image" => "/images/mdq-exercies-images/2.png"
        //         ],
        //     ]);
        //     $item->save();
        // }

        return view('mdq',['items'=>$mdq_items]);
    }

    public function calculateMdqResult(Request $request){
        $sheet = $request->input();
        unset($sheet['_token']);
        Session::put('result', $sheet);

        return back();
    }

    public function displayMdqResult(Request $request){
        $mh = new MdqHelper();
        $result = $mh->getUserExercisesTable(Session::get('result'));
        
        if (Session::has('current_user_mdq_transaction_id')) {
            UserMdqTransaction::find(Session::get('current_user_mdq_transaction_id'))
                ->update([
                    'finish' => Date::now(),
                    'sheet' => Session::get('user_mdq_answers')
                ]);
        }

        $this->forgetSessions();
       
        return view('mdq-result', ['result' => $result]);
    }

    private function forgetSessions(){
        Session::forget('age');
        Session::forget('result');
        Session::forget('user_mdq_answers');
        Session::forget('current_user_mdq_transaction_id');
    }
    
    // building users answersheet and puting it into session (to keep answers state on page refresh)
    private function setEmptySheet($age){
        $user_mdq_answers = null;

        $count = ($age == Constant::$MD_LEVEL_ONE_TO_THREE) 
            ? Constant::$MD_LEVEL_ONE_TO_THREE_QUESTION_COUNT 
            : Constant::$MD_LEVEL_THREE_TO_SIX_QUESTION_COUNT;

        for($i = 1; $i <= $count; $i++) $user_mdq_answers[$i] = "null";

        Session::put('user_mdq_answers', $user_mdq_answers);
    }

    private function setTransaction($age){
        $userMdqTransaction = UserMdqTransaction::create([
            'user_id' => Auth::user()->id,
            'start' => Date::now(),
            'level' => $age,
        ]);

        Session::put('current_user_mdq_transaction_id', $userMdqTransaction->id);
    }

}
