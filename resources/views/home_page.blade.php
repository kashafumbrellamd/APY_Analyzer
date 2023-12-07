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


    <link rel="stylesheet" href="{{ asset('assets/css/style.css?n=1') }}">
    <title>Intelli Rate</title>
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
                            <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2">Start Your Free Trial</button>
                            <button onclick="window.location.href='/signin'" class="btn submit_btn">Login</button>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- <section >
            <div  >
                <div class="big-image">
                    <div class="banner_second container">
                        <div class="col-md-4">
                            <div class="card_container">
                                <h5>PERSONAL BANKING</h5>
                                <h4>Take advantage of up to 4.50% Annual Percentage Yield</h4>
                                <p>Open an Elite Money Market account. Dependent on total balance and location.</p>
                                <button class="btn card_register_btn">Register Your Bank</button>
                            </div>

                        </div>
                    </div>
                  </div>

            </div>
        </section> -->
        <section>
            <div>
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        {{-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button> --}}
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="position-relative">

                                <img src="{{ asset('assets/images/banner_land_apy.png') }}"
                                    class="d-block w-100 slider_image__" alt="...">
                                <div class="col-md-3 card__survey_main" style="width: 28%;">
                                    <div class="card_container">
                                        <h3>Intelli-Rate by <strong>BancAnalytics</strong></h3>
                                        {{-- <h4>Request For New Survey</h4> --}}
                                        <!-- <p>Open an Elite Money Market account. Dependent on total balance and location.</p> -->
                                        {{-- <button class="btn card_register_btn" onclick="window.location.href='/Survey/form'">Request For New Survey</button> --}}
                                        <!-- <button class="btn card_register_btn" data-bs-toggle="modal"
                                            data-bs-target="#survey_modal">Request For New Survey</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="carousel-item">
                            <img src="{{ asset('assets/images/banner_land_apy2.png') }}"
                                class="d-block w-100 slider_image__" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('assets/images/banner_land_apy3.png') }}"
                                class="d-block w-100 slider_image__" alt="...">
                        </div> --}}
                    </div>
                    {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button> --}}
                </div>
            </div>
        </section>
        <section id="advertisers" class="advertisers-service-sec pt-5 pb-3">
            <div class="container">
                <div class="row">
                    <div class="section-header text-center">
                        <h2 class="fw-bold fs-2">
                            Who We Are
                        </h2>
                    </div>
                </div>
                <div>
                    <p class="text-center fs-6">BancAnalytics was founded in 1995 by experienced banking executives and
                        business
                        professionals with a mission of improving data collection and analytical systems to help
                        financial
                        institutions make more timely and impactful decisions.</p>
                </div>
            </div>
        </section>
        <section id="advertisers" class="advertisers-service-sec pt-3 pb-3">
            <div class="container">
                <div class="row">
                    <div class="section-header text-center">
                        <h2 class="fw-bold fs-2">
                            What We Do
                        </h2>
                    </div>
                </div>
                <div>
                    <p class="text-center fs-6">BancAnalytics offers rate intelligence reports that provide users with
                        timely,
                        accurate data on competitor rates and how their financial institution’s rates compare to the
                        market.
                        We offer broad market analyses by metropolitan area and encourage our clients to take time to
                        consider who they are truly
                        competing with in that area and beyond. If clients decide they want a more narrow focus, we can
                        tailor affordable,
                        customized solutions to meet their needs. Learn more about Intelli-Rate formerly known as Money
                        Monitor in the details
                        below.
                    </p>
                </div>
            </div>
        </section>
        <section id="advertisers" class="advertisers-service-sec pt-3 pb-3">
            <div class="container">
                <div class="row">
                    <div class="section-header text-center">
                        <h2 class="fw-bold fs-2">
                            What Sets Us Apart
                        </h2>
                    </div>
                </div>
                <div>
                    <p class="text-center fs-6">There are other companies that provide data collection and some that
                        provide
                        templates
                        for completing data analysis tasks. What sets BancAnalytics apart is the experience we bring as
                        financial
                        institution executives and business leaders. Our approach to data collection is to make sure the
                        data is
                        accurate, comprehensive, timely and relevant to our clients’ needs. Our approach to data
                        analysis is unique
                        in that we employ proprietary methods along with presentation techniques that allow users to
                        quickly drill
                        down and identify opportunities as well as potential areas of concern. This process often leads
                        users to
                        ascertain ways to improve operating performance.</p>
                </div>
            </div>
        </section>


        <!-- ----Our-Products-Start----- -->
        <section id="advertisers" class="advertisers-service-sec pt-3 pb-5">
            <div class="container" id="our_product">
                <div>
                    <div class="section-header text-center">
                        <h2 class="fw-bold fs-2">
                            Product Details
                        </h2>
                    </div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item col-md-12 p-1" role="presentation">
                            <button class="nav-link active nav__item_btn" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">Intelli-Rate Report by
                                BancAnalytics</button>
                        </li>

                    </ul>
                    <div class="tab-content row" id="pills-tabContent">
                        <div class="tab-pane fade show active col-md-6" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div>
                                <div class="our_product_sub_main">
                                    <h5>Deposit Rate Survey :</h5>
                                    <div class="our_product_sub_ul_main">
                                        <ul class="first_ul">
                                            <li>
                                                Weekly report contains personal deposit yields for various products
                                                including:
                                                <ul class="second_ul">
                                                    <li>Personal Savings/Share Accounts</li>
                                                    <li>Money Market Deposit Accounts</li>
                                                    <li>Certificates of Deposit</li>
                                                    <li>Special Promotions </li>
                                                </ul>
                                            </li>
                                            <li>This coverage enables financial institutions to gain insights into the
                                                competitive landscape
                                                across multiple deposit categories and determine how they and their
                                                competitors rank in each of
                                                the categories.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="our_product_sub_main">
                                    <h5>Metropolitan Area Focus :</h5>
                                    <div class="our_product_sub_ul_main">
                                        <ul class="first_ul">
                                            <li>
                                                This comprehensive report focuses on significant banks and credit unions
                                                within a specific
                                                metropolitan area. This localized approach allows financial institutions
                                                to understand the
                                                competition and market conditions in their specific region.
                                            </li>
                                            <li>
                                                Custom reports are available anywhere in the nation.
                                            </li>
                                            <li>
                                                Available in selected Metropolitan Areas.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="our_product_sub_main">
                                    <h5>Full Color Graphs :</h5>
                                    <div class="our_product_sub_ul_main">
                                        <ul class="first_ul">
                                            <li>
                                                The inclusion of full-color graphs enhances the visual representation of
                                                data, making it easier
                                                for clients to identify trends and patterns at a glance. The client’s
                                                data for all products is
                                                graphed for current week, 6-months prior and 12-months prior.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="our_product_sub_main">
                                    <h5>Peer Group Averages :</h5>
                                    <div class="our_product_sub_ul_main">
                                        <ul class="first_ul">
                                            <li>
                                                Enables financial institutions to compare their own rates with those of
                                                similar institutions
                                                within the same market. This benchmarking helps institutions gauge their
                                                competitiveness and
                                                performance relative to their peers.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <img class="set_width mt-3" src="{{ asset('img/graph1.png') }}" alt="">
                        <img class="set_width mt-3" src="{{ asset('img/graph2.png') }}" alt="">
                        <img class="set_width mt-3" src="{{ asset('img/list.png') }}" alt="">
                    </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- ----Our-Products-End----- -->

        <!-- ----Packages-Details-Start----- -->
        <section class="show_box">
            <div class="container-fluid"
                style="background: #f5f5f5;">

                <div class="container p-5">
                    <div class="row">
                        <div class="section-header text-center  pb-5">
                            <button onclick='window.location.href="/signup"'
                                style="    border: none;
                                cursor: pointer;
                                color: #3758d2;
                                background-color: whitesmoke;">
                                <h2 class="fw-bold fs-2 ">
                                    Get Started Now
                                </h2>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($packages as $package)
                            <div class="col-lg-6 col-md-12 mb-6">
                                <div class="card h-100 shadow-lg">
                                    <div class="card-body">
                                        <div class="text-center p-3">
                                            <h5 class="card-title h2">{{ $package->name }}</h5>
                                            <br><br>
                                            <span class="h1">${{ number_format($package->price) }}</span>/Annually
                                            <br><br>
                                        </div>
                                        <p class="card-text">{{ $package->description }}</p>
                                    </div>
                                    <div class="card-body text-center">
                                        @if (Auth::check())
                                            <button class="btn btn-outline-primary btn-lg"
                                                style="border-radius:20px" onclick='window.location.href="/home"'>Select</button>
                                        @else
                                            <button class="btn btn-outline-primary btn-lg"
                                                style="border-radius:20px" onclick='window.location.href="/signup"'>Select</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        </section>
        <!-- ----Packages-Details-End----- -->


        <!-- ADVERTISERS SERVICE CARD -->
        <!-- <section id="advertisers" class="advertisers-service-sec pt-3 pb-3">
      <div class="container">
        <div class="row">
          <div class="section-header text-center">
            <h2 class="fw-bold fs-2">
              Why
              <span class="b-class-secondary">Choose </span>
            </h2>
            <p class="sec-icon"><i class="fa-solid fa-gear"></i></p>
          </div>
        </div>
        <div class="row mt-5 mt-md-4 row-cols-1 row-cols-sm-1 row-cols-md-3 justify-content-center">
          <div class="col">
            <div class="service-card">
              <div class="icon-wrapper">
                <i class="fa-solid fa-chart-line"></i>
              </div>
              <h3>Advanced Analytics</h3>
              <p>
                Our software goes beyond raw data, providing powerful analytics tools to help you uncover valuable
                insights and identify trends in the CD and money market landscape.
              </p>
            </div>
          </div>
          <div class="col">
            <div class="service-card">
              <div class="icon-wrapper">
                <i class="fa-solid fa-arrows-down-to-people"></i>
              </div>
              <h3>Competitive Advantage</h3>
              <p>
                Stay ahead of the competition by setting rates that align with market conditions and customer demands.
                Stand out from other banks by offering attractive CD and money market options.
              </p>
            </div>
          </div>
          <div class="col">
            <div class="service-card">
              <div class="icon-wrapper">
                <i class="fa-solid fa-globe"></i>
              </div>
              <h3>Customizable Dashboard</h3>
              <p>
                Tailor the dashboard to your bank's specific needs, displaying the rates and metrics that matter most to
                you. Stay organized and make data-driven decisions with ease.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section> -->
        <!-- ADVERTISERS SERVICE CARD ENDED -->

        <!-- <section id="advertisers" class="advertisers-service-sec pt-5 pb-5">
    <div class="container">
      <div class="row">
        <div class="section-header text-center">
        </div>
      </div>
      <div class="text-center cont_card">
        <p>Unlock the Potential of Your Bank with APY ANALYZER Don't let valuable opportunities slip away. With APY ANALYZER, you have the tools and information you need to optimize your CD and money market rates. Empower your bank, attract more customers, and maximize your profits.</p>
        <p>Ready to take your bank's performance to the next level? Contact us today to schedule a demo and see how APY ANALYZER can transform your financial decision-making process.</p>
        <p>Remember, data-driven decisions lead to success in the banking industry. Choose APY ANALYZER and unlock the power of real-time CD and money market insights.</p>
      </div>
    </div>
  </section> -->
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

    <!-- ----Survey--Modal-Start----- -->
    <div class="modal fade" id="survey_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal_header_cus">
                    <h5 class="modal-title" id="exampleModalLabel">Request For New Survey</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!-- ----Survey--Modal-End----- -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
