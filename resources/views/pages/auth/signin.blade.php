@extends('layouts.auth')

@section('content')
<div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="" class="">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>POS</h3>
                </a>
                <h3>RAFA STORE</h3>
            </div>
            <form action="{{ route('signin') }}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid else is-valid @enderror" id="floatingInput" name="email" placeholder="name@example.com" autocomplete="off"/>
                    <label for="floatingInput">Email address</label>
                </div>
                @error('email')
                    <div class="alert alert-danger mb-2">{{ $message }}</div>
                @enderror
                <div class="form-floating mb-4">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" placeholder="Password"/>
                    <label for="floatingPassword">Password</label>
                </div>
                @error('password')
                    <div class="alert alert-danger mb-2">{{ $message }}</div>
                @enderror
                <!-- <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <a href="">Forgot Password</a>
                </div> -->
                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Login</button>
                <p class="text-center mb-0">Don't have an Account? <a href="{{url('/signin
                    ')}}">Sign Up</a></p>

            </form>
        </div>
    </div>
</div>
@endsection