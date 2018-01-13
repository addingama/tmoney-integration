<?php

namespace App\Http\Controllers\TMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function transactionReport() {
        return view('reports.transaction');
    }
}
