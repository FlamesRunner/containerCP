<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    public function save(Request $request) {
        $request->validate([
            'password_one' => 'required|max:255|min:10',
            'password_two' => 'required|same:password_one',
        ]);
        $current_user = \App\User::where('id', \Auth::id())->first();
        $current_user->password = Hash::make($request->input("password_one"));
        $current_user->save();
        $request->session()->flash('success', true);
        return redirect(route('profile.view'))->with('success', 'true');
    }

    /**
     * Show the profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('user.management.profile')->with('user', \Auth::user());
    }
}