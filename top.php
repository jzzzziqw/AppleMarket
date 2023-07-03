<?php session_start() ?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

    <!-- 문자 인코딩 & 최신 렌더링 엔진 설정 -->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    
    <title>AppleMarket - 지역사회 충주만의 중고거래 앱 </title>
    
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/product-write.css" />
    <link rel="stylesheet" href="assets/css/search-result.css" />
    <link rel="stylesheet" href="assets/css/rdp.css" />
    
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-left">
                            <ul class="menu-top-link">
                                <li>
                                    <div class="select-position">
                                        <select id="select4">
                                            <optgroup label="동">
                                                <option value="1">교현/안림동</option>
                                                <option value="2">교현2동</option>
                                                <option value="3">달천동</option>
                                                <option value="4">목행/용탄동</option>
                                                <option value="5">문화동</option>
                                                <option value="6">봉방동</option>
                                                <option value="7">성내/충인동</option>
                                                <option value="8">연수동</option>
                                                <option value="9">용산동</option>
                                                <option value="10">지현동</option>
                                                <option value="11">칠금/금릉동</option>
                                                <option value="12">호암/직동</option>
                                              </optgroup>
                                              
                                              <optgroup label="읍">
                                                <option value="13">주덕읍</option>
                                              </optgroup>
                                              
                                              <optgroup label="면">
                                                <option value="14">금가면</option>
                                                <option value="15">노은면</option>
                                                <option value="16">대소원면</option>
                                                <option value="17">동량면</option>
                                                <option value="18">산척면</option>
                                                <option value="19">살미면</option>
                                                <option value="20">소태면</option>
                                                <option value="21">수안보면</option>
                                                <option value="22">신니면</option>
                                                <option value="23">앙성면</option>
                                                <option value="24">엄정면</option>
                                                <option value="25">중앙탑면</option>
                                              </optgroup>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="contact.html">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                                <?php
                                    if(isset($_SESSION['name']))
                                    {  ?>    
                                <div class="user">
                                    <i class="lni lni-user"></i>
                                        <?php  if($_SESSION['name']==='admin')
                                        {?>
                                        <a href = admin-page.php>
                                        <?php
                                        } else { ?>
                                        <a href="mypage.php">  
                                        <?php }?>                             
                                      <?php  echo $_SESSION['name']; ?> 
                                </a>
                                <ul class="user-login">
                                <li>
                                    <a href="logout.php">로그아웃</a>
                                </li>
                            </ul>
                            </div>
                            <?php } else {?>
                            <ul class="user-login">
                                <li>
                                    <a href="login.html">Sign In</a>
                                </li>
                                <li>
                                    <a href="register.html">Register</a>
                                </li>
                            </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container" id="A">
                <div class="row align-items-center h-m-c">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/images/logo/logo.png" alt="Logo">
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <div class="navbar-search search-style-5">
                                <div class="search-select">
                                    <div class="select-position">
                                        <select id="select1">
                                            <option selected>전체</option>
                                            <option value="1">제목</option>
                                            <option value="2">제목+본문</option>
                                            <option value="3">본문</option>
                                            <option value="4">작성자</option>
					                        <option value="5">카테고리</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="search-input">
                                    <input id="search-input" type="text" placeholder="검색어를 입력해주세요. 예) 키보드" name="search_keyword" onkeydown="enterSearch()">
                                </div>
                                <div class="search-btn">
                                    <button id="search-button" onclick="myFunction()"><i class="lni lni-search-alt"></i></button>
                                </div>
                            </div>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                &nbsp;
                            </div>
                            <div class="navbar-cart">
                                <div class="wishlist">
                                    <a href="cart.php">
                                        <i class="lni lni-heart"></i>
                                        
                                    </a>
                                </div>
                                <div class="cart-items">
                                    <a href="product-write.php" class="main-btn">
                                        <i class="lni lni-pencil"></i>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->