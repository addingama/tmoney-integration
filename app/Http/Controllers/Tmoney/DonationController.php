<?php

namespace App\Http\Controllers\Tmoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    public function inquiry(Request $request) {
        return view('donation.inquiry');
    }

}
