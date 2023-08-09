<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <title>Sign Up</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">INTELLI-RATE</a>
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
                    </ul>
                    <div class="d-flex">
                        @if (Auth::check())
                        <button onclick="window.location.href='/home'" class="btn submit_btn">Go To
                            Dashboard</button>
                        @else
                        <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2">Sign
                            Up</button>
                        <button onclick="window.location.href='/signin'" class="btn submit_btn">Login</button>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
  <main>
    <section>
      <div class="container my-3">
        @if(session()->has('success'))
        <div class="alert alert-success mt-2 text-center">
            {{ session()->get('success') }}
        </div>
        @endif
        <h2 class="text-center request_heading">Request For New Survey</h2>
          <form action="{{ route('bank_request_submit') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Enter Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                            placeholder="Enter Name of the Bank." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
                            placeholder="name@example.com" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1"
                            name="phone_number" placeholder="12345678" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Enter Zip Code</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1"
                            name="zip_code" placeholder="Enter Zip Code." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Select State</label>
                        <select class="form-select" aria-label="Default select example" name="state_id"
                            required>
                            <option selected>Open this select State</option>
                            @foreach ($states as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Select City</label>
                        <select class="form-select" aria-label="Default select example" name="city_id"
                            required>
                            <option selected>Open this select City</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Enter
                            Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                            rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <button type="submit" class="btn survey_submit_btn">Submit</button>
                    </div>
                </div>
            </div>
          </form>
      </div>
    </section>
  </main>
  <footer class="footer-section">
    <div class="container">

        <div class="footer-content pt-5 pb-5">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <!-- <a href="index.html"><img src="https://i.ibb.co/QDy827D/ak-logo.png" class="img-fluid" alt="logo"></a> -->
                            <h4>INTELLI-RATE</h4>
                        </div>
                        <div class="footer-text">
                            <p>BancAnalytics was founded in 1995 by experienced banking executives and business
                                professionals with a mission of improving data collection and analytical systems to
                                help financial institutions make more timely and impactful decisions.</p>
                        </div>
                        <div class="footer-social-icon">
                            <span>Follow us</span>
                            <!-- <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                            <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                            <a href="#"><i class="fab fa-google-plus-g google-bg"></i></a> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Useful Links</h3>
                        </div>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Our Product</a></li>
                            <li><a href="#">New Survey</a></li>
                            <li><a href="#">About</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Subscribe</h3>
                        </div>
                        <div class="footer-text mb-25">
                            <p>Don’t miss to subscribe to our new feeds, kindly fill the form below.</p>
                        </div>
                        <div class="subscribe-form">
                            <form action="#">
                                <input type="text" placeholder="Email Address">
                                <!-- <button><i class="fab fa-telegram-plane"></i></button> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 text-center text-lg-center">
                    <div class="copyright-text">
                        <p>Copyright &copy; 2023, All Right Reserved <a
                                href="https://codepen.io/anupkumar92/">INTELLI-RATE</a>
                        </p>
                    </div>
                </div>
                <!-- <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                    <div class="footer-menu">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Policy</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</footer>

  <!-- ----Survey--Modal-Start----- -->
  <div class="modal fade" id="survey_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal_header_cus">
          <h5 class="modal-title" id="exampleModalLabel">Request For New Survey</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Enter Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Enter Zip Code</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Phone</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="12345678">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Select State</label>
                <select class="form-select" aria-label="Default select example">
                  <option selected>Open this select menu</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label">Select City</label>
                <select class="form-select" aria-label="Default select example">
                  <option selected>Open this select menu</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-2">
                <label for="exampleFormControlTextarea1" class="form-label">Enter Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="text-center">
          <button type="button" class="btn survey_submit_btn">Submit</button>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- ----Survey--Modal-End----- -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>