<?php

namespace App\Http\Controllers;


use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{

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
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($attributes)) {
            $user = Auth()->user();
            if ($user->hasAnyRoles(['admin','doctor'])) {
                return redirect("/admin/dashboard");
            } else {
                return redirect(route('home'));
            }
        } else {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verifed.'
            ]);

        }


    }
}
