<!-- Search -->
<div class="card my-4">
    <h5 class="card-header">Search</h5>

    <div class="card-body mx-auto">
        <form class="form-inline" action="{{ route('main') }}" method="get">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Example widget -->
<div class="card my-4">
    <h5 class="card-header">Side Widget</h5>
    <div class="card-body">
        You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
    </div>
</div>

<!-- Popular now -->
@if ($posts->isNotEmpty())
    <div class="card my-4">
        <h5 class="card-header text-uppercase">Popular now</h5>
        <div class="card-body">
            <div class="row">
                @foreach ($posts as $key => $post)
                    <div class="col-12 card border-0 mb-3">
                        <a href="{{ route('post.show', $post->alias) }}">
                            <img class="card-img" src="{{ $post->img ? asset($post->img) : asset('img/default.png') }}" alt="Card image cap">
                        </a>
                        <div class="card-body mt-1 p-0 text-center">
                            @if ($post->categories->isNotEmpty())
                                <div class="mt-1 font-weight-bold">
                                    @foreach ($post->categories as $category)
                                    <a href="category/{{ $category->alias }}" {{ $category->color ? 'style=color:' . $category->color : 'class=text-dark' }}>{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                            <h5 class="card-title mt-1"><a href="post/{{ $post->alias }}" class="text-dark">{{ $post->title }}</a></h5>
                        </div>

                        @if ($posts->keys()->last() != $key) <hr> @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif