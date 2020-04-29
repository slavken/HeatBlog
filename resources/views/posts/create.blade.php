@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">Create a post</h1>

            <!-- Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="editor">Body</label>
                    <textarea id="editor" name="body"></textarea>
                </div>
                <div class="form-group">
                    @foreach ($categories as $category)
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="category-{{ $category->id }}" name="category[]" value="{{ $category->id }}">
                                <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <input type="file" name="img">
                </div>
                <button type="submit" class="btn btn-lg btn-block btn-success">Create</button>
            </form>
        </div>

        <!-- Sidebar -->
        <aside class="col-md-4">
            @include('includes.sidebar')
        </aside>
    </div>
@endsection