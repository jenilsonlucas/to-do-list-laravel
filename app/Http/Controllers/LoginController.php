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
        
        $remember = $request->boolean('remember');
      
        if(Auth::attempt($credentials, $remember))  {
            $request->session()->regenerate();
            return redirect()->intended('tarefas');
        }

        return back()->with('message', 'verifica os dados enviados');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
