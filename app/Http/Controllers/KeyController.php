<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\Profil;
use App\Models\ImageProperty;
use App\Http\Requests\StoreKeyRequest;
use App\Http\Requests\UpdateKeyRequest;
use Illuminate\Support\Facades\Storage;

class KeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.keys.index', [
            'profils' => Profil::latest()->get(),
            'keys' => Key::latest()->get(),
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
        return view('dashboard.keys.create', [
            'profils' => Profil::latest()->get(),
            'keys' => Key::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKeyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKeyRequest $request)
    {
        $request->validate([
            'file' => 'mimetypes:application/pgp-keys|required|max:1024'
            ]);
    
            $fileModel = new Key;
    
            if($request->file()) {
                $fileName = $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('public-key', $fileName, 'public');
    
                $fileModel->name = $request->file->getClientOriginalName();
                $fileModel->path = $filePath;
                $fileModel->save();
    
                return redirect('/dashboard/keys')->with('success', 'Public Key Has been uploaded !');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function show(Key $key)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function edit(Key $key)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKeyRequest  $request
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKeyRequest $request, Key $key)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function destroy(Key $key)
    {
        if($key->path) {
            Storage::delete($key->path);
        }
        Key::destroy($key->id);

        return redirect('/dashboard/keys')->with('success', 'File has been deleted!');
    }
}
