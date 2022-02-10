<?php

namespace App\Http\Controllers;

use App\Includes\MdqHelper;
use App\Includes\RavenHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request){
        $raven_result = Auth::user()->userRavenTransactions()->where('sheet', '<>', null)->latest('id')->first([
            'id',
            'start',
            'finish',
            'score',
            'age',
        ]);

        if($raven_result){
            $rh = new RavenHelper();
            $raven_result = $raven_result->toArray();
            $raven_result['level'] =  $rh->getIqLevel($raven_result['score']);
        }

        $mdq_result = Auth::user()->userMdqTransactions()->where('sheet', '<>', null)->latest('id')->first([
            'start',
            'finish',
            'level',
            'sheet'
        ]);
       
        if($mdq_result){
            $mh = new MdqHelper();
            $mdq_result = $mdq_result->toArray();
            $mdq_result['exercises'] = $mh->getUserExercisesTable((array)json_decode($mdq_result['sheet']));
            unset($mdq_result['sheet']);
        }

        return view('profile', ['raven_result' => $raven_result, 'mdq_result' => $mdq_result]);
    }
}
