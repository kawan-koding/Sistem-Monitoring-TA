<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> {{ $title ?? 'unknown'}} | Simonika Politeknik Negeri Banyuwangi</title>
    <!-- favicons Icons -->
    <link rel="icon" href="{{ asset('storage/images/settings/' . getSetting('app_favicon')) }}" />
    <meta name="description" content="Crsine HTML Template For Car Services" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/animate/animate.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/animate/custom-animate.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/fontawesome/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/jarallax/jarallax.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/nouislider/nouislider.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/nouislider/nouislider.pips.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/odometer/odometer.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/swiper/swiper.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/icomoon-icons/style.css')}}">
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/tiny-slider/tiny-slider.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/reey-font/stylesheet.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/owl-carousel/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/owl-carousel/owl.theme.default.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/twentytwenty/twentytwenty.css')}}" />

    <!-- template styles -->
    <link rel="stylesheet" href="{{ asset('landing-assets/css/zilom.css')}}" />
    <link rel="stylesheet" href="{{ asset('landing-assets/css/zilom-responsive.css')}}" />
</head>

<body>

    <div class="preloader">
        <img class="preloader__image" width="60" src="{{ asset('landing-assets/images/loader.png')}}" alt="" />
    </div>

    <!-- /.preloader -->
    <div class="page-wrapper">

        <header class="main-header main-header--one  clearfix">
            <div class="main-header--one__top clearfix">
                <div class="container">
                    <div class="main-header--one__top-inner clearfix">
                        <div class="main-header--one__top-left">
                            <div class="main-header--one__top-logo">
                                <a href="index.html"><img src="assets/images/resources/logo-1.png" alt="" /></a>
                            </div>
                        </div>

                        <div class="main-header--one__top-right clearfix">
                            <ul class="main-header--one__top-social-link list-unstyled clearfix">
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>

                            <div class="main-header--one__top-contact-info clearfix">
                                <ul class="main-header--one__top-contact-info-list list-unstyled">
                                    <li class="main-header--one__top-contact-info-list-item">
                                        <div class="icon">
                                            <span class="icon-phone-call-1"></span>
                                        </div>
                                        <div class="text">
                                            <h6>Call Agent</h6>
                                            <p><a href="tel:123456789">92 888 666 0000</a></p>
                                        </div>
                                    </li>
                                    <li class="main-header--one__top-contact-info-list-item">
                                        <div class="icon">
                                            <span class="icon-message"></span>
                                        </div>
                                        <div class="text">
                                            <h6>Call Agent</h6>
                                            <p><a href="mailto:info@templatepath.com">needhelp@company.com</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="main-header-one__bottom clearfix">
                <div class="container">
                    <div class="main-header-one__bottom-inner clearfix">
                        <nav class="main-menu main-menu--1">
                            <div class="main-menu__inner">
                                <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>

                                <div class="left">
                                    <ul class="main-menu__list">
                                        <li class="dropdown current">
                                            <a href="index.html">Home</a>
                                            <ul>
                                                <li><a href="index.html">Home One</a></li>
                                                <li><a href="index-2.html">Home Two</a></li>
                                                <li class="dropdown">
                                                    <a href="#">Header Styles</a>
                                                    <ul>
                                                        <li><a href="index.html">Header One</a></li>
                                                        <li><a href="index-2.html">Header Two</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="about.html">About</a></li>
                                        <li class="dropdown">
                                            <a href="#">Courses</a>
                                            <ul>
                                                <li><a href="courses.html">Courses</a></li>
                                                <li><a href="course-details.html">Course Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#"> Teachers</a>
                                            <ul>
                                                <li><a href="teachers-1.html"> Teachers</a></li>
                                                <li><a href="teachers-2.html">Become Teacher</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#">News</a>
                                            <ul>
                                                <li><a href="news.html">News</a></li>
                                                <li><a href="news-details.html">News Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact.html">Contact</a></li>
                                    </ul>
                                </div>

                                <div class="right">
                                    <div class="main-menu__right">
                                        <div class="main-menu__right-login-register">
                                            <ul class="list-unstyled">
                                                <li><a href="{{ route('login')}}">Login</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </nav>

                    </div>
                </div>
            </div>

        </header>


        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content">

            </div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->


        <section class="main-slider main-slider-one">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true, "effect": "fade", "pagination": {
        "el": "#main-slider-pagination",
        "type": "bullets",
        "clickable": true
        },
        "navigation": {
        "nextEl": "#main-slider__swiper-button-next",
        "prevEl": "#main-slider__swiper-button-prev"
        },
        "autoplay": {
        "delay": 7000
        }}'>

                <div class="swiper-wrapper">
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="shape1"><img src="assets/images/shapes/slider-v1-shape1.png" alt="" /></div>
                        <div class="shape2"><img src="assets/images/shapes/slider-v1-shape2.png" alt="" /></div>
                        <div class="image-layer"
                            style="background-image: url(assets/images/backgrounds/main-slider-v1-1.jpg);"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="main-slider__content">
                                <div class="main-slider__content-icon-one">
                                    <span class="icon-lamp"></span>
                                </div>
                                <div class="main-slider__content-icon-two">
                                    <span class="icon-human-resources"></span>
                                </div>
                                <div class="main-slider-one__round-box">
                                    <div class="main-slider-one__round-box-inner">
                                        <p>Professional <br>teachers</p>
                                        <div class="icon">
                                            <i class="fas fa-sort-up"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-slider__content-tagline">
                                    <h2>Ready to learn?</h2>
                                </div>
                                <h2 class="main-slider__content-title">Learn new <br>things daily</h2>
                                <p class="main-slider__content-text">Get free access to 6800+ different courses from
                                    <br> 680 professional teachers</p>
                                <div class="main-slider__content-btn">
                                    <a href="#" class="thm-btn">Discover more</a>
                                </div>
                                <div class="main-slider-one__img">
                                    <img src="assets/images/backgrounds/main-slider-v1-img.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->

                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="shape1"><img src="assets/images/shapes/slider-v1-shape1.png" alt="" /></div>
                        <div class="shape2"><img src="assets/images/shapes/slider-v1-shape2.png" alt="" /></div>
                        <div class="image-layer"
                            style="background-image: url(assets/images/backgrounds/main-slider-v1-1.jpg);"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="main-slider__content">
                                <div class="main-slider__content-icon-one">
                                    <span class="icon-lamp"></span>
                                </div>
                                <div class="main-slider__content-icon-two">
                                    <span class="icon-human-resources"></span>
                                </div>
                                <div class="main-slider-one__round-box">
                                    <div class="main-slider-one__round-box-inner">
                                        <p>Professional <br>teachers</p>
                                        <div class="icon">
                                            <i class="fas fa-sort-up"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-slider__content-tagline">
                                    <h2>Ready to learn?</h2>
                                </div>
                                <h2 class="main-slider__content-title">Learn new <br>things daily</h2>
                                <p class="main-slider__content-text">Get free access to 6800+ different courses from
                                    <br> 680 professional teachers</p>
                                <div class="main-slider__content-btn">
                                    <a href="#" class="thm-btn">Discover more</a>
                                </div>
                                <div class="main-slider-one__img">
                                    <img src="assets/images/backgrounds/main-slider-v1-img.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->

                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="shape1"><img src="assets/images/shapes/slider-v1-shape1.png" alt="" /></div>
                        <div class="shape2"><img src="assets/images/shapes/slider-v1-shape2.png" alt="" /></div>
                        <div class="image-layer"
                            style="background-image: url(assets/images/backgrounds/main-slider-v1-1.jpg);"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="main-slider__content">
                                <div class="main-slider__content-icon-one">
                                    <span class="icon-lamp"></span>
                                </div>
                                <div class="main-slider__content-icon-two">
                                    <span class="icon-human-resources"></span>
                                </div>
                                <div class="main-slider-one__round-box">
                                    <div class="main-slider-one__round-box-inner">
                                        <p>Professional <br>teachers</p>
                                        <div class="icon">
                                            <i class="fas fa-sort-up"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-slider__content-tagline">
                                    <h2>Ready to learn?</h2>
                                </div>
                                <h2 class="main-slider__content-title">Learn new <br>things daily</h2>
                                <p class="main-slider__content-text">Get free access to 6800+ different courses from
                                    <br> 680 professional teachers</p>
                                <div class="main-slider__content-btn">
                                    <a href="#" class="thm-btn">Discover more</a>
                                </div>
                                <div class="main-slider-one__img">
                                    <img src="assets/images/backgrounds/main-slider-v1-img.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-pagination" id="main-slider-pagination"></div>
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                        <span class="icon-left"></span>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                        <span class="icon-right"></span>
                    </div>
                </div>

            </div>
        </section>

         <!--Features One Start-->
        <section class="features-one">
            <div class="container">
                <div class="row">
                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-empowerment"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4><a href="#">Learn Skills</a></h4>
                                <p>with unlimited courses</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-human-resources-1"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4><a href="#">Expert Teachers</a></h4>
                                <p>best & highly qualified</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-recruitment"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4><a href="#">Certificates</a></h4>
                                <p>value all over the world</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->
                </div>
            </div>
        </section>
        <!--Features One End-->

        {{--
        <!--About One Start-->
        <section class="about-one clearfix">
            <div class="container">
                <div class="row">
                    <!-- Start About One Left-->
                    <div class="col-xl-6">
                        <div class="about-one__left">
                            <ul class="about-one__left-img-box list-unstyled clearfix">
                                <li class="about-one__left-single">
                                    <div class="about-one__left-img1">
                                        <img src="assets/images/about/about-v1-img1.jpg" alt="" />
                                    </div>
                                </li>
                                <li class="about-one__left-single">
                                    <div class="about-one__left-img2">
                                        <img src="assets/images/about/about-v1-img2.jpg" alt="" />
                                    </div>
                                </li>
                            </ul>
                            <div class="about-one__left-overlay">
                                <div class="icon">
                                    <span class="icon-relationship"></span>
                                </div>
                                <div class="title">
                                    <h6>Trusted by<br><span class="odometer" data-count="8800">00</span> customers</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End About One Left-->


                    <!-- Start About One Right-->
                    <div class="col-xl-6">
                        <div class="about-one__right">
                            <div class="section-title">
                                <span class="section-title__tagline">About Zilom Company</span>
                                <h2 class="section-title__title">Welcome to the Online <br>Learning Center</h2>
                            </div>
                            <div class="about-one__right-inner">
                                <p class="about-one__right-text">There are many variations of passages of lorem ipsum
                                    available but the majority have suffered alteration in some form by injected humour
                                    or randomised words which don't look.</p>
                                <ul class="about-one__right-list list-unstyled">
                                    <li class="about-one__right-list-item">
                                        <div class="icon">
                                            <span class="icon-confirmation"></span>
                                        </div>
                                        <div class="text">
                                            <p>Get unlimited access to 66000+ of our top courses</p>
                                        </div>
                                    </li>

                                    <li class="about-one__right-list-item">
                                        <div class="icon">
                                            <span class="icon-confirmation"></span>
                                        </div>
                                        <div class="text">
                                            <p>Explore a variety of fresh educational topics</p>
                                        </div>
                                    </li>

                                    <li class="about-one__right-list-item">
                                        <div class="icon">
                                            <span class="icon-confirmation"></span>
                                        </div>
                                        <div class="text">
                                            <p>Find the best qualitfied teacher for you</p>
                                        </div>
                                    </li>
                                </ul>

                                <div class="about-one__btn">
                                    <a href="about.html" class="thm-btn">view all courses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End About One Right-->
                </div>
            </div>
        </section>
        <!--About One End-->


        <!--Courses One Start-->
        <section class="courses-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Checkout New List</span>
                    <h2 class="section-title__title">Explore Courses</h2>
                </div>
                <div class="row">
                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img1.jpg" alt="" />
                                <div class="overlay-text">
                                    <p>Featured</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img1.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">Kevin Martin</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInLeft" data-wow-delay="100ms"
                            data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img2.jpg" alt="" />
                                <div class="overlay-text">
                                    <p>free</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img2.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">Christine Eve</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInRight" data-wow-delay="0ms"
                            data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img3.jpg" alt="" />
                                <div class="overlay-text">
                                    <p>Featured</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img3.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">David Cooper</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInRight" data-wow-delay="100ms"
                            data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img4.jpg" alt="" />
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img4.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">Sarah Albert</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img5.jpg" alt="" />
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img5.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">Sarah Albert</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInLeft" data-wow-delay="100ms"
                            data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img6.jpg" alt="" />
                                <div class="overlay-text">
                                    <p>Featured</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img6.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">Kevin Martin</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInRight" data-wow-delay="0ms"
                            data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img7.jpg" alt="" />
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img7.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">Christine Eve</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->

                    <!--Start Single Courses One-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="courses-one__single wow fadeInRight" data-wow-delay="100ms"
                            data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <img src="assets/images/resources/courses-v1-img8.jpg" alt="" />
                                <div class="overlay-text">
                                    <p>free</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="assets/images/resources/courses-v1-overlay-img8.png" alt="" />
                                </div>
                                <h6 class="courses-one__single-content-name">David Cooper</h6>
                                <h4 class="courses-one__single-content-title"><a href="course-details.html">Become a
                                        React Developer</a></h4>
                                <div class="courses-one__single-content-review-box">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <div class="rateing-box">
                                        <span>(4)</span>
                                    </div>
                                </div>
                                <p class="courses-one__single-content-price">$30.00</p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li>2 Lessons</li>
                                    <li>10 Hours</li>
                                    <li>Beginner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->
                </div>
            </div>
        </section>
        <!--Courses One End-->



        <!--Registration One Start-->
        <section class="registration-one jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%">
            <div class="registration-one__bg"
                style="background-image: url(assets/images/resources/registration-one-bg.jpg);"></div>
            <div class="container">
                <div class="row">
                    <!--Start Registration One Left-->
                    <div class="col-xl-7 col-lg-7">
                        <div class="registration-one__left">
                            <div class="section-title">
                                <span class="section-title__tagline">Get Free Registration</span>
                                <h2 class="section-title__title">Register your Account<br> Get free Access to <span
                                        class="odometer" data-count="66000">00</span> <br>Online Courses</h2>
                            </div>
                            <p class="registration-one__left-text">There are many variations of passages of lorem ipsum
                                available but the majority have suffered alteration in some form.</p>
                            <div class="registration-one__left-transform-box">
                                <div class="registration-one__left-transform-box-icon">
                                    <span class="icon-online-course"></span>
                                </div>
                                <div class="registration-one__left-transform-box-text">
                                    <h3><a href="#">Transform Access To Education</a></h3>
                                    <p>Discover creative projects limited editions of 100 <br>from artists, designers,
                                        and more.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Registration One Left-->

                    <!--Start Registration One Right-->
                    <div class="col-xl-5 col-lg-5">
                        <div class="registration-one__right wow slideInRight" data-wow-delay="100ms"
                            data-wow-duration="2500ms">
                            <div class="registration-one__right-form">
                                <div class="title-box">
                                    <h4>Fill your Registration</h4>
                                </div>
                                <div class="form-box">
                                    <form method="post" action="index.html">
                                        <div class="form-group">
                                            <input type="text" name="username" placeholder="Your Name" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Email Address" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="phone" placeholder="Phone" required="">
                                        </div>
                                        <div class="form-group">
                                            <textarea placeholder="Comment"></textarea>
                                        </div>
                                        <button class="registration-one__right-form-btn" type="submit"
                                            name="submit-form">
                                            <span class="thm-btn">apply for it</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Registration One Right-->
                </div>
            </div>
        </section>
        <!--Registration One End-->


        <!--Categories One Start-->
        <section class="categories-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Checkout New List</span>
                    <h2 class="section-title__title">Top Categories</h2>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="categories-one__wrapper">
                            <div class="row">
                                <!--Start Single Categories One-->
                                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0ms"
                                    data-wow-duration="1500ms">
                                    <div class="categories-one__single">
                                        <div class="categories-one__single-img">
                                            <img src="assets/images/resources/categories-v1-img1.jpg" alt="" />
                                            <div class="categories-one__single-overlay">
                                                <div class="categories-one__single-overlay-text1">
                                                    <p>30 full courses</p>
                                                </div>
                                                <div class="categories-one__single-overlay-text2">
                                                    <h4>Art & Design</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Categories One-->

                                <!--Start Single Categories One-->
                                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms"
                                    data-wow-duration="1500ms">
                                    <div class="categories-one__single">
                                        <div class="categories-one__single-img">
                                            <img src="assets/images/resources/categories-v1-img2.jpg" alt="" />
                                            <div class="categories-one__single-overlay">
                                                <div class="categories-one__single-overlay-text1">
                                                    <p>30 full courses</p>
                                                </div>
                                                <div class="categories-one__single-overlay-text2">
                                                    <h4>Art & Design</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Categories One-->

                                <!--Start Single Categories One-->
                                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms"
                                    data-wow-duration="1500ms">
                                    <div class="categories-one__single">
                                        <div class="categories-one__single-img">
                                            <img src="assets/images/resources/categories-v1-img3.jpg" alt="" />
                                            <div class="categories-one__single-overlay">
                                                <div class="categories-one__single-overlay-text1">
                                                    <p>30 full courses</p>
                                                </div>
                                                <div class="categories-one__single-overlay-text2">
                                                    <h4>Art & Design</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Categories One-->

                                <!--Start Single Categories One-->
                                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="600ms"
                                    data-wow-duration="1500ms">
                                    <div class="categories-one__single">
                                        <div class="categories-one__single-img">
                                            <img src="assets/images/resources/categories-v1-img4.jpg" alt="" />
                                            <div class="categories-one__single-overlay">
                                                <div class="categories-one__single-overlay-text1">
                                                    <p>30 full courses</p>
                                                </div>
                                                <div class="categories-one__single-overlay-text2">
                                                    <h4>Art & Design</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Categories One-->
                            </div>
                        </div>
                        <div class="categories-one__btn text-center">
                            <a href="#" class="thm-btn">view all courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Categories One End-->



        <!--Testimonials One Start-->
        <section class="testimonials-one clearfix">
            <div class="auto-container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Our Testimonials</span>
                    <h2 class="section-title__title">What They Say?</h2>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="testimonials-one__wrapper">
                            <div class="testimonials-one__pattern"><img
                                    src="assets/images/pattern/testimonials-one-left-pattern.png" alt="" /></div>
                            <div class="shape1"><img src="assets/images/shapes/thm-shape3.png" alt="" /></div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="testimonials-one__carousel owl-carousel owl-theme owl-dot-type1">
                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="0ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img1.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>Kevin Martin</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->

                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="100ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img2.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>Christine Eve</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->

                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="200ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img3.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>David Cooper</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->
                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="0ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img1.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>Kevin Martin</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->
                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="100ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img2.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>Christine Eve</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->
                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="200ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img3.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>David Cooper</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->
                                        <!--Start Single Testimonials One -->
                                        <div class="testimonials-one__single wow fadeInUp" data-wow-delay="0ms"
                                            data-wow-duration="1500ms">
                                            <div class="testimonials-one__single-inner">
                                                <h4 class="testimonials-one__single-title">Amazing Courses</h4>
                                                <p class="testimonials-one__single-text">Lorem ipsum is simply free text
                                                    dolor sit amet, consectetur notted adipisicing elit sed do eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div class="testimonials-one__single-client-info">
                                                    <div class="testimonials-one__single-client-info-img">
                                                        <img src="assets/images/testimonial/testimonials-v1-client-info-img1.png"
                                                            alt="" />
                                                    </div>
                                                    <div class="testimonials-one__single-client-info-text">
                                                        <h5>Kevin Martin</h5>
                                                        <p>Developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Single Testimonials One -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Testimonials One End-->


        <!--Company Logos One Start-->
        <section class="company-logos-one">
            <div class="container">
                <div class="company-logos-one__title text-center">
                    <h6>Who Will You Learn With?</h6>
                </div>
                <div class="thm-swiper__slider swiper-container" data-swiper-options='{"spaceBetween": 100, "slidesPerView": 5, "autoplay": { "delay": 5000 }, "breakpoints": {
                "0": {
                    "spaceBetween": 30,
                    "slidesPerView": 2
                },
                "375": {
                    "spaceBetween": 30,
                    "slidesPerView": 2
                },
                "575": {
                    "spaceBetween": 30,
                    "slidesPerView": 3
                },
                "767": {
                    "spaceBetween": 50,
                    "slidesPerView": 4
                },
                "991": {
                    "spaceBetween": 50,
                    "slidesPerView": 5
                },
                "1199": {
                    "spaceBetween": 100,
                    "slidesPerView": 5
                }
            }}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/resources/Company-Logos-v1-logo1.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div>
                </div>
            </div>
        </section>
        <!--Company Logos One End-->


        <!--Why Choose One Start-->
        <section class="why-choose-one">
            <div class="container">
                <div class="row">
                    <!--Start Why Choose One Left-->
                    <div class="col-xl-6 col-lg-6">
                        <div class="why-choose-one__left">
                            <div class="section-title">
                                <span class="section-title__tagline">Why Choose Us?</span>
                                <h2 class="section-title__title">Benefits of Learning <br>from Zilom</h2>
                            </div>
                            <p class="why-choose-one__left-text">There cursus massa at urnaaculis estie. Sed
                                aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed medy
                                fringilla vitae.</p>
                            <div class="why-choose-one__left-learning-box">
                                <div class="icon">
                                    <span class="icon-professor"></span>
                                </div>
                                <div class="text">
                                    <h4>Start learning from our experts and <br>enhance your skills</h4>
                                </div>
                            </div>
                            <div class="why-choose-one__left-list">
                                <ul class="list-unstyled">
                                    <li class="why-choose-one__left-list-single">
                                        <div class="icon">
                                            <span class="icon-confirmation"></span>
                                        </div>
                                        <div class="text">
                                            <p>Making this the first true on the Internet</p>
                                        </div>
                                    </li>

                                    <li class="why-choose-one__left-list-single">
                                        <div class="icon">
                                            <span class="icon-confirmation"></span>
                                        </div>
                                        <div class="text">
                                            <p>Lorem Ipsum is not simply random text</p>
                                        </div>
                                    </li>

                                    <li class="why-choose-one__left-list-single">
                                        <div class="icon">
                                            <span class="icon-confirmation"></span>
                                        </div>
                                        <div class="text">
                                            <p> If you are going to use a passage</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Why Choose One Left-->

                    <!--Start Why Choose One Right-->
                    <div class="col-xl-6 col-lg-6">
                        <div class="why-choose-one__right wow slideInRight animated clearfix" data-wow-delay="0ms"
                            data-wow-duration="1500ms">
                            <div class="why-choose-one__right-img clearfix">
                                <img src="assets/images/resources/why-choose-v1-img.jpg" alt="" />
                                <div class="why-choose-one__right-img-overlay">
                                    <p>We’re the best institution</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Why Choose One Right-->

                </div>
            </div>
        </section>
        <!--Why Choose One End-->



        <!--Blog One Start-->
        <section class="blog-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Directly from the Blog</span>
                    <h2 class="section-title__title">Latest Articles</h2>
                </div>
                <div class="row">
                    <!--Start Single Blog One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="blog-one__single">
                            <div class="blog-one__single-img">
                                <img src="assets/images/blog/blog-v1-img1.jpg" alt="" />
                            </div>
                            <div class="blog-one__single-content">
                                <div class="blog-one__single-content-overlay-mata-info">
                                    <ul class="list-unstyled">
                                        <li><a href="#"><span class="icon-clock"></span>20 June</a></li>
                                        <li><a href="#"><span class="icon-user"></span>Admin </a></li>
                                        <li><a href="#"><span class="icon-chat"></span> Comments</a></li>
                                    </ul>
                                </div>
                                <h2 class="blog-one__single-content-title"><a href="news-details.html">Helping Answers
                                        Stand out in Discussions</a></h2>
                                <p class="blog-one__single-content-text">Lorem ipsum is simply free text on used by
                                    copytyping refreshing the whole area.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Blog One-->

                    <!--Start Single Blog One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="blog-one__single">
                            <div class="blog-one__single-img">
                                <img src="assets/images/blog/blog-v1-img2.jpg" alt="" />
                            </div>
                            <div class="blog-one__single-content">
                                <div class="blog-one__single-content-overlay-mata-info">
                                    <ul class="list-unstyled">
                                        <li><a href="#"><span class="icon-clock"></span>20 June</a></li>
                                        <li><a href="#"><span class="icon-user"></span>Admin </a></li>
                                        <li><a href="#"><span class="icon-chat"></span> Comments</a></li>
                                    </ul>
                                </div>
                                <h2 class="blog-one__single-content-title"><a href="news-details.html">Helping Answers
                                        Stand out in Discussions</a></h2>
                                <p class="blog-one__single-content-text">Lorem ipsum is simply free text on used by
                                    copytyping refreshing the whole area.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Blog One-->

                    <!--Start Single Blog One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms">
                        <div class="blog-one__single">
                            <div class="blog-one__single-img">
                                <img src="assets/images/blog/blog-v1-img3.jpg" alt="" />
                            </div>
                            <div class="blog-one__single-content">
                                <div class="blog-one__single-content-overlay-mata-info">
                                    <ul class="list-unstyled">
                                        <li><a href="#"><span class="icon-clock"></span>20 June</a></li>
                                        <li><a href="#"><span class="icon-user"></span>Admin </a></li>
                                        <li><a href="#"><span class="icon-chat"></span> Comments</a></li>
                                    </ul>
                                </div>
                                <h2 class="blog-one__single-content-title"><a href="news-details.html">Helping Answers
                                        Stand out in Discussions</a></h2>
                                <p class="blog-one__single-content-text">Lorem ipsum is simply free text on used by
                                    copytyping refreshing the whole area.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Blog One-->
                </div>
            </div>
        </section>
        <!--Blog One End-->

        <!--Start Newsletter One-->
        <section class="newsletter-one">
            <div class="container">
                <div class="row">
                    <!--Start Newsletter One Left-->
                    <div class="col-xl-6 col-lg-6">
                        <div class="newsletter-one__left">
                            <div class="section-title">
                                <h2 class="section-title__title">Subscribe to Our <br>Newsletter to Get Daily
                                    <br>Content!</h2>
                            </div>
                        </div>
                    </div>
                    <!--End Newsletter One Left-->

                    <!--Start Newsletter One Right-->
                    <div class="col-xl-6 col-lg-6">
                        <div class="newsletter-one__right">
                            <div class="shape1 zoom-fade"><img src="assets/images/shapes/thm-shape2.png" alt="" /></div>
                            <div class="shape2 wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms"><img
                                    src="assets/images/shapes/thm-shape3.png" alt="" /></div>
                            <div class="newsletter-form wow slideInDown" data-wow-delay="100ms"
                                data-wow-duration="1500ms">
                                <form action="#">
                                    <input type="text" name="email" placeholder="Enter your email">
                                    <button type="submit"><span class="icon-paper-plane"></span></button>
                                </form>
                                <div class="newsletter-one__right-checkbox">
                                    <input type="checkbox" name="agree " id="agree" checked>
                                    <label for="agree"><span></span>I agree to all terms and policies of the
                                        company</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Newsletter One Right-->
                </div>
            </div>
        </section>
        <!--End Newsletter One-->




        <!--Start Footer One-->
        <footer class="footer-one">
            <div class="footer-one__bg" style="background-image: url(assets/images/backgrounds/footer-v1-bg.jpg);">
            </div><!-- /.footer-one__bg -->
            <div class="footer-one__top">
                <div class="container">
                    <div class="row">
                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.1s">
                            <div class="footer-widget__column footer-widget__about">
                                <div class="footer-widget__about-logo">
                                    <a href="index.html"><img src="assets/images/resources/footer-logo.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.3s">
                            <div class="footer-widget__column footer-widget__courses">
                                <h3 class="footer-widget__title">Courses</h3>
                                <ul class="footer-widget__courses-list list-unstyled">
                                    <li><a href="#">UI/UX Design</a></li>
                                    <li><a href="#">WordPress Development</a></li>
                                    <li><a href="#">Business Strategy</a></li>
                                    <li><a href="#">Software Development</a></li>
                                    <li><a href="#">Business English</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.5s">
                            <div class="footer-widget__column footer-widget__links">
                                <h3 class="footer-widget__title">Links</h3>
                                <ul class="footer-widget__links-list list-unstyled">
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="#">Overview</a></li>
                                    <li><a href="teachers-1.html">Teachers</a></li>
                                    <li><a href="#">Join Us</a></li>
                                    <li><a href="news.html">Our News</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-3 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.7s">
                            <div class="footer-widget__column footer-widget__contact">
                                <h3 class="footer-widget__title">Contact</h3>
                                <p class="text">88 broklyn street, New York USA</p>
                                <p><a href="mailto:info@templatepath.com">needhelp@company.com</a></p>
                                <p class="phone"><a href="tel:123456789">92 888 666 0000</a></p>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-3 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.9s">
                            <div class="footer-widget__column footer-widget__social-links">
                                <ul class="footer-widget__social-links-list list-unstyled clearfix">
                                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                    </div>
                </div>
            </div>

            <!--Start Footer One Bottom-->
            <div class="footer-one__bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="footer-one__bottom-inner">
                                <div class="footer-one__bottom-text text-center">
                                    <p>&copy; Copyright 2021 by Layerdrops.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer One Bottom-->
        </footer>
        <!--End Footer One--> --}}

    </div><!-- /.page-wrapper -->



    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="index.html" aria-label="logo image"><img src="assets/images/resources/mobilemenu_logo.png"
                        width="155" alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="icon-phone-call"></i>
                    <a href="mailto:needhelp@packageName__.com">needhelp@zilom.com</a>
                </li>
                <li>
                    <i class="icon-letter"></i>
                    <a href="tel:666-888-0000">666 888 0000</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-facebook-square"></a>
                    <a href="#" class="fab fa-pinterest-p"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->
        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


    <script src="{{ asset('landing-assets/vendors/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/jarallax/jarallax.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/jquery-appear/jquery.appear.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/jquery-validate/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/nouislider/nouislider.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/odometer/odometer.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/swiper/swiper.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/tiny-slider/tiny-slider.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/wnumb/wNumb.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/wow/wow.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/isotope/isotope.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/countdown/countdown.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/twentytwenty/twentytwenty.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/twentytwenty/jquery.event.move.js')}}"></script>
    <script src="{{ asset('landing-assets/vendors/parallax/parallax.min.js')}}"></script>


    <script src="http://maps.google.com/maps/api/js?key=AIzaSyATY4Rxc8jNvDpsK8ZetC7JyN4PFVYGCGM"></script>

    <!-- template js -->
    <script src="{{ asset('landing-assets/js/zilom.js')}}"></script>


</body>

</html>