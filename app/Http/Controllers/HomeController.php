<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function about()
    {
        return view('about');
    }
    public function doctors()
    {
        $doctors=User::whereHas('roles', function($q)
        {
            $q->where('name', 'doctor');
        })->paginate(20);
        return view('doctors')->with(['doctors'=>$doctors]);
    }
}
