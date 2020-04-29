@extends('layouts.main')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <h1 class="mt-4">{{ $post->title }}</h1>

            <p class="lead">
                by
                <a href="/profile/{{ $post->user->name }}">{{ $post->user->name }}</a>
            </p>

            @canany(['update', 'update-posts', 'delete'], $post)
                <div class="my-3 d-flex">
                    @canany(['update', 'update-posts'], $post)
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                    @endcanany
                    @can('delete', $post)
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endcan
                </div>
            @endcanany

            <div class="text-muted">
                <span>
                    <i class="far fa-clock"></i>
                    Posted at {{ $post->created_at->format('H:i | F d, Y') }}
                </span>
                <span class="float-right">
                    <i class="far fa-eye"></i>
                    {{ $post->views }} view(s)
                </span>
            </div>

            <hr>

            <img class="rounded w-100" src="{{ $post->img ? asset($post->img) : asset('img/default.png') }}" alt="">

            <hr>

            <div class="content">
                {!! $post->body !!}
            </div>

            <hr>
            
            @if ($categories->isNotEmpty())
                <div class="card">
                    <div class="card-body bg-light">
                        Category:
                        @foreach ($categories as $key => $category)
                            <a href="/category/{{ $category->alias }}" class="text-dark font-weight-bold">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="card my-4">
                <h5 class="card-header">Leave a comment:</h5>
                <div class="card-body">
                    <form action="{{ route('comment.store', $post->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" rows="3" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

            @foreach ($comments as $key => $child)
                @if ($key) @break @endif

                @foreach ($child->sortByDesc('created_at') as $comment)
                    <div class="media mb-2">
                        <i class="fas fa-user text-secondary rounded-circle p-3 mr-2" style="background: darkgray;"></i>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <h5 class="m-0">{{ $comment->user ? $comment->user->name : 'Guest' }}</h5>
                                <small class="ml-2 text-muted">
                                    <i class="far fa-clock"></i>
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            {{ $comment->body }}
                            @if (isset($comments[$comment->id]))
                                @include('includes.comment', ['comments' => $comments[$comment->id]])
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('comment.store', $post->id) }}" method="POST" class="mb-4 ml-5">
                        @csrf
                        <div class="input-group">
                            <input class="form-control form-control-sm" type="text" name="body">
                            <input type="hidden" name="parent" value="{{ $comment->id }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-light border" type="submit">Reply</button>
                            </div>
                        </div>
                    </form>
                @endforeach
            @endforeach
        </div>

        <!-- Sidebar -->
        <aside class="col-md-4">
            @include('includes.sidebar')
        </aside>
    </div>
@endsection