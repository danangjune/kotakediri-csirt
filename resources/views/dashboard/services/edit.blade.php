@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit a Service</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/services/{{ $service->slug }}" class="mb-5">
            @method('put')
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name', $service->name) }}">
              @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="content" class="form-label">Content</label>
              @error('content')
                 <p class="text-danger">{{ $message }}</p> 
              @enderror
              <input id="content" type="hidden" name="content" value="{{ old('content', $service->content) }}">
              <trix-editor class="trix-content" input="content"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">Update Service</button>
        </form>
    </div>

    <script>
        document.addEventListener('trix-file-accept', function(e){
            e.preventDefault();
        })
    </script>
@endsection


