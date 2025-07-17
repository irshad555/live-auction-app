<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidderDashboardController extends Controller
{
    public function index()
    {
        return view('bidder.dashboard');
    }
}
