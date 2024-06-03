@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create a New Post</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/posts" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title') }}">
              @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug') }}">
              @error('slug')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Category</label>
              <select class="form-select" name="category_id">
                @foreach ($categories as $category)
                  @if (old('category_id') == $category->id)
                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                  @else
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endif  
                @endforeach
              </select>
            </div>
            
            <div class="mb-3">
              <label for="image" class="form-label">Post Image</label>
              <img class="img-preview img-fluid mb-3 col-sm-8">
              <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()" required>
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="body" class="form-label">Body</label>
              @error('body')
                 <p class="text-danger">{{ $message }}</p> 
              @enderror
              <input id="body" type="hidden" name="body" value="{{ old('body') }}">
              <trix-editor class="trix-content" input="body"></trix-editor>
            </div>

            @can('admin')
              <div class="mb-3">
                <input type="checkbox" class="form-check-input @error('published') is-invalid @enderror" id="published" name="published" value="">
                <label for="flexCheckDefault" class="form-check-label">Publish</label>
                @error('published')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>
            @endcan

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>

    <script nonce="{{ csp_nonce() }}">
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        title.addEventListener('change', function(){
            fetch('/dashboard/posts/checkSlug?title=' + title.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        document.addEventListener('trix-file-accept', function(e){
            e.preventDefault();
        })

        function previewImage(){
          const image = document.querySelector('#image');
          const imgPreview = document.querySelector('.img-preview');

          imgPreview.style.display = 'block';

          const blob = URL.createObjectURL(image.files[0]);imgPreview.src = blob;
        }

    </script>
@endsection


