@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create a Property</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/properties" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
              @error('name')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="property" class="form-label">Property</label>
              <select class="form-select" id="property" name="property">
                <option value="Logo" >Logo</option>
                <option value="Banner" >Banner</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">Image Property</label>
              <img class="img-preview img-fluid mb-3 col-sm-5">
              <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Property</button>
        </form>
    </div>

    <script>
        function previewImage(){
          const image = document.querySelector('#image');
          const imgPreview = document.querySelector('.img-preview');

          imgPreview.style.display = 'block';

          const blob = URL.createObjectURL(image.files[0]);imgPreview.src = blob;
        }
    </script>
@endsection


