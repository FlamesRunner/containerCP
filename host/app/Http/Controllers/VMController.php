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

    public function manage_index($ctid) {
        if (\App\VM::where('owner', \Auth::id())->where('id', $ctid)->count() == 0) {
            return redirect(route('vm.list'));
        }
        return view('user.machines.manage')->with('vm', \App\VM::where('owner', \Auth::id())->where('id', $ctid)->first());
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
