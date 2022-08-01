<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function mail()
{
    $user = User::find(1)->toArray();
    Mail::send('emails.mailEvent', $user, function($message) use ($user) {
        $message->to('hinalbiscuitwala@gmail.com');
        $message->subject('Sendgrid Testing');
    });
    dd('Mail Send Successfully');
}
}
