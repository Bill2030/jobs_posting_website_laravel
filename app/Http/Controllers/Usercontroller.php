<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Usercontroller extends Controller
{
   public function create()
   {
    return view("users.create");
   }

public function store(Request $request)
{
    $formFields = $request->validate([
        "name"=> "required",
        "email"=> ["required", "email"],
        "password"=> ['required', 'confirmed'],
    ]);

    $formFields['password'] =bcrypt($formFields['password']);
    $user = User::create($formFields);
    Auth::login($user);

    return redirect()->route('home.index')->with('success','User created and Logged in');
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerate();
    return redirect()->route('home.index')->with('success','user Logged out successfully');

}

public function login()
{
    return view('users.login');
}

public function loggedin(Request $request)
{
    $formFields = $request->validate([
        'email'=> ['required', 'email'],
        'password'=> 'required',

    ]);
    $formFields = $request->only('email','password');
    if(Auth::attempt($formFields)){
        $request->session()->regenerate();

        return redirect()->route('home.index')->with('success','congratulations you are logged in');
    }
    return back()->withErrors(['email'=>'invalid credentials'])->onlyInput('email');

}
}
