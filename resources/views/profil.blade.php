@extends('layouts.main')

@section('container')
    <!-- Profil Section -->
    <div class="container" style="margin-top:120px">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                @foreach ($profils->take(1) as $profil)
                    <h1 class="mb-5">Profil  {{ $profil->name }}</h1>
                @endforeach
                
  
                <article class="my-3 fs-6">
                    @foreach ($profils->take(1) as $profil)
                        {!! $profil->content !!}
                    @endforeach
                </article>

            </div>
        </div>
    </div> 
    <!-- End Profil Section -->
@endsection