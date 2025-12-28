<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getAuth(){
        return view('auth.register');
    }
    public function login(Request $request){
       $request->validate([
        "email" => "required|email|min:3|max:20",
        "password" => "required|string|min:6"
       ]);

      $user =  User::where('email',$request->email)->first();

      if($user && Hash::check($request->password, $user->password)){
         Auth::login($user);
        return redirect()->route('getEvents');
      }else 
      return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request){
       $request->validate([
        "username" => "required|string|min:3|max:20",
        "email" => "required|email|unique:users,email",
        "password" => "required|string|min:6",
       ]);

     $user = User::create([
        "name" => $request->username,
        "email" => $request->email,
         "password" => Hash::make($request->password)
       ]);
       Auth::login($user);
       return redirect()->route('getEvents')->with('success', 'Account created successfully!');
    }
    public function logout(Request $request){
        Auth::logout();
         $request->session()->invalidate(); 
          return redirect('/login');
    }
}
