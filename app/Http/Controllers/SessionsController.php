<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class SessionsController extends Controller
{
    //
    public function destroy()
    {
        auth()->logout();
        return redirect("/");
    }

    public function create()
    {
        return view('login');
    }

    public function store()
    {
        $attributes=request()->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth()->attempt($attributes))
        {
            $user=Auth()->user();
            if($user->hasRole('admin'))
            {
               return redirect("/admin/dashboard");
            }
            else
            {
                return redirect('/');
            }
        }


        throw ValidationException::withMessages([
            'email'=>'Your provided credentials could not be verifed.'
        ]);


    }
}
