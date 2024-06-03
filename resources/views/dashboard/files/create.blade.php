@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload New File</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/files" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="file" class="form-label">File</label>
              <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required value="{{ old('file') }}" >
              @error('file')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection


