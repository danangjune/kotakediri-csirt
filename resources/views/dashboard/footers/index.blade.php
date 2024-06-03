@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Post Footer</h1>
    </div>

    @if (session()->has('success'))
      <div class="alert alert-success col-lg-10" role="alert">
        {{ session('success') }}
      </div> 
    @endif

    <div class="table-responsive col-lg-10 mb-4">
      <a href="/dashboard/footers/create" class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Create">Create a New Footer</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Address</th>
              <th scope="col">Maps</th>
              <th scope="col">Telephone</th>
              <th scope="col">Email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($footers as $footer)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $footer->name }}</td>
                <td>{{ $footer->address }}</td>
                <td class="text-break">{{ $footer->maps }}</td>
                <td>{{ $footer->telephone }}</td>
                <td>{{ $footer->email }}</td>
                <td>
                  <a href="/dashboard/footers/{{ $footer->slug}}/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="badge bg-warning text-decoration-none"><span data-feather="edit"></span></a>
                  <form action="/dashboard/footers/{{ $footer->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="badge bg-danger border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"></span></button>
                  </form>
                </td>
              </tr>    
          @endforeach
          </tbody>
        </table>
      </div>
@endsection