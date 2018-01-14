<?php

namespace App\Http\Controllers\TMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function topupPrepaid(Request $request) {
        return view('purchase.topup_prepaid');
    }
}
