 <!-- Start Footer Area -->
    <footer class="footer">
        <!-- Start Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="footer-logo">
                                <a href="index.php">
                                    <img src="assets/images/logo/logo.png" alt="#">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <div class="footer-newsletter">
                                <h4 class="title">
                                    Subscribe to our Newsletter
                                    <span>Get all the latest information, Sales and Offers.</span>
                                </h4>
                                <div class="newsletter-form-head">
                                    <form action="#" method="get" target="_blank" class="newsletter-form">
                                        <input name="EMAIL" placeholder="Email address here..." type="email">
                                        <div class="button">
                                            <button class="btn">Subscribe<span class="dir-part"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Top -->
        <!-- Start Footer Middle -->
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>Get In Touch With Us</h3>
                                <p class="phone">Phone: +82 (043) 855 1234</p>
                                <ul>
                                    <li><span>Monday-Friday: </span> 9.00 am - 8.00 pm</li>
                                    <li><span>Saturday: </span> 10.00 am - 6.00 pm</li>
                                </ul>
                                <p class="mail">
                                    <a href="mailto:jzziqw04@kku.ac.kr">applemarket@kku.ac.kr</a>
                                </p>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer our-app">
                                <h3>Our Mobile App</h3>
                                <ul class="app-btn">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-apple"></i>
                                            <span class="small-title">Download on the</span>
                                            <span class="big-title">App Store</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-play-store"></i>
                                            <span class="small-title">Download on the</span>
                                            <span class="big-title">Google Play</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Information</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">About Us</a></li>
                                    <li><a href="javascript:void(0)">Contact Us</a></li>
                                    <li><a href="javascript:void(0)">Downloads</a></li>
                                    <li><a href="javascript:void(0)">Sitemap</a></li>
                                    <li><a href="javascript:void(0)">FAQs Page</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Shop Departments</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Computers & Accessories</a></li>
                                    <li><a href="javascript:void(0)">Smartphones & Tablets</a></li>
                                    <li><a href="javascript:void(0)">TV, Video & Audio</a></li>
                                    <li><a href="javascript:void(0)">Cameras, Photo & Video</a></li>
                                    <li><a href="javascript:void(0)">Headphones</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                    <div class="col-lg-4 col-12">
                            <div class="copyright">
                                &nbsp;
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>Designed and Developed by<a href="#" rel="nofollow"
                                        target="_blank">Jisung, Juyoung, Hwansoo</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= write botton ========================= -->
    <a href="product-write.php" class="scroll-top">
        <i class="lni lni-write"></i>
    </a>


    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="#">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/product-write.js"></script>
    <script src="assets/js/search-result.js"></script>
    <script type="text/javascript">
        //========= Hero Slider 
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
        });

        //======== Brand Slider
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });
    </script>
    <script>
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');
        }

        if (window.matchMedia('(max-width: 767px)').matches) {
            // 부모 요소를 선택합니다.
            var parentElement = document.querySelector('.row.align-items-center.h-m-c');

            // A, B, C 요소를 선택합니다.
            var elementA = document.querySelector('.col-lg-3.col-md-3.col-7');
            var elementB = document.querySelector('.col-lg-5.col-md-7.d-xs-none');
            var elementC = document.querySelector('.col-lg-4.col-md-2.col-5');
            
            // A, C, B 순서로 요소를 이동시킵니다.
            parentElement.appendChild(elementA);
            parentElement.appendChild(elementC);
            parentElement.appendChild(elementB);
        }


        function enterSearch() {
            if(event.keyCode == 13){
                myFunction();
            }
        }

        function myFunction() {
            var x = "http://49.50.161.31";
            var y = document.getElementById("search-input").value;
            window.location.href = x + "/search-result.php?search_keyword=" + y;
        }
    </script>
    <style>
        @media screen and (max-width: 767px) {
            .d-xs-none {
            display: block !important;
            }

            .main-menu-search {
                display: block !important;
            }

            .container#A {
                height: 90px;
            }

            .h-m-c {
                display: flex;
                flex-direction: column;
            }

            .h-m-c {
                position: relative;
                top: -65px;
                left: 0px;
            }

            .col-7 {
                position: relative;
                top: 55px;
                left: -80px;
            }

            .d-xs-none {
                margin-top: 15px;
            }

            .col-5 {
                position: relative;
                top: 0px;
                left: 100px;
                margin-top: 15px;
            }
        }
    </style>

        <script>
        // 가격 포맷팅 함수
        function formatPrice() {
        var priceElements = document.getElementsByClassName('price');
        for (var i = 0; i < priceElements.length; i++) {
            var priceText = priceElements[i].textContent;
            var priceValue = parseInt(priceText.replace(/[^\d]+/g, ''));
            priceElements[i].textContent = priceValue.toLocaleString() + '원';
        }
        }

        // 페이지 로드 시 가격 포맷팅 적용
        window.addEventListener('load', formatPrice);
        </script>
</body>