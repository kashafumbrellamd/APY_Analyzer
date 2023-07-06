<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <title>Sign Up</title>
  </head>
  <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">APY_ANALYZER</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Link
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link</a>
                  </li> -->
                </ul>
                  <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2" type="submit">Sign Up</button>
                  <button onclick="window.location.href='/signin'" class="btn submit_btn" type="submit">Login</button>
              </div>
            </div>
          </nav>
    </header>
    <main >
        <section >
            <div  >
                <div class="big-image">
                    <div class="banner_second container">
                        <div class="col-md-4">
                            <div class="card_container">
                                <h5>PERSONAL BANKING</h5>
                                <h4>Take advantage of up to 4.50% Annual Percentage Yield</h4>
                                <p>Open an Elite Money Market account. Dependent on total balance and location.</p>
                                <button onclick="window.location.href='/signup'" class="btn card_register_btn">Register Your Bank</button>
                            </div>

                        </div>
                    </div>
                  </div>
                  
            </div>
        </section>

        <section id="advertisers" class="advertisers-service-sec pt-5 pb-3">
            <div class="container">
              <div class="row">
                <div class="section-header text-center">
                  <h2 class="fw-bold fs-1">
                    About Us
                  </h2>
                </div>
              </div>
              <div>
                <p class="text-center">Welcome to APY ANALYZER – Your Trusted Source for Real-time CD and Money Market Data
                    At APY ANALYZER, we believe in the power of data to drive smart financial decisions. Our innovative software provides banks and financial institutions with real-time CD (Certificate of Deposit) and money market rates from various trusted sources. With our comprehensive data and advanced analytics, you can stay ahead of the market trends and make informed decisions to set competitive rates for your bank.</p>
              </div>
            </div>
          </section>
<!-- ADVERTISERS SERVICE CARD -->
<section id="advertisers" class="advertisers-service-sec pt-3 pb-3">
    <div class="container">
      <div class="row">
        <div class="section-header text-center">
          <h2 class="fw-bold fs-1">
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
                Our software goes beyond raw data, providing powerful analytics tools to help you uncover valuable insights and identify trends in the CD and money market landscape.
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
                Stay ahead of the competition by setting rates that align with market conditions and customer demands. Stand out from other banks by offering attractive CD and money market options.
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
                Tailor the dashboard to your bank's specific needs, displaying the rates and metrics that matter most to you. Stay organized and make data-driven decisions with ease.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
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
                                <h4>APY_ANALYZER</h4>
                            </div>
                            <div class="footer-text">
                                <p>Lorem ipsum dolor sit amet, consec tetur adipisicing elit, sed do eiusmod tempor incididuntut consec tetur adipisicing
                                elit,Lorem ipsum dolor sit amet.</p>
                            </div>
                            <div class="footer-social-icon">
                                <span>Follow us</span>
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
                                <li><a href="#">Home</a></li>
                                <li><a href="#">about</a></li>
                                <li><a href="#">services</a></li>
                                <li><a href="#">portfolio</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Our Services</a></li>
                                <li><a href="#">Expert Team</a></li>
                                <li><a href="#">Contact us</a></li>
                                <li><a href="#">Latest News</a></li>
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
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>Copyright &copy; 2023, All Right Reserved <a href="#">APY_ANALYZER</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Terms</a></li>
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Policy</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
      
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
