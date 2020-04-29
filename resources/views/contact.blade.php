@extends('layouts.main')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Contact Us</h4>

                    <form>
                        <div class="form-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" required autocomplete="email" autofocus>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="question" cols="30" rows="10" placeholder="Your message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-lg btn-block btn-primary mt-4">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection