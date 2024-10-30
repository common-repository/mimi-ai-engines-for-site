<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<style>
    html.wp-toolbar {
        padding-top: 0 !important;
    }

    /* Ẩn wpadminbar */
    #wpadminbar {
        display: none !important;
    }

    #wpwrap {
        background-color: white !important;
    }

    #wpwrap #adminmenumain {
        display: none !important;
    }

    #wpwrap #wpfooter {
        display: none !important;
    }

    #wpwrap #wpcontent {
        margin-left: 0 !important;
    }
</style>


<div class="wrap mimi-fixed mimi-inset-5 mimi-top-0 mimi-right-0 mimi-bg-white">
    <div class="mimi-absolute mimi-inset-0 mimi-top-2.5">

        <div class="mimi-flex mimi-mb-5">
            <div class="mimi-border-solid mimi-border-0 mimi-border-b-[3px] mimi-border-[#FE9300]">
                <img class="mimi-pb-1" src="<?php echo esc_url(MIMI_ASSETS . '/images/logomimi1.png'); ?>">
            </div>
            <div
                class="mimi-text-xl mimi-font-bold mimi-pb-1 mimi-flex mimi-items-center mimi-w-full mimi-border-solid mimi-border-0 mimi-border-b-[3px] mimi-border-[#D9D9D9]">
                <span class="mimi-ml-3">
                    <?php esc_html_e("WELCOME TO MIMI", 'mimi') ?>
                </span>
            </div>
        </div>

        <div
            class="mimi-border-solid mimi-border mimi-border-[#FE9300] mimi-mr-5 mimi-absolute mimi-inset-0 mimi-top-[82px]">
            <div class="mimi-m-5 mimi-mt-0 mimi-flex mimi-flex-col mimi-h-full mimi-justify-between">
                <div>
                    <div class="mimi-flex mimi-justify-center">
                        <img class="mimi-w-[15%]" alt="Vue logo"
                            src="<?php echo esc_url(MIMI_ASSETS . '/images/mimi-logo-slogan.png'); ?>">
                    </div>

                    <p id="mimi-text-notification"
                        class="mimi-text-base xl:mimi-text-xl 2xl:mimi-text-[25px] mimi-font-medium mimi-italic mimi-m-0 mimi-text-center">
                        <?php esc_html_e("Please wait a few minutes for MiMi's engine to analyze your site the AI models", 'mimi') ?>
                    </p>

                    <div
                        class="mimi-mx-auto mimi-mt-[40px] 2xl:mimi-mt-[62px] mimi-w-[75%] mimi-bg-gray-200 mimi-rounded-full mimi-dark:bg-gray-700 mimi-relative">
                        <div class="mimi-bg-[#fe9300] mimi-w-0 mimi-h-2.5 mimi-text-xs mimi-font-medium mimi-text-blue-100 mimi-text-center mimi-leading-loose mimi-rounded-full mimi-relative mimi-flex mimi-items-center"
                            id="mimi-progress-bar"></div>
                        <div id="mimi-percent-progress-bar"
                            class="mimi-absolute mimi-left-[-1%] mimi-flex mimi-items-center mimi-justify-center mimi-flex-col-reverse mimi-mt-[-30px] 2xl:mimi-mt-[-40px] mimi-gap-3 mimi-top-[-7px]">
                            <div
                                class="2xl:mimi-w-[15px] 2xl:mimi-h-[15px] mimi-h-2.5 mimi-w-2.5 -mimi-top-1 mimi-rounded-full mimi-bg-[#FFDEB1] mimi-border-[#FE9300] mimi-border-solid mimi-border-[5px] 2xl:mimi-top-[-8px]">
                            </div>
                            <div id="mimi-percent-progress-bar-content"
                                class="2xl:mimi-w-[31px] mimi-w-6 2xl:mimi-h-[23px] mimi-h-4 mimi-rounded mimi-bg-[#fe9300] mimi-p-0.5 2xl:mimi-text-xs mimi-text-[9px] mimi-font-semi-bold mimi-text-white mimi-right-2/4 2xl:-mimi-top-[46px] -mimi-top-[36px] mimi-flex mimi-items-center mimi-justify-center mimi-leading-none after:mimi-content-[''] after:mimi-absolute after:mimi-border-solid after:mimi-border-transparent after:mimi-border-y-[10px] after:mimi-border-x-[6px] after:mimi-rounded-[5px] after:mimi-border-t-[#fe9300] 2xl:after:mimi-top-6 after:mimi-top-4 after:mimi-border-5">
                                0%
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mimi-flex mimi-justify-center mimi-flex-1 mimi-items-center">
                    <button id="mimi-start-using-btn"
                        class="mimi-cursor-pointer hover:mimi-opacity-85 mimi-px-3.5 xl:mimi-h-[40px] 2xl:mimi-h-[50px] mimi-leading-none mimi-h-9 mimi-rounded-[3px] mimi-text-white mimi-flex mimi-items-center mimi-border-0 2xl:mimi-text-xl mimi-text-base mimi-font-semibold"
                        style="background-color: rgb(157, 157, 160);">
                        <?php esc_html_e("Start using MiMi", 'mimi') ?>
                        <div
                            class="2xl:mimi-w-5 mimi-w-3.5 2xl:mimi-h-5 mimi-h-3.5 mimi-ml-3 mimi-border mimi-border-solid mimi-rounded mimi-border-white mimi-flex mimi-items-center mimi-justify-center">
                            <i class="mimi-arrow-right mimi-p-0.5 mimi-mr-0.5 2xl:mimi-mr-[3px] 2xl:mimi-p-[3px]"></i>
                        </div>
                    </button>
                </div>

                <div
                    class="mimi-flex mimi-flex-col mimi-flex-[2] mimi-h-full mimi-text-base xl:mimi-text-xl 2xl:mimi-text-[25px]">
                    <p
                        class="mimi-font-semibold mimi-flex mimi-justify-center mimi-m-0 mimi-w-[70%] mimi-text-base xl:mimi-text-xl 2xl:mimi-text-[25px]">
                        <?php esc_html_e("Turn your site smarter with MiMi AI Engines", 'mimi') ?>
                    </p>

                    <div class="mimi-flex mimi-justify-center mimi-h-full">
                        <div class="mimi-flex mimi-justify-evenly mimi-gap-x-[100px]">
                            <ul
                                class="mimi-list-disc mimi-flex mimi-flex-col mimi-ml-5 mimi-p-0 mimi-items-start mimi-italic mimi-justify-evenly">
                                <li class="mimi-mb-2.5">
                                    <?php esc_html_e("Semantic search with NLP", 'mimi') ?>
                                </li>

                                <li class="mimi-mb-2.5">
                                    <?php esc_html_e("Dynamic Pricing ", 'mimi') ?>
                                    <span class="mimi-text-[#FE9300]">
                                        <?php esc_html_e("(coming soon)", 'mimi') ?>
                                    </span>
                                </li>

                                <li class="mimi-mb-2.5">
                                    <?php esc_html_e("Virtual assistant ", 'mimi') ?>
                                    <span class="mimi-text-[#FE9300]">
                                        <?php esc_html_e("(coming soon)", 'mimi') ?>
                                    </span>
                                </li>
                            </ul>

                            <ul
                                class="mimi-list-disc mimi-flex mimi-flex-col mimi-ml-5 mimi-p-0 mimi-items-start mimi-italic mimi-justify-evenly">
                                <li class="mimi-mb-2.5">
                                    <?php esc_html_e("Chatbot", 'mimi') ?>
                                </li>

                                <li class="mimi-mb-2.5">
                                    <?php esc_html_e("Product Recommendations", 'mimi') ?>
                                </li>

                                <li class="mimi-mb-2.5">
                                    <?php esc_html_e("Automated Workflows ", 'mimi') ?>
                                    <span class="mimi-text-[#FE9300]">
                                        <?php esc_html_e("(coming soon)", 'mimi') ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>