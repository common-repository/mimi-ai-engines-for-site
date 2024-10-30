<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<!doctype html>
<html lang="">

<head>
    <meta charset="utf-8">

    <!-- site title -->
    <title>Landing Page</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- stylesheets -->
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/normalize.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/line-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/slick.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/jquery.nice-number.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/mean-menu.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/default.css') ?>">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/css/style.css') ?>">
</head>

<body>

    <!-- scroll top button -->
    <div id="scrollToTop" class="scrollTop">
        <i class="las la-arrow-up"></i>
    </div>
    <!-- slider area starts -->
    <div style="background-image: url(<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/img/slider-area/slider-bg.png') ?>)" class="slider-area slider-2 pt-105">
        <div class="single-slide slider-height position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-5  col-md-6">
                        <div class="slider-description mt-200">
                            <h1 style="color: #FA6C2D;font-weight: bold;">
                                <?php echo esc_html($product_name) ?>
                            </h1>
                            <p class="pb-30">

                            </p>
                            <a href="#" class="slider-btn position-relative">SHOP NOW</a>
                        </div>
                    </div>
                    <div class="slider-images ">
                        <div class="slider-image-bg">
                            <img style="width: 402px; height: 498px;" src="<?php echo esc_url($product_thumbnailURL) ?>" alt="headset" />

                            <span class="slider-price-badge">
                                <span style="color: #FA6C2D; font-weight: bold;">
                                    <?php echo esc_html($salePrice) ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="shop-details pt-120 ">
        <div class="container">
            <div class="row">
                <div class="col-xl-1 col-lg-1 col-md-2 col-sm-12">
                    <div class="nav nav-tabs " id="approach-tabs" role="tablist">
                        <?php
                        if (count($product_images) > 0) {
                            $index = 0;
                            foreach ($product_images as $image) {
                        ?>
                                <a class="product-thumb mb-15 <?php echo esc_html($image == $product_images[0] ? 'active' : '') ?>" id="<?php echo esc_html('nav-thumb' . $index) ?>" data-toggle="tab" href="<?php echo esc_html('#nav-product' . $index) ?>" role="tab" aria-controls="<?php echo esc_html('nav-product' . $index) ?>" aria-selected="true">
                                    <img style="width:70px; height:90px" src="<?php echo esc_url($image) ?>" alt="img" />
                                </a>
                            <?php
                                $index++;
                            }
                        } else {
                            ?>
                            <a class="product-thumb mb-15 active" id="nav-thumb1" data-toggle="tab" href="#nav-product1" role="tab" aria-controls="nav-product1" aria-selected="true">
                                <img style="width:70px; height:90px" src="<?php echo esc_url($product_thumbnailURL) ?>" alt="img" />
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-xl-11 col-lg-11 col-md-10 col-sm-12">
                    <div class="product-wrapper d-flex">
                        <div class="product-imges tab-content" id="nav-tabContents">
                            <?php
                            if (count($product_images) > 0) {
                                $i = 0;
                                foreach ($product_images as $image) {
                            ?>
                                    <div class="tab-pane product-img <?php echo esc_html($image == $product_images[0] ? 'active' : '') ?>" id="<?php echo esc_html('nav-product' . $i) ?>" role="tabpanel" aria-labelledby="<?php echo esc_html('nav-thumb' . $i) ?>">
                                        <img style="width: 350px; height: 469px" src="<?php echo esc_url($image) ?>" alt="img" />
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="tab-pane product-img active" id="nav-product1" role="tabpanel" aria-labelledby="nav-thumb1">
                                    <img style="width: 350px; height: 469px" src="<?php echo esc_url($product_thumbnailURL) ?>" alt="img" />
                                </div>
                            <?php
                            }

                            ?>
                        </div>

                        <div class="product-details ml-50">
                            <h5>
                                <?php echo esc_html($product_name) ?>
                            </h5>
                            <ul class="rating d-inline-block mr-20">
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                            </ul>
                            <span><?php echo esc_html($reviewCount) ?> Customer Review</span>
                            <div class="price pt-15 pb-10">
                                <span><?php echo esc_html($salePrice != '' ? $salePrice : $originalPrice) ?></span>
                            </div>
                            <p class="pr-110">
                                <?php echo esc_html($product_description) ?>
                            </p>
                            <div class="product-color pt-10 d-flex">
                                <h6>SELECT COLOR</h6>
                                <div class="color-code pl-20">
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <div class="product-size d-flex pt-10">
                                <h6>SELECT SIZE</h6>
                                <ul class="ml-50">
                                    <li class="active">Xl </li>
                                    <li>L</li>
                                    <li>M</li>
                                    <li>S</li>
                                    <li>XS</li>
                                </ul>
                            </div>
                            <div class="product-count d-flex mt-25">
                                <div class="quty mr-20">
                                    <input class="qty" type="number" value="1">
                                </div>
                                <div class="add-tocart mr-20 mt-15 mt-sm-0">
                                    <a class="p-btn position-relative" href="<?php echo esc_url($linkAddToCart) ?>">
                                        <span>Add to cart</span>
                                    </a>
                                </div>

                            </div>
                            <ul class="social-icon pt-80">
                                <li><a href="https://www.facebook.com"><i class="fab fa-facebook-square"></i></a></li>
                                <li><a href="https://twitter.com/"><i class="fab fa-twitter-square"></i></a></li>
                                <li><a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
            <hr class="pt-75">
        </div>
    </div>

    <div class="description-area pt-65">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="description-tab ">
                        <nav>
                            <div class="nav nav-tabs justify-content-center" id="approach-tab" role="tablist">
                                <a class="nav-item active mr-75" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Description</a>
                            </div>
                        </nav>

                        <div class="tab-content mt-55 ml-100" id="nav-tabContent">
                            <div class="tab-pane active " id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="position-relative">
                                            <?php echo esc_html($product_description) ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->

    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/jquery.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/modernizr-3.11.2.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/bootstrap.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/popper.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/jquery-mean-menu.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/owl.carousel.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/slick.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/wow-1.3.0.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/isotope.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/vendor/jquery.nice-number.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/countdown.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-8/assets/js/scripts.js') ?>"></script>

</body>

</html>