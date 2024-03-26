<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    
   private $user;

    public function registerstore(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login');
    }

    public function login(Request $request)
    { 
        // return $request;
          $this->user = User::where('email', $request->email)->first();

         if ($this->user) {
            if (Hash::check($request->password,$this->user->password))
            {
                Session::put('user_id', $this->user->id);
                Session::put('user_name', $this->user->name);
                return redirect('/dashboard');
                 
            } else {
                return back()->with('message', 'invalid password');
            }
        } else {
            return back()->with('message', 'invalid email address');
        }

       


    }
              
    public function logout(){
        Session::forget('user_id');
        Session::forget('user_name');
        return redirect('/login');
    }
}