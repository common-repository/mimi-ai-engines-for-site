<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<!doctype html>
<html>

<head>
    <!-- Meta Data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>

    <!-- Dependency Styles -->
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/fontawesome/css/fontawesome-all.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/owl.carousel/css/owl.carousel.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/owl.carousel/css/owl.theme.default.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/flaticon/css/flaticon.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/jquery-ui/css/jquery-ui.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/venobox/css/venobox.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/slick-carousel/css/slick.css') ?>" type="text/css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/assets/css/app.css') ?>" type="text/css">
</head>

<body id="home-version-1" class="home-version-1" data-style="default">
    <div class="site-content">

        <section class="slider-wrapper">
            <div class="slider-start slider-1 owl-carousel owl-theme">

                <div class="item">
                    <img src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/assets/img/bgm.jpeg') ?>" alt="">
                    <div class="container-fluid custom-container slider-content">
                        <div class="row align-items-center">

                            <div class="col-12 col-sm-8 col-md-8 col-lg-6 ml-auto">
                                <div class="slider-text ">
                                    <h4 class="animated fadeInUp"><span style="color: white;">NEW PRODUCT</h4>
                                    <h1 class="animated fadeInUp" style="color: white;"><?php echo esc_html($product_name) ?></h1>
                                    <p class="animated fadeInUp" style="color: white;"></p>
                                    <a class="animated fadeInUp btn-two" href="<?php echo esc_url($linkAddToCart) ?>">ADD TO CART</a>
                                </div>
                            </div>
                            <!-- Col End -->
                        </div>
                        <!-- Row End -->
                    </div>
                </div>


            </div>
        </section>
        <!-- Slides end -->

        <section class="shop-area style-two">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <!-- Product View Slider -->
                                <div class="quickview-slider">
                                    <div class="slider-for">
                                        <?php

                                        if (count($product_images) > 0) {
                                            foreach ($product_images as $image) {
                                        ?>
                                                <div class="">
                                                    <img src="<?php echo esc_url($image) ?>" alt="Thumb">
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="">
                                                <img src="<?php echo esc_url($product_thumbnailURL) ?>" alt="Thumb">
                                            </div>
                                        <?php
                                        }

                                        ?>
                                    </div>

                                    <div class="slider-nav">
                                        <?php

                                        if (count($product_images) > 0) {
                                            foreach ($product_images as $image) {
                                        ?>
                                                <div class="">
                                                    <img src="<?php echo esc_url($image) ?>" alt="Thumb">
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="">
                                                <img src="<?php echo esc_url($product_thumbnailURL) ?>" alt="Thumb">
                                            </div>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                                <!-- /.quickview-slider -->
                            </div>
                            <!-- /.col-xl-6 -->

                            <div class="col-lg-6 col-xl-6">
                                <div class="product-details">
                                    <h5 class="pro-title">
                                        <a href="<?php echo esc_url($product_url) ?>">
                                            <?php echo esc_html($product_name) ?>
                                        </a>
                                    </h5>

                                    <span class="price">Price : <?php echo esc_html($salePrice != '' ? $salePrice : $originalPrice) ?></span>

                                    <div class="size-variation">
                                        <span>size :</span>
                                        <select name="size-value">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                            <option value="">4</option>
                                            <option value="">5</option>
                                        </select>
                                    </div>

                                    <div class="color-variation">
                                        <span>color :</span>
                                        <ul>
                                            <li><i class="fas fa-circle"></i></li>
                                            <li><i class="fas fa-circle"></i></li>
                                            <li><i class="fas fa-circle"></i></li>
                                            <li><i class="fas fa-circle"></i></li>
                                        </ul>
                                    </div>

                                    <div class="add-tocart-wrap">
                                        <!--PRODUCT INCREASE BUTTON START-->
                                        <div class="cart-plus-minus-button">
                                            <input type="text" value="0" name="qtybutton" class="cart-plus-minus">
                                        </div>
                                        <a href="<?php echo esc_url($linkAddToCart) ?>" class="add-to-cart">
                                            <i class="flaticon-shopping-purse-icon"></i>
                                            Add to Cart
                                        </a>
                                        <!-- <a href="#"><i class="flaticon-valentines-heart"></i></a> -->
                                    </div>

                                    <!-- <span>SKU:	N/A</span>
								<p>Tags <a href="#">boys,</a><a href="#"> dress,</a><a href="#">Rok-dress</a></p> -->

                                    <p>
                                        <?php echo esc_html($product_description) ?>
                                    </p>

                                    <div class="product-social">
                                        <span>Share :</span>
                                        <ul>
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        </ul>
                                    </div>

                                </div>
                                <!-- /.product-details -->
                            </div>
                            <!-- /.col-xl-6 -->


                            <div class="col-xl-12">
                                <div class="product-des-tab">
                                    <ul class="nav nav-tabs " role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">DESCRIPTION</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="prod-bottom-tab-sin description">
                                                <h5>Description</h5>
                                                <p>
                                                    <?php echo esc_html($product_description) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.col-xl-9 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <div class="backtotop">
            <i class="fa fa-angle-up backtotop_btn"></i>
        </div>

    </div>
    <!-- /#site -->

    <!-- Dependency Scripts -->
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/popper.js/popper.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/owl.carousel/js/owl.carousel.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/wow/js/wow.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/isotope-layout/js/isotope.pkgd.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/imagesloaded/js/imagesloaded.pkgd.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/jquery.countdown/js/jquery.countdown.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/gmap3/js/gmap3.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/venobox/js/venobox.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/slick-carousel/js/slick.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/headroom/js/headroom.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/dependencies/jquery-ui/js/jquery-ui.min.js') ?>"></script>


    <!-- Site Scripts -->
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-7/assets/js/app.js') ?>"></script>

</body>

</html>