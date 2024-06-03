@extends('layouts.main')

@section('container')

    <div class="container mb-4 d-flex justify-content-center" style="margin-top: 7rem">
        <div class="col-md-8">
            @foreach ($profils->take(1) as $profil)
                <h2 class="text-center mt-3">RFC2350 {{ $profil->name }}</h2>
            @endforeach
            <br />
            <hr class="mx-auto" style="width: 50%">
            <br />
            <div id="my_pdf" class="mb-4"></div>
        </div>      
    </div>


    <script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
    @foreach ($files->take(1) as $file)
      <script nonce="{{ csp_nonce() }}">PDFObject.embed("{{ asset('storage/' . $file->path) }}", "#my_pdf");</script>
    @endforeach 
            
@endsection