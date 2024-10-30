<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
?>

<div class="wrap">
    <div class="mimi-flex">
        <div class="mimi-mt-[-14px]">

            <div class="mimi-h-32 mimi-pr-6">
                <img class="mimi-h-full mimi-bg-cover mimi-max-w-full"
                    src="<?php echo esc_url(MIMI_ASSETS . '/images/mimi-logo-slogan.png'); ?>">
            </div>

            <button id="mimi-shortcode-create-new"
                class="mimi-h-[30px] mimi-ml-2.5 mimi-mt-0.5 mimi-bg-[#fe9300] !mimi-text-white mimi-rounded-[3px] mimi-pr-4 mimi-border-none hover:mimi-opacity-80 mimi-cursor-pointer">
                <i class="fas fa-search mimi-ml-[15px] mimi-mr-[5px]"></i>
                <span class="mimi-text-[10px]">
                    <?php esc_html_e("Create new search form", 'mimi') ?>
                </span>
            </button>

            <ul class="mimi-ml-[7px] mimi-mr-[5px]" id="mimi-search-forms-list">
                <!-- <li id="mimi-search-form-item" data-value="" class="mimi-border-0 mimi-border-solid mimi-border-l-[3px] mimi-border-[#D9D9D9] mimi-border-l-transparent mimi-flex mimi-cursor-pointer mimi-justify-between mimi-items-center mimi-px-[7px] mimi-pr-0 mimi-border-b-2 mimi-mb-0 mimi-h-[58px]">
                    <div>
                        <div class="mimi-text-[15px] mimi-font-semibold">
                            a
                        </div>

                        <div class="mimi-text-[11px] mimi-font-normal mimi-text-mimiColor1">
                            [mimi-search-form id="705"]
                        </div>
                    </div>
                </li> -->
            </ul>
        </div>

        <div class="mimi-flex-1 mimi-bg-white mimi-mt-[25px] mimi-rounded">
            <div class="mimi-p-6 mimi-pt-3 mimi-pr-8">

                <div class="mimi-flex">
                    <div class="mimi-border-solid mimi-border-0 mimi-border-b-[3px] mimi-border-[#FE9300] mimi-pb-2">
                        <i
                            class="fas fa-search mimi-text-2xl mimi-text-[#FE9300] mimi-text-center mimi-rounded-sm mimi-py-2.5 mimi-bg-[#FFDEB1] mimi-w-[45px] mimi-leading-none"></i>
                    </div>
                    <div
                        class="mimi-text-xl mimi-font-bold mimi-pb-1 mimi-flex mimi-items-center mimi-w-full mimi-border-solid mimi-border-0 mimi-border-b-[3px] mimi-border-[#D9D9D9]">
                        <span class="mimi-ml-3">
                            <?php esc_html_e("Search form", 'mimi') ?>
                        </span>
                    </div>
                </div>

                <div>
                    <div id="mimi-search-form-main" style="display: none" data-value=""
                        class="mimi-h-full mimi-mt-6 mimi-border mimi-border-[#FE9300] mimi-flex mimi-flex-col mimi-border-solid mimi-relative"
                        style="min-height: 450px;">

                        <div class="mimi-m-6 mimi-mt-3.5 mimi-mr-9 mimi-grid mimi-grid-cols-2 mimi-gap-4">
                            <div class="mimi-w-full">
                                <div class="mimi-text-[15px] mimi-font-semibold">
                                    <?php esc_html_e("Form name", 'mimi') ?>
                                </div>
                                <div class="mimi-h-[45px] mimi-mt-3">
                                    <input id="mimi-form-name-input"
                                        class="mimi-pl-3 mimi-h-full mimi-col-span-1 mimi-w-full mimi-border mimi-border-solid !mimi-border-[#D9D9D9] focus:!mimi-shadow-none focus:!mimi-outline-none"
                                        type="text" placeholder="<?php esc_attr_e('Enter form name', 'mimi') ?>"
                                        value="">
                                </div>
                            </div>

                            <div class="mimi-w-full">
                                <div class="mimi-text-[15px] mimi-font-semibold">
                                    <?php esc_html_e("Shortcode", 'mimi') ?>
                                </div>
                                <div class="mimi-h-[45px] mimi-mt-3 mimi-flex mimi-gap-4">

                                    <input id="mimi-shortcode-input"
                                        class="mimi-h-full mimi-col-span-1 mimi-w-full mimi-border mimi-border-solid !mimi-border-[#D9D9D9] focus:!mimi-shadow-none focus:!mimi-outline-none"
                                        type="text" value="" readonly="">

                                    <button id="mimi-copy-search-form-btn" style="display: none"
                                        class="hover:mimi-opacity-80 mimi-border-0 mimi-cursor-pointer mimi-bg-[#fe9300] !mimi-text-white mimi-text-sm mimi-rounded-[3px] mimi-h-full mimi-px-4">
                                        <?php esc_html_e('Copy', 'mimi') ?>
                                    </button>

                                </div>
                            </div>
                        </div>

                        <div class="mimi-m-6 mimi-mb-0 mimi-text-[15px] mimi-font-semibold">
                            <?php esc_html_e("Search scope", 'mimi') ?>
                        </div>
                        <div class="mimi-mx-6 mimi-my-4 mimi-mr-9 mimi-flex mimi-items-center mimi-justify-between">
                            <div>
                                <div class="mimi-text-[15px] mimi-mt-1">
                                    <?php esc_html_e("Pages", 'mimi') ?>
                                </div>
                            </div>

                            <div class="mimi-flex mimi-items-center">
                                <label class="mimi-connect-label mimi-w-[52px] mimi-h-[26px] mimi-block mimi-relative">
                                    <input type="checkbox" class="mimi-opacity-0" name=""
                                        id="mimi-pages-search-scope-checkbox">
                                    <span
                                        class="mimi-connect mimi-flex mimi-items-center mimi-absolute mimi-inset-0 mimi-border-4 mimi-border-solid mimi-border-[#9D9DA0] mimi-rounded-[34px]">
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="mimi-mx-6 mimi-my-4 mimi-mr-9 mimi-flex mimi-items-center mimi-justify-between">
                            <div>
                                <div class="mimi-text-[15px] mimi-mt-1">
                                    <?php esc_html_e("Posts", 'mimi') ?>
                                </div>
                            </div>
                            <div class="mimi-flex mimi-items-center">
                                <label class="mimi-connect-label mimi-w-[52px] mimi-h-[26px] mimi-block mimi-relative">
                                    <input type="checkbox" class="mimi-opacity-0" name=""
                                        id="mimi-posts-search-scope-checkbox">
                                    <span
                                        class="mimi-connect mimi-flex mimi-items-center mimi-absolute mimi-inset-0 mimi-border-4 mimi-border-solid mimi-border-[#9D9DA0] mimi-rounded-[34px]">
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="mimi-mx-6 mimi-my-4 mimi-mr-9 mimi-flex mimi-items-center mimi-justify-between">
                            <div>
                                <div class="mimi-text-[15px] mimi-mt-1">
                                    <?php esc_html_e("Products", 'mimi') ?>
                                </div>
                            </div>
                            <div class="mimi-flex mimi-items-center">
                                <label class="mimi-connect-label mimi-w-[52px] mimi-h-[26px] mimi-block mimi-relative">
                                    <input type="checkbox" class="mimi-opacity-0"
                                        id="mimi-products-search-scope-checkbox" name="">
                                    <span
                                        class="mimi-connect mimi-flex mimi-items-center mimi-absolute mimi-inset-0 mimi-border-4 mimi-border-solid mimi-border-[#9D9DA0] mimi-rounded-[34px]">
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="mimi-mt-auto mimi-ml-auto mimi-mr-9 mimi-mb-7">

                            <button id="mimi-delete-search-form-btn" style="display: none" name=""
                                class="mimi-cursor-pointer hover:mimi-opacity-80 mimi-text-[#FE9300] mimi-bg-white mimi-border mimi-border-solid mimi-border-[#FE9300] mimi-text-[10px] mimi-rounded-[3px] mimi-h-[30px] mimi-px-2.5 mimi-mr-2">
                                <div class="mimi-font-bold">
                                    <?php esc_html_e("Delete form", 'mimi') ?>
                                </div>
                            </button>

                            <button id="mimi-save-search-form-btn" name=""
                                class="mimi-cursor-pointer mimi-border-0 hover:mimi-opacity-80 mimi-bg-[#fe9300] !mimi-text-white mimi-text-[10px] mimi-rounded-[3px] mimi-h-[30px] mimi-px-2.5 ">
                                <div class="">
                                    <?php esc_html_e("Save settings", 'mimi') ?>
                                </div>
                            </button>

                            <div class="mimi-success-message">Search form setting succesfully!</div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>