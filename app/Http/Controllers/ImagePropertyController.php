<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Support\Str;
use App\Models\ImageProperty;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreImagePropertyRequest;
use App\Http\Requests\UpdateImagePropertyRequest;

class ImagePropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('dashboard.properties.index', [
            'profils' => Profil::latest()->get(),
            'properties' => ImageProperty::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.properties.create', [
            'profils' => Profil::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImagePropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImagePropertyRequest $request)
    {
        $validatedData = $request->validate([
            'property' => 'required|max:255',
            'name' => 'required|max:255|unique:image_properties',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('image-property');
        }

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');

        ImageProperty::create($validatedData);

        return redirect('/dashboard/properties')->with('success', 'New Property has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageProperty  $imageProperty
     * @return \Illuminate\Http\Response
     */
    public function show(ImageProperty $imageProperty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImageProperty  $imageProperty
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageProperty $property)
    {
        return view('dashboard.properties.edit', [
            'profils' => Profil::latest()->get(),
            'property' => $property,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImagePropertyRequest  $request
     * @param  \App\Models\ImageProperty  $imageProperty
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImagePropertyRequest $request, ImageProperty $property)
    {
        $rules = [
            'property' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        if($request->name != $property->name){
            $rules['name'] = 'required|max:255|unique:image_properties';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($property->image){
                Storage::delete($property->image);
            }
            $validatedData['image'] = $request->file('image')->store('image-property');
        }

        $validatedData['slug'] = Str::slug($request->name,'-');

        ImageProperty::where('id', $property->id)->update($validatedData);

        return redirect('/dashboard/properties')->with('success', 'Property has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageProperty  $imageProperty
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageProperty $property)
    {
        
        if($property->image) {
           Storage::delete($property->image);
        }
        ImageProperty::destroy($property->id);

        return redirect('/dashboard/properties')->with('success', 'Property has been deleted!');
    }
}
