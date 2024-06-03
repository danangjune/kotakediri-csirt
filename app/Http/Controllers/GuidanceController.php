<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Profil;
use App\Models\Guidance;
use Illuminate\Support\Str;
use App\Models\ImageProperty;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreGuidanceRequest;
use App\Http\Requests\UpdateGuidanceRequest;
use Ramsey\Uuid\Guid\Guid;

class GuidanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.guidances.index', [
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
            'guidances' => Guidance::all(),
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
        return view('dashboard.guidances.create', [
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
            'guidances' => Guidance::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGuidanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuidanceRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|unique:guidances,file_name'
            ]);
    
            $fileModel = new Guidance;
    
            if($request->file()) {
                $fileName = $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads-guidances', $fileName, 'public');
                $fileSize = $request->file->getSize();
                $fileSlug = Str::slug($request->name,'-');
                    
                $fileModel->name = $request->name;
                $fileModel->file_name = $fileName;
                $fileModel->slug = $fileSlug;
                $fileModel->size = $fileSize;
                $fileModel->path = $filePath;
                $fileModel->save();
    
                return redirect('/dashboard/guidances')->with('success', 'File Has been uploaded !');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guidance  $guidance
     * @return \Illuminate\Http\Response
     */
    public function show(Guidance $guidance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guidance  $guidance
     * @return \Illuminate\Http\Response
     */
    public function edit(Guidance $guidance)
    {
        return view('dashboard.guidances.edit', [
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
            'guidances' => Guidance::all(),
            'guidance' => $guidance,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGuidanceRequest  $request
     * @param  \App\Models\Guidance  $guidance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuidanceRequest $request, Guidance $guidance)
    {
        $rules = [
            'file' => 'mimes:pdf|unique:guidances, file_name'
        ];

        if($request->name != $guidance->name){
            $rules['name'] = 'required|string|max:255|unique:name';
        }

        $validatedData = $request->validate($rules);

        if($request->file('file')) {
            if($guidance->path){
                Storage::delete($guidance->path);
            }
            $validatedData['file_name'] = $request->file->getClientOriginalName();
            $validatedData['path'] = $request->file('file')->storeAs('uploads-guidances', $validatedData['file_name'], 'public');
            $validatedData['size'] = $request->file->getSize();
            $validatedData['slug'] = Str::slug($request->name,'-');
        }

        Guidance::where('id', $guidance->id)->update($validatedData);

        return redirect('/dashboard/guidances')->with('success', 'Panduan has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guidance  $guidance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guidance $guidance)
    {
        if($guidance->path) {
            Storage::delete($guidance->path);
         }
         Guidance::destroy($guidance->id);
 
         return redirect('/dashboard/guidances')->with('success', 'Panduan has been deleted!');
    }
}
