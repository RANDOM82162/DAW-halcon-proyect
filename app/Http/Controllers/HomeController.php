<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $order = null;
        $searched = false;
        if ($request->has('invoice_number') && $request->invoice_number) {
            $order = \App\Models\Order::where('invoice_number', $request->invoice_number)->first();
            $searched = true;
        }

        return view('home', compact('order', 'searched'));
    }
}
