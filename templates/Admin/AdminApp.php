<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<div class="wrap">
    <div id="app" data-value="wordpress">
        <h2>
            <?php esc_html_e('Loading', 'mimi'); ?>...
        </h2>
    </div>
</div>

<style>
    .wrap {
        margin-top: 0;
        position: relative;
        height: 100%;
        background-color: #fff;
        margin: 0 !important;
    }

    #wpwrap {
        height: 100%;
    }

    #wpbody {
        height: 100%;
    }

    #wpbody-content {
        height: 100%;
        padding-bottom: 0;
        /* background-color: #fff; */
    }

    #wpcontent {
        padding-left: 0;
    }

    #wpfooter {
        display: none;
    }
</style>