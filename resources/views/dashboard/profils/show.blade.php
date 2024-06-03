@extends('dashboard.layouts.main')

@section('container')

<div class="container">
    <div class="row my-3">
        <div class="col-lg-8">
            <h1 class="mb-3">{{ $profil->name }}</h1>

            <a href="/dashboard/profils" class="btn btn-success"><span data-feather="arrow-left"></span> Back</a>
            <a href="/dashboard/profils/{{ ($profil->slug) }}/edit" class="btn btn-warning"><span data-feather="edit"></span> Edit</a>
            <form action="/dashboard/profils/{{ ($profil->slug) }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"></span> Delete</button>
            </form>
            
           
            <article class="my-3 fs-6">
                {!! $profil->content !!}
            </article>

        </div>
    </div>
</div> 

@endsection

