<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SocialiteManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct(
        private SocialiteManager $manager
    )
    {
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        
        $remember = $request->boolean('remember');
      
        if(Auth::attempt($credentials, $remember))  {
            $request->session()->regenerate();
            return redirect()->intended('app');
        }

        return back()->with('credentials', 'Verifique seu email e senha e tente novamente');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function redirect(string $string)
    {
        return $this->manager->driver($string)->redirectToProvider();
    }

    public function callback(string $string)
    {
        return $this->manager->driver($string)->handleProviderCallback();
    }

}
