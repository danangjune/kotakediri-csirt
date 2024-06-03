<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Support\Str;
use App\Models\ImageProperty;
use App\Http\Requests\StoreProfilRequest;
use App\Http\Requests\UpdateProfilRequest;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.profils.index', [
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'profils' => Profil::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.profils.create', [
            'profils' => Profil::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfilRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required',
            'link' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');

        Profil::create($validatedData);

        return redirect('/dashboard/profils')->with('success', 'New Profile has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function show(Profil $profil)
    {
        return view('dashboard.profils.show', [
            'profils' => Profil::latest()->get(),
            'profil' => $profil,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function edit(Profil $profil)
    {
        return view('dashboard.profils.edit', [
            'profils' => Profil::latest()->get(),
            'profil' => $profil,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfilRequest  $request
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfilRequest $request, Profil $profil)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required',
            'link' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');

        Profil::where('id', $profil->id)->update($validatedData);

        return redirect('/dashboard/profils')->with('success', 'Profile has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profil $profil)
    {
        $profil->delete();

        return redirect('/dashboard/profils')->with('success', 'Profile has been deleted!');
    }
}
