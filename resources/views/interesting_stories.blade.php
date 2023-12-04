<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <title>News</title>
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
                    </ul>
                    @if (Auth::check())
                        <button onclick="window.location.href='/home'" class="btn submit_btn">Go To Dashboard</button>
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
                        <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2" type="submit">Start Your Free Trial</button>
                        <button onclick="window.location.href='/signin'" class="btn submit_btn"
                            type="submit">Login</button>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="news_card_section p-4">
            <div class="container">
                <div class="row">
                    <div class="section-header text-center">
                        <h2 class="fw-bold fs-1">
                            Interesting
                            <span class="b-class-secondary">Stories </span>
                        </h2>
                        <p class="sec-icon"><i class="fa-solid fa-gear"></i></p>
                    </div>
                    @forelse ($stories as $story)
                        <div class="col-md-3 mb-3">
                            <div class="card_Main" onclick="addUrl('{{ $story->url }}','{{ $story->title }}')">
                                <div class="card">
                                    <img src="{{ env('APP_URL')."storage/".$story->image }}" class="card-img-top" alt="card_image1">
                                    <div class="card-body">
                                        <h5 class="card-title" title="{{ $story->title }}">{{ Str::limit($story->title, 55) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-3 mb-3">
                            <h5 class="card-title">No Stories</h5>
                        </div>
                    @endforelse

                </div>
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
                                <h4 class="footer_brand_heading">INTELLI-RATE</h4>
                            </div>
                            <div class="footer-text">
                                <p>BancAnalytics was founded in 1995 by experienced banking executives and business
                                    professionals with a mission of improving data collection and analytical systems to
                                    help financial institutions make more timely and impactful decisions.</p>
                            </div>
                            <div class="footer-social-icon">
                                <span>Contact Us</span>
                                <div class="footer-text">
                                    <p>BancAnalytics Corporation <br>
                                    PO Box 510385 <br>
                                    St. Louis, MO 63151</p>
                                </div>
                                <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                                <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                                <a href="#"><i class="fab fa-google-plus-g google-bg"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Useful Links</h3>
                            </div>
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('/interesting_stories') }}">News</a></li>
                                {{-- <li><a href="#">Our Product</a></li>
                                <li><a href="#">New Survey</a></li>
                                <li><a href="#">About</a></li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Subscribe</h3>
                            </div>
                            <div class="footer-text mb-25">
                                <p>Don’t miss out. Subscribe to our feeds. Enter your email address below.</p>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <iframe
                            id="iframeDiv"
                            src=""
                            width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                            ></iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
    function addUrl(url,title){
        document.getElementById('iframeDiv').src = url;
        document.getElementById('exampleModalLabel').innerHTML = title;
        var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
        myModal.show();
    }
</script>
</html>
