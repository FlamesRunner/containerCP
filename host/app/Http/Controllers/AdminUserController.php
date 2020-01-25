<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
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
            'password' => 'nullable|max:255|min:10',
            'name' => 'required|max:255|min:1',
            'email' => 'required|max:255|min:3|email:rfc,dns',
            'role' => 'required|min:0|integer'
        ]);

        if (\Auth::id() == $request->input('id')) {
        	$request->session()->flash('error', 'self');
        	return redirect(route('admin.profile', [$request->input('id')]));        	
        }

		if (\Auth::user()->role >= $request->input('role')) {
        	$request->session()->flash('error', 'insufficient_perm');
        	return redirect(route('admin.profile', [$request->input('id')]));
		}

		if (\App\User::where('id', $request->input('id'))->count() == 0) {
    		return redirect(route('admin.users'));
    	}

        $current_user = \App\User::where('id', $request->input('id'))->first();
        $current_user->name = $request->input('name');
        $current_user->email = $request->input('email');
        $current_user->role = $request->input('role');

        if (!empty($request->input('password'))) {
        	$current_user->password = Hash::make($request->input("password"));
    	}
        $current_user->save();
        $request->session()->flash('success', true);
        return redirect(route('admin.profile', [$current_user->id]))->with('success', 'true');
    }

    public function delete(Request $request, $uid) {
        if (\Auth::id() == $uid) {
        	$request->session()->flash('error', 'self');
        	return redirect(route('admin.users'));        	
        }

 		if (\App\User::where('id', $uid)->count() == 0) {
    		return redirect(route('admin.users'));
    	}	

        $current_user = \App\User::where('id', $uid)->first();

		if (\Auth::user()->role >= $current_user->role) {
        	$request->session()->flash('error', 'insufficient_perm');
        	return redirect(route('admin.users'));
		}

        $current_user->delete();

        $request->session()->flash('success', true);
        return redirect(route('admin.users'));
    }

    public function profile_index($uid, Request $request) {
    	if (\App\User::where('id', $uid)->count() == 0) {
    		return redirect(route('admin.users'));
    	}
		if (\Auth::user()->role > \App\User::where('id', $uid)->first()->role) {
        	$request->session()->flash('error', 'insufficient_perm');
        	return redirect(route('admin.users'));
		}
        if (\Auth::id() == $uid) {
        	$request->session()->flash('error', 'self');  	
        }
    	return view('admin.management.profile')->with('user', \App\User::where('id', $uid)->first());
    }

    /**
     * Show users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
		if (\Auth::user()->role >= 1000) {
        	return redirect(route('home'));
		}
        return view('admin.management.view_users')->with('users', \App\User::where('role', '>=', \Auth::user()->role)->paginate(10));
    }
}