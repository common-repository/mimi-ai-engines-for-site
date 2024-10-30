<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8" />
    <title>Landing Page</title>

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/css/owl.carousel.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/css/shoes.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/css/responsive.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/css/glass-case.css') ?>" />
</head>

<body>
    <div class="main" id="main">
        <section class="home-banner">
            <div class="container">
                <div class="home-slider owl-carousel">
                    <div class="banner-bg align-flax">
                        <div class="w-100">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 align-flax">
                                    <div class="banner-img">
                                        <img style="width: 448px; height: 556px" src="<?php echo esc_url($product_thumbnailURL) ?>" alt="banner" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 align-flax">
                                    <div class="banner-heading w-100">
                                        <label class="banner-top">Get UP To <?php echo esc_html($percentSale) ?> Off</label>
                                        <h2 style="font-size: 85px;" class="banner-title"><?php echo esc_html($product_name) ?></h2>
                                        <a href="" class="btn">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-detail-main pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-12">
                        <div class="align-center mb-md-30">
                            <ul id="glasscase" class="gc-start" style="display: block; opacity: 1">
                                <li>
                                    <img style="width: 756px; height: 756px" src="<?php echo esc_url($product_thumbnailURL) ?>" alt="product" />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-12">
                        <div class="product-detail-in">
                            <h2 class="product-item-name text-uppercase">
                                <?php echo esc_html($product_name) ?>
                            </h2>
                            <div class="price-box">
                                <span class="price"><?php echo esc_html($salePrice) ?></span>
                                <del class="price old-price"><?php echo esc_html($originalPrice) ?></del>
                                <div class="rating-summary-block">
                                    <div class="star-rating">
                                        <input id="star-5" type="radio" name="rating" value="star-5" />
                                        <label for="star-5" title="5 stars">
                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                        </label>
                                        <input id="star-4" type="radio" name="rating" value="star-4" />
                                        <label for="star-4" title="4 stars">
                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                        </label>
                                        <input id="star-3" type="radio" name="rating" value="star-3" />
                                        <label for="star-3" title="3 stars">
                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                        </label>
                                        <input id="star-2" type="radio" name="rating" value="star-2" />
                                        <label for="star-2" title="2 stars">
                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                        </label>
                                        <input id="star-1" type="radio" name="rating" value="star-1" />
                                        <label for="star-1" title="1 star">
                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <a href="#product-review" class="scrollTo">
                                        <span><?php echo esc_html($reviewCount) ?> Review (s)</span>
                                    </a>
                                </div>

                                <div class="product-des">
                                    <p>
                                        <?php echo esc_html($product_description) ?>
                                    </p>
                                </div>

                                <div class="row mt-20">
                                    <div class="col-12">
                                        <div class="table-listing qty">
                                            <label>Qty:</label>
                                            <div class="fill-input">
                                                <button type="button" id="sub" class="sub cou-sub">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input type="number" id="1" class="input-text qty" value="1" min="1" max="3" />
                                                <button type="button" id="add" class="add cou-sub">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="table-listing qty">
                                            <label>Size:</label>
                                            <div class="fill-input">
                                                <select class="selectpicker full">
                                                    <option selected="selected" value="#">8</option>
                                                    <option value="#">7</option>
                                                    <option value="#">6</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="table-listing qty">
                                            <label>Color:</label>
                                            <div class="fill-input">
                                                <select class="selectpicker full">
                                                    <option selected="selected" value="#">Blue</option>
                                                    <option value="#">Green</option>
                                                    <option value="#">Orange</option>
                                                    <option value="#">White</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="product-action">
                                            <ul>
                                                <li>
                                                    <a href="<?php echo esc_url($linkAddToCart) ?>" class="btn btn-color">
                                                        <img src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/images/shop-bag.png') ?>" alt="bag" />
                                                        <span>add to cart</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-detail-tab pt-100" id="product-review">
            <div class="container">
                <div class="product-review">
                    <ul id="tabs" class="review-tab nav nav-tabs" role="tablist">
                        <li role="presentation" class="tab-link">
                            <a href="#description" role="tab" class="active" data-toggle="tab">Description</a>
                        </li>
                    </ul>
                    <div class="product-review-des tab-content">
                        <div role="tabpanel" class="product-review-in product-review-des tab-pane fade active show" id="description">
                            <?php echo esc_html($product_description) ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="top-scrolling">
            <a href="#main" class="scrollTo"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
        </div>
    </div>

    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/js/jquery-3.4.1.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/js/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/js/owl.carousel.min.js') ?>"></script>
    <script src="<?php echo esc_url(MIMI_TEMPLATE_URL . '/Front/landing-page/mimi-landing-page-style-6/assets/js/custom.js') ?>"></script>

    <script>
        $(document).ready(function() {
            //If your <ul> has the id "glasscase"
            $("#glasscase").glassCase({
                thumbsPosition: "bottom",
                widthDisplayPerc: 100,
                isDownloadEnabled: false,
            });
        });
    </script>

</body>

</html>