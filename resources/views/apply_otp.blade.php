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
    <section class="back_sign__ login__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Login</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('verify_login') }}" class="login-form" method="post">
                                @csrf
                                <div>
                                    
                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="mb-3 text-center">
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                    <label for="email" class="form-label">Apply Otp</label>
                                                    <input class="form-control" name="otp" placeholder="Enter otp..." type="otp" id="otp"
                                                        class="@error('otp') is-invalid @enderror" value="{{ old('otp') }}" required
                                                        autocomplete="otp" autofocus>
                                                    @error('otp')
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
                                                    <button type="submit" class="btn submit_btn">Login</button>
                                                </div>
                                            </div>
                                        </div>

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