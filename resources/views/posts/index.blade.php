@extends('layouts.main')

@section('content')
    <!-- Slider -->
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/slider.png') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/slider.png') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/slider.png') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <h1 class="my-4">Articles</h1>

            @if ($_GET['search'] ?? null)
                @if ($posts->isNotEmpty())
                    <h4 class="mb-4">Results: {{ count($posts) }}</h4>
                @else
                    <h4>No Results</h4>
                @endif
            @endif

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
        <aside class="col-lg-4">
            @include('includes.sidebar')
        </aside>
    </div>

    <!-- Popular this week -->
    <div class="mt-5">
        @if ($postsWeek->isNotEmpty())
            <h3 class="text-uppercase mb-3">Popular this week</h3>
            <div class="row">
                @foreach ($postsWeek as $post)
                    <div class="col-6 col-md-3">
                        <div class="card border-0">
                            <a href="post/{{ $post->alias }}">
                                <img class="card-img" src="{{ $post->img ? asset($post->img) : asset('img/default.png') }}" alt="Card image cap">
                            </a>
                            <div class="card-body mt-1 p-0 text-center">
                                @if ($post->categories->isNotEmpty())
                                    <div>
                                        @foreach ($post->categories as $category)
                                            <a href="category/{{ $category->alias }}" class="font-weight-bold {{ $category->color ?? 'text-dark' }}" {{ $category->color ? 'style=color:' . $category->color : null }}>{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                @endif

                                <h5 class="card-title mt-1"><a href="post/{{ $post->alias }}" class="text-dark">{{ $post->title }}</a></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Trend category -->
        @if ($trendPosts->isNotEmpty())
            <h3 class="text-uppercase my-3">LifeHacks</h3>
            <div class="row">
                @foreach ($trendPosts as $post)
                    <div class="col-6 col-md-3">
                        <div class="card border-0">
                            <a href="post/{{ $post->alias }}">
                                <img class="card-img" src="{{ $post->img ? asset($post->img) : asset('img/default.png') }}" alt="Card image cap">
                            </a>
                            <div class="card-body mt-1 p-0 text-center">
                                @if ($post->categories->isNotEmpty())
                                    <div>
                                        @foreach ($post->categories as $category)
                                            <a href="category/{{ $category->alias }}" class="font-weight-bold {{ $category->color ?? 'text-dark' }}" {{ $category->color ? 'style=color:' . $category->color : null }}>{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                @endif

                                <h5 class="card-title mt-1"><a href="post/{{ $post->alias }}" class="text-dark">{{ $post->title }}</a></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Very interesting -->
        @if ($interestingPosts->isNotEmpty())
            <h3 class="text-uppercase my-3">Very interesting</h3>
            <div class="row">
                @foreach ($interestingPosts as $post)
                    <div class="col-6 col-md-3">
                        <div class="card border-0">
                            <a href="post/{{ $post->alias }}">
                                <img class="card-img" src="{{ $post->img ? asset($post->img) : asset('img/default.png') }}" alt="Card image cap">
                            </a>
                            <div class="card-body mt-1 p-0 text-center">
                                @if ($post->categories->isNotEmpty())
                                    <div>
                                        @foreach ($post->categories as $category)
                                            <a href="category/{{ $category->alias }}" class="font-weight-bold {{ $category->color ?? 'text-dark' }}" {{ $category->color ? 'style=color:' . $category->color : null }}>{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                @endif

                                <h5 class="card-title mt-1"><a href="post/{{ $post->alias }}" class="text-dark">{{ $post->title }}</a></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection