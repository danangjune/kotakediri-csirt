@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Profile</h1>
    </div>

    @if (session()->has('success'))
      <div class="alert alert-success col-lg-10" role="alert">
        {{ session('success') }}
      </div> 
    @endif

    <div class="table-responsive col-lg-10 mb-5">
      <a href="/dashboard/profils/create" class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Create">Create Profile</a> 
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Link Ticketing</th>
              <th scope="col">Content</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($profils as $profil)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $profil->name }}</td>
                <td>{{ $profil->link }}</td>
                <td>{{ $profil->content }}</td>
                <td>
                  <a href="/dashboard/profils/{{ ($profil->slug) }}" class="badge bg-info text-decoration-none d-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><span data-feather="eye"></span></a>
                  <a href="/dashboard/profils/{{ ($profil->slug) }}/edit" class="badge bg-warning text-decoration-none d-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span data-feather="edit"></span></a>
                  <form action="/dashboard/profils/{{ ($profil->slug) }}" method="post" class="d-inline">
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