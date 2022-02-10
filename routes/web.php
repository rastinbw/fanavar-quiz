<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\MdQuestionnaireController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RavenController;
use App\Http\Controllers\SessionVarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'showLogin']);
Route::get('/login',  [MainController::class, 'showLogin']);
Route::post('/login',  [MainController::class, 'doLogin']);
Route::get('/logout', [MainController::class, 'doLogout']);

Route::get('/session/set/remainingseconds', [SessionVarController::class, 'setRemainingSeconds']);
Route::get('/session/forget/remainingseconds', [SessionVarController::class, 'forgetRemainingSeconds']);

Route::get('/session/set/user/raven/answers', [SessionVarController::class, 'setUserRavenAnswer']);
Route::get('/session/forget/user/raven/answers', [SessionVarController::class, 'forgetUserRavenAnswer']);

Route::get('/session/set/user/raven/slide/current', [SessionVarController::class, 'setUserCurrentSlide']);
Route::get('/session/forget/user/raven/slide/current', [SessionVarController::class, 'forgetUserCurrentSlide']);

Route::get('/session/set/user/mdq/answers', [SessionVarController::class, 'setUserMdqAnswer']);
Route::get('/session/forget/user/mdq/answers', [SessionVarController::class, 'forgetUserMdqAnswer']);

Route::middleware(['auth'])->group(function () {
    Route::get('/quiz/list', [MainController::class, 'index'])->name('quiz-list');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/ageinput/{quiz}', function($quiz){
        return view('/ageinput')->with(['quiz'=>$quiz]);
    })->name('ageinput');

    Route::get('/playground/raven', [RavenController::class, 'index'])->name('raven');
    Route::post('/playground/raven/result/calculate', [RavenController::class, 'calculateRavenResult'])->name('raven-result-calculate');
    Route::get('/playground/raven/result/display', [RavenController::class, 'displayRavenResult'])->name('raven-result-display');

    Route::get('/playground/mdq/questionnaire', [MdQuestionnaireController::class, 'index'])->name('mdq-questionnaire');
    Route::post('/playground/mdq/questionnaire/result/calculate', [MdQuestionnaireController::class, 'calculateMdqResult'])->name('mdq-result-calculate');
    Route::get('/playground/mdq/result/display', [MdQuestionnaireController::class, 'displayMdqResult'])->name('mdq-result-display');

});
