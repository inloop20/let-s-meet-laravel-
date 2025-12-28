<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(){
        $user = Auth::user();
        return view('profile',compact('user'));
    }

  public function update(Request $request)
{
    $user = User::find(Auth::id()); 

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6',
    ]);

     $user->name = $validated['name'];
    $user->email = $validated['email'];

    
    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']);
    }

    $user->save(); 

    return back()->with('success', 'Profile updated successfully!');
}
}
