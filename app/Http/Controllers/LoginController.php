<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{



    /**
     * render form authentication
     */
    public function index()
    {
        return view('auth.login');
    }
    /*
    * Handle an authentication attempt 
    */

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $remember = $request->validate([
            'remember' => ['required', 'boolean']
        ]);

        if(Auth::attempt($credentials, $remember))  {
            $request->session()->regenerate();
    
            return redirect()->intended('tasks.index');
        }

        return back()->with('message', 'verifica os dados enviados');
    }

  
}
