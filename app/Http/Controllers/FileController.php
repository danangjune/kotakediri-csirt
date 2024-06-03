<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Profil;
use App\Models\ImageProperty;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateFileRequest;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.files.index', [
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
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
        return view('dashboard.files.create', [
            'profils' => Profil::latest()->get(),
            'files' => File::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048'
            ]);
    
            $fileModel = new File;
    
            if($request->file()) {
                $fileName = $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
    
                $fileModel->name = $request->file->getClientOriginalName();
                $fileModel->path = $filePath;
                $fileModel->save();
    
                return redirect('/dashboard/files')->with('success', 'File Has been uploaded !');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileRequest  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if($file->path) {
            Storage::delete($file->path);
        }
        File::destroy($file->id);

        return redirect('/dashboard/files')->with('success', 'File has been deleted!');
    }
}
