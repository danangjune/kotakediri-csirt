@extends('layouts.main')

@section('container')
    <!-- Blog Section -->
    <section id="blog">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-8 mx-auto text-center">
                    <h1>Latest Post</h1>
                </div>
            </div>
        
        @if ($posts->count())
            <div class="container">
                <div class="row">
                    @foreach ($posts->take(6) as $post)
                        <div class="col-lg-4 col-sm-6 my-4">
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
        
        </div>
    </section>
    <!-- End Blog Section -->
@endsection