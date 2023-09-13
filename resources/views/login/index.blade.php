@extends('login.layouts.main')

@section('content')
<section class="login-content">
    <div class="container">
        <div class="row align-items-center justify-content-center height-self-center">
            <div class="col-lg-8">
                <div class="card auth-card">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                            <div class="col-lg-6 bg-primary content-left">
                                <div class="p-3">
                                    <h2 class="mb-2 text-white">Sign In</h2>
                                    <p>Login to stay connected.</p>
                                    <form action="{{ route('authenticate') }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" name="username" required type="text" placeholder=" ">
                                                    <label>username</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" name="password" required type="password" placeholder=" ">
                                                    <label>Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-white">Sign In</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 content-right">
                                <img src="{{ asset('/assets/images/login/01.png') }}" class="img-fluid image-right" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
