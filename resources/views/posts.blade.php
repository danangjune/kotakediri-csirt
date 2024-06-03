@extends('layouts.main')

@section('container')

<div class="container" style="margin-top:120px">
    <h1 class="my-3 text-center">{{ $title }}</h1>

    <div class="row justify-content-center my-4">
        <div class="col-md-6">
            <form action="/posts">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-danger" type="submit" >Search</button>
                </div>
            </form>
        </div>
    </div>

    @if ($posts->count())
        <div class="card my-4">

            <div class="card">
               <img src="{{ asset('storage/' . $posts[0]->image) }}" alt="{{ $posts[0]->category->name }}" class="img-fluid" style="max-height: 400px; object-fit: cover"> 
            </div>
            
            <div class="card-body text-center">
                <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
                    <p>
                        <small class="text-muted">
                        By <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $posts[0]->author->name }}</a> in <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none">{{ $posts[0]->category->name }}</a> at <span class="text-dark">{{ date('F d, Y', strtotime($posts[0]->created_at)) }}</span> 
                        </small>
                    </p>
                <p class="card-text">{{ $posts[0]->excerpt }}</p>

                <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-danger">Read more</a>
            </div>
        </div>


        <div class="container">
            <div class="row">
                @foreach ($posts->skip(1) as $post)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="card-effect" >
                            <div class="position-absolute bg-dark rounded px-3 py-2" style="background-color: rgba(0,0,0,0.7)"><a href="/posts?category={{ $post->category->slug }}" class="text-white text-decoration-none">{{ $post->category->name }}</a></div>

                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" >

                            <div class="card-body">
                            <h5 class="card-title"><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h5>
                            <p>
                                <small class="text-muted">
                                By <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> at <span class="text-dark">{{ date('F d, Y', strtotime($post->created_at)) }}</span>
                                </small>
                            </p>
                            <p class="card-text">{{ $post->excerpt }}</p>
                            <a href="/posts/{{ $post->slug }}" class="btn btn-danger">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @else
        <p class="text-center fs-4">No Post Found</p>
    @endif

    <div class="d-flex justify-content-end">
        {{ $posts->links() }}
    </div>
        
</div>
@endsection

