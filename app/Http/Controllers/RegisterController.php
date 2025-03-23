<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    

    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(Request $request): RedirectResponse
    {
    
    }
}
