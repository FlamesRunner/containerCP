<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VMController extends Controller
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
        $vms = \App\VM::where('owner', \Auth::id())->paginate(5);
        return view('user.machines.list')->with('vms', $vms);
    }
}
