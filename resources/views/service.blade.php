@extends('layouts.main')

@section('container')
    <!-- Service Section -->
    <div class="container" style="margin-top:8rem">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                @foreach ($profils->take(1) as $profil)
                    <h1 class="mb-5">Layanan {{ $profil->name }}</h1>
                @endforeach
                
  
                <article class="my-3 fs-6">
                    @foreach ($services->take(1) as $service)
                        {!! $service->content !!}
                    @endforeach
                </article>

            </div>
        </div>
    </div> 
    <!-- End Service Section -->
@endsection