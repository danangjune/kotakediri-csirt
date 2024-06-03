@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">File Panduan</h1>
    </div>

    @if (session()->has('success'))
      <div class="alert alert-success col-lg-10" role="alert">
        {{ session('success') }}
      </div> 
    @endif

    <div class="table-responsive col-lg-10 mb-4">
      <a href="/dashboard/guidances/create" class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload">Upload a New File</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Size</th>
              <th scope="col">File Path</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($guidances as $guidance)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $guidance->name }}</td>
                <td>{{ number_format(round($guidance->size / 1024, 2),2,",",".") }} Kb</td>
                <td>{{ $guidance->path }}</td>
                <td>
                    <a href="/dashboard/guidances/{{ $guidance->slug}}/edit" class="badge bg-warning text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span data-feather="edit"></span></a>
                    <form action="/dashboard/guidances/{{ $guidance->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span data-feather="x-circle"></span></button>
                    </form>
                </td>
              </tr>    
              @endforeach
          </tbody>
        </table>
    </div>
@endsection