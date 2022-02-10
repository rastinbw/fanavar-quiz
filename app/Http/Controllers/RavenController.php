<?php

namespace App\Http\Controllers;

use App\Models\RavenItem;
use Illuminate\Http\Request;
use App\Includes\RavenHelper;
use App\Models\UserRavenTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RavenController extends Controller
{
    public function index(Request $request)
    {
        // to prevent back bug
        if (Session::has('age')) {
            if (Session::get('age') != $request->query('age')) {
                $this->forgetSessions();
                $this->setEmptySheet();
                $this->setTransaction($request->query('age'));
                Session::put('age', $request->query('age'));
            }
        } else {
            Session::put('age', $request->query('age'));
        }

        // building users answersheet and puting it into session (to keep answers state on page refresh)
        if (!Session::has('user_raven_answers')) {
            $this->setEmptySheet();
        }

        if (!Session::has('current_user_raven_transaction_id')) {
            $this->setTransaction($request->query('age'));
        }

        $raven_items = RavenItem::all();

        return view('raven', ['items' => $raven_items]);
    }

    public function calculateRavenResult(Request $request)
    {
        $sheet = $request->input();
        unset($sheet['_token']);

        $final_sheet = [];
        foreach ($sheet as $key => $value) {
            $final_sheet[explode('-', $key)[0]] = $value;
        }

        if (Session::has('age')) {
            $age = Session::get('age');
        } else {
            $age = 9;
            Log::error('AGE IS NOT SET IN SESSION');
        }


        $rh = new RavenHelper();
        $iq = $rh->calculateAnswerSheet($final_sheet, $age);
        $level = $rh->getIqLevel($iq);
        
        $result = ['iq' => $iq, 'level' => $level];

        Session::put('result', $result);

        return back();
        // return redirect()->route('raven-result-display', ['result' => $result] ); 
    }

    public function displayRavenResult(Request $request)
    {
        $result = Session::get('result');

        // Debugbar::info("id: " . Session::get('current_user_raven_transaction_id'));

        if (Session::has('current_user_raven_transaction_id')) {
            UserRavenTransaction::find(Session::get('current_user_raven_transaction_id'))
                ->update([
                    'finish' => Date::now(),
                    'score' => $result['iq'],
                    'sheet' => Session::get('user_raven_answers')
                ]);
        }

        $this->forgetSessions();

        return view('raven-result', ['result' => $result]);
    }

    private function forgetSessions()
    {
        Session::forget('age');
        Session::forget('result');
        Session::forget('remaining_seconds');
        Session::forget('user_raven_answers');
        Session::forget('user_current_slide');
        Session::forget('current_user_raven_transaction_id');
    }

    // building users answersheet and puting it into session (to keep answers state on page refresh)
    private function setEmptySheet()
    {
        $user_raven_answers = null;
        for ($i = 1; $i <= 60; $i++) $user_raven_answers[$i] = "null";
        Session::put('user_raven_answers', $user_raven_answers);
    }

    private function setTransaction($age)
    {
        $userRavenTransaction = UserRavenTransaction::create([
            'user_id' => Auth::user()->id,
            'start' => Date::now(),
            'age' => $age,
        ]);
        Session::put('current_user_raven_transaction_id', $userRavenTransaction->id);
    }
}
