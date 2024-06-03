<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\Service;
use Illuminate\Support\Str;
use App\Models\ImageProperty;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.services.index', [
            'profils' => Profil::latest()->get(),
            'services' => Service::latest()->get(),
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
        return view('dashboard.services.create', [
            'profils' => Profil::latest()->get(),
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');

        Service::create($validatedData);

        return redirect('/dashboard/services')->with('success', 'New Service has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('dashboard.services.show', [
            'profils' => Profil::latest()->get(),
            'service' => $service,
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('dashboard.services.edit', [
            'profils' => Profil::latest()->get(),
            'service' => $service,
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');

        Service::where('id', $service->id)->update($validatedData);

        return redirect('/dashboard/services')->with('success', 'Service has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect('/dashboard/services')->with('success', 'Service has been deleted!');
    }
}
