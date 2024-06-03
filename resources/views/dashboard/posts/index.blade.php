@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Posts</h1>
    </div>

    @if (session()->has('success'))
      <div class="alert alert-success col-lg-10" role="alert">
        {{ session('success') }}
      </div> 
    @endif

    <div class="table-responsive col-md-10 mb-5">
      <a href="/dashboard/posts/create" class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Create">Create a New Post</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              @can ('admin') <th scope="col">Author</th> @endcan
              <th scope="col">Category</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($posts as $post)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $post->title }}</td>
                @can ('admin') <td>{{ $post->author->name }}</td> @endcan
                <td>{{ $post->category->name }}</td>
                <td>{{  $post->published ? 'Publish' : 'Unpublish' }}</td>
                <td>
                  <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><span data-feather="eye"></span></a>
                  @can('admin')
                    <a href="/dashboard/posts/{{ $post->slug }}/edit" class="badge bg-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span data-feather="edit"></span></a>
                    <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span data-feather="x-circle"></span></button>
                    </form>
                  @endcan
                </td>
              </tr>    
            @endforeach
          </tbody>
        </table>
      </div>
@endsection