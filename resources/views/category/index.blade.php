@extends('layouts.main')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4 text-center">{{ $category->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <h1 class="my-4">Articles</h1>

            <!-- Posts -->
            @if ($posts->isEmpty())
                <span>Not found</span>
            @else
                @foreach($posts as $post)
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ $post->img ? asset($post->img) : asset('img/default.png') }}" alt="Card image cap">
                        <div class="card-footer text-muted">
                            <span>
                                <i class="far fa-clock"></i>
                                {{ $post->created_at->format('H:i | d M Y') }}
                            </span>
                            <span>by {{ $post->user->name }}</span>
                            <span class="float-right">
                                <i class="far fa-eye"></i>
                                {{ $post->views }}
                            </span>
                        </div>
                        <div class="card-body">
                            @if ($post->categories->isNotEmpty())
                                <div class="mb-2">
                                    @foreach ($post->categories as $key => $category)
                                        <span class="mr-1">
                                            <strong {{ $category->color ? 'style=color:' . $category->color : 'class=text-dark' }}>{{ $category->name }}</strong>
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            <h2 class="card-title">{{ $post->title }}</h2>
                            <a href="{{ route('post.show', $post->alias) }}" class="stretched-link"></a>
                            <!-- <a href="{{ route('post.show', $post->alias) }}" class="btn btn-primary stretched-link">Read More</a> -->
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="col-md-4">
            @include('includes.sidebar')
        </aside>
    </div>
@endsection