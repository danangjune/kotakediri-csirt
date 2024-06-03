@extends('layouts.main')

@section('container')
    <!-- Contact Section -->
    <div class="container" style="margin-top:8rem">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">Hubungi Kami</h1>
  
                <article class="my-3 fs-6">
                    @foreach ($keys->take(1) as $key)   
                        @foreach ($footers->take(1) as $footer)
                            <p>Lokasi {{ $footer->name }}</p>
                            
                            {{ $footer->address }}

                            <div class="col-md-8 map my-3" style="height: 300px">
                                {!! $footer->maps !!}
                            </div>

                            <p>{{ $footer->name }} dapat dihubungi melalui : </p>
                            <p>Email : {{ $footer->email }} (Silahkan gunakan PGP untuk komunikasi e-mail terenkripsi, PGP Key dapat diunduh <a href="{{'storage/' .  $key->path }}">disini</a></p>
                            <p>Telephone : {{ $footer->telephone }}</p>
                        @endforeach
                    @endforeach
                </article>

            </div>
        </div>
    </div> 
    <!-- End Contact Section -->
@endsection