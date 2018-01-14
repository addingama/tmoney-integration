<?php

namespace App\Http\Controllers\TMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function changePin(Request $request) {
        return view('profile.change_pin');
    }
}
