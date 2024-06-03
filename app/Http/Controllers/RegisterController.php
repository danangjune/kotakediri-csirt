<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Footer;
use App\Models\Profil;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\ImageProperty;
use App\Models\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index', [
            "title" => 'Register',
            "includeHero" => false,
            "active" => 'register',
            'categories' => Category::all(),
            'posts' => Post::where('published', true)->latest()->get(),
            'footers' => Footer::latest()->get(),
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
            'keys' => Key::latest()->get(),
            'propertiez'  => ImageProperty::select('image')->where('property', 'Banner')->get(),
            'properties' => ImageProperty::where('property', 'Logo')->get(),
        ]);

    }
     
    public function showChangePasswordGet() {
        return view('register.change-password',[
            "title" => 'Register',
            "includeHero" => false,
            "active" => 'register',
            'categories' => Category::all(),
            'posts' => Post::where('published', true)->latest()->get(),
            'footers' => Footer::latest()->get(),
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
            'keys' => Key::latest()->get(),
            'propertiez'  => ImageProperty::select('image')->where('property', 'Banner')->latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
        ]);
    }

    public function changePasswordUser(Request $request, User $user) {

        if (!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }
             
        $request->validate([
            'current-password' => 'required',
            'new-password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),    
            ],
        ]);

        $validatedData['password'] = bcrypt($request->get('new-password'));

        $user = Auth::user();

        //Change Password
        
        $validatedData['name'] = auth()->user()->name;
        $validatedData['email']= auth()->user()->email;
        $validatedData['username'] = auth()->user()->username;

        User::where('id', $user->id)->update($validatedData);

        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/login')->with('success', 'Password has been updated, Please login!');

    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('login')->with('success', 'Registrastion Successfull! Please Login');
    }
}
