<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Footer;
use App\Models\Category;
use App\Models\File;
use App\Models\Profil;
use App\Models\ImageProperty;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;


class LoginController extends Controller
{

    protected $maxAttempts = 2; // Default is 5
    protected $decayMinutes = 1; // Default is 1

    public function index(){
        //echo 'test'; die;
        return view('login.index', [
            'title' => 'Login',
            'includeHero' => false,
            'profils' => Profil::latest()->get(),
            'footers' => Footer::latest()->get(),
            'categories' => Category::all(),
            'active' => 'login',
            'files' => File::latest()->get(),
            'keys' => Key::latest()->get(),
            'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'posts' => Post::where('published', true)->latest()->get()
        ]);
    }

    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            Auth::logoutOtherDevices(request('password'));

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        } 

        // return back()->with('loginError', 'Login Failed');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
