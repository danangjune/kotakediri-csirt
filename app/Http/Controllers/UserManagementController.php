<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\ImageProperty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.index', [
            'profils' => Profil::latest()->get(),
            'users' => User::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', [
            'profils' => Profil::latest()->get(),
            'user' => $user,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'users' => User::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $rules = [
            'name' => 'required|max:255'
        ];

        if($request->username != $user->username) {
            $rules['username'] = ['required', 'min:3', 'max:255', 'unique:users', 'regex:/^([a-z])+?(-|_|.)([a-z])+$/i'];
        }

        if($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if (!$user->is_superadmin) {
            $rules['password'] = [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), 
            ];
        }

        $validatedData = $request->validate($rules);

        if($request->has('is_admin') || $user->is_superadmin){
            $validatedData['is_admin'] = true;
        } else {
            $validatedData['is_admin'] = false;
        }

        if($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
 
        User::where('id', $user->id)->update($validatedData);

        return redirect('/dashboard/users')->with('success', 'User has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
