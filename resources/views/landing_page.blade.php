<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <title>Sign Up</title>
  </head>
  <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand header_brand_heading" href="{{ url('/') }}">INTELLI-RATE</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('interesting_stories') }}">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('view_feedback') }}">Feedback</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        @if (Auth::check())
                        <button onclick="window.location.href='/home'" class="btn submit_btn">Go To
                            Dashboard</button>
                        <button class="btn btn-danger mx-4">
                            <a href="{{ route('logout') }}" style="text-decoration: none; !important; color:white;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        @else
                        <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2">Sign Up Now</button>
                        <button onclick="window.location.href='/signin'" class="btn submit_btn">Login</button>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section class="back_sign__ login__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Login</h1>
                    @if (session('approval'))
                        <div class="col-sm-12">
                            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                {{ session('approval') }}
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="col-sm-12">
                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('bank_login') }}" class="login-form" id="UserLoginForm" method="post">
                                @csrf
                                <div>

                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="mb-3 text-center">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control" name="email" placeholder="Email" type="email" id="email"
                                                        class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required
                                                        autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div>
                                    <div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="mb-3 text-center">
                                                    <button type="submit" class="btn submit_btn">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="text-center mb-3">
                                            <a href="{{ route('signup') }}"> Create Account </a>
                                        </div> --}}
                                        <!-- <div class="text-center">
                                            <a href="{{ route('login') }}"> Go To Admin Login </a>
                                        </div> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
