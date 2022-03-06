<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    //
    public function create()
    {
        return view('signup');
    }
    public function store()
    {
       $attributes=request()->validate([
            'name'=>'required|max:255',
            'surname'=>'required|max:255',
            'email'=>'required|email|max:255|unique:users,email',
            'gender'=>'required',
            'password'=>'required|max:255|min:8',
            'rPassword'=>'required|max:255|min:8|same:password'
        ]);


    $user=User::create($attributes);
    $user->assignRole('patient');

    auth()->login($user);

    session()->flash('success','Your account has been created');

    return redirect('/');



    }

}
