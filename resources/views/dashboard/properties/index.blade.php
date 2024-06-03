@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Image Property</h1>
    </div>

    @if (session()->has('success'))
      <div class="alert alert-success col-lg-8" role="alert">
        {{ session('success') }}
      </div> 
    @endif

    <div class="table-responsive col-lg-8 mb-4">
      <a href="/dashboard/properties/create" class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Create">Create a New Property</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Property</th>
              <th scope="col">Name</th>
              <th scope="col">Image</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($properties as $property)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $property->property }}</td>
                <td>{{ $property->name }}</td>
                <td>
                  <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->name }}" class="img-fluid col-sm-5">
                </td>
                <td>
                  <a href="/dashboard/properties/{{ ($property->slug) }}/edit" class="badge bg-warning text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span data-feather="edit"></span></a>
                  <form action="/dashboard/properties/{{ ($property->slug) }}" method="post" class="d-inline">
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