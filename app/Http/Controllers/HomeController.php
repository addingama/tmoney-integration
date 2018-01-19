<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use JavaScript;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        JavaScript::put([
            TMONEY_TOKEN => session(TMONEY_TOKEN),
            ID_TMONEY => $user->idTmoney,
            ID_FUSION => $user->idFusion,
            'authorization' => $user->createToken('auth_token')->accessToken
        ]);
        return view('home');
    }
}
