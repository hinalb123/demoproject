<?php

use App\Http\Controllers\PaypalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\TextToSpeechController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'auth'], function(){

Route::get('/adduser',[UserController::class,'adduser'])->name('adduser');

Route::post('/saveuser',[UserController::class,'saveuser'])->name('saveuser');

Route::get('/show',[UserController::class,'show'])->name('show');

Route::get('/showuser',[UserController::class,'showuser'])->name('showuser');

Route::get('/deleteuser/{id}',[UserController::class,'deleteuser'])->name('deleteuser');

Route::get('/updateuser/{id}',[UserController::class,'updateuser'])->name('updateuser');

Route::post('/edituser',[UserController::class,'edituser'])->name('edituser');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('mail', [App\Http\Controllers\HomeController::class, 'mail']);



Route::get('/apicall1',[UserController::class,'callapi1'])->name('callapi1');

Route::post('/apicall',[UserController::class,'callapi'])->name('callapi');

Route::get('/fileupload',[UserController::class,'fileupload'])->name('fileupload');

Route::post('/fileupload1',[UserController::class,'fileupload1'])->name('fileupload1');

Route::get('create-transaction', [PaypalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');

Route::get('auth/google', [GoogleController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class,'handleGoogleCallback']);

 
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleController::class, 'handleCallback']);

Route::get('stripe', [UserController::class,'stripe']);
Route::post('stripe', [UserController::class,'stripePost'])->name('stripe.post');

Route::get('/google-calendar/connect',[TextToSpeechController::class,'connect']);
Route::post('/google-calendar/connect', [TextToSpeechController::class,'store']);
Route::get('get-resource', [TextToSpeechController::class,'getResources']);



Route::get('/text', [TextToSpeechController::class,'index']);
Route::get('text-to-speech-convert', [TextToSpeechController::class,'TextToSpeechConvert'])->name('text-to-speech-convert');

