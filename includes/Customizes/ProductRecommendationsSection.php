<?php

namespace VietDevelopers\MiMi\Customizes;

use WP_Customize_Manager;
use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Customizes\CustomizeControl\SelectImageControl;

/**
 * Class ProductRecommendationsSection
 * @package VietDevelopers\MiMi\Customizes
 */
class ProductRecommendationsSection
{
    /**
     * Add live results section in theme and styles panel
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    public static function add_section($wp_customize)
    {
        // Add section to panel
        $wp_customize->add_section(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SECTION,
            array(
                'title'       => __('Product Recommendations', 'mimi'),
                'panel'       => CustomizeKeys::MIMI_SETTINGS_PANEL, // ID của panel mà section này thuộc về
            )
        );

        self::add_product_recommendations_similar_products_setting($wp_customize);
        self::add_product_recommendations_frequently_bought_together_products_setting($wp_customize);
        self::add_product_recommendations_recommendation_style_on_the_detail_product_page_setting($wp_customize);
        self::add_product_recommendations_number_of_product_per_page_setting($wp_customize);
    }

    /**
     * Add similar products setting in product recommendations section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_product_recommendations_similar_products_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SIMILAR_PRODUCTS_SETTING,
            array(
                'default'           => 0,
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SIMILAR_PRODUCTS_SETTING,
            array(
                'label'    => __('Similar products', 'mimi'),
                'section'  => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SECTION,
                'settings' => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SIMILAR_PRODUCTS_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }

    /**
     * Add similar products setting in product recommendations section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_product_recommendations_frequently_bought_together_products_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_FREQUENTLY_BOUGHT_TOGETHER_PRODUCTS_SETTING,
            array(
                'default'           => 0,
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_FREQUENTLY_BOUGHT_TOGETHER_PRODUCTS_SETTING,
            array(
                'label'    => __('Frequently bought together products', 'mimi'),
                'section'  => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SECTION,
                'settings' => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_FREQUENTLY_BOUGHT_TOGETHER_PRODUCTS_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }

    /**
     * Add recommendation style on the detail product page setting in product recommendation section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_product_recommendations_recommendation_style_on_the_detail_product_page_setting($wp_customize)
    {
        $plugin_images_dir = plugin_dir_path(MIMI_FILE) . 'assets/images/product-recommendations-styles/';
        $plugin_images_uri = MIMI_ASSETS . '/images/product-recommendations-styles/';

        // Lấy danh sách các tệp ảnh trong thư mục plugin
        $images = glob($plugin_images_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        // Tạo mảng chứa lựa chọn cho người dùng
        $image_choices = array();

        // Lặp qua các ảnh và thêm vào mảng lựa chọn
        foreach ($images as $image) {
            // Lấy tên tệp ảnh
            $image_name = basename($image);

            // Lấy tên của file ảnh
            $file_name = pathinfo($image, PATHINFO_FILENAME);

            // Thêm vào mảng lựa chọn với key là tên tệp và value là tên tệp ảnh
            $image_choices[$file_name] = $plugin_images_uri . $image_name;
        }

        // Thêm setting mới cho section con
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_RECOMMENDATION_STYLE_ON_THE_DETAIL_PRODUCT_PAGE_SETTING,
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_key', // Sử dụng sanitize callback để chỉ chấp nhận một trong các giá trị được xác định
            )
        );

        // Thêm control cho setting trong section con
        $wp_customize->add_control(
            new SelectImageControl(
                $wp_customize,
                CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_RECOMMENDATION_STYLE_ON_THE_DETAIL_PRODUCT_PAGE_SETTING,
                array(
                    'section' =>  CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SECTION,
                    'label' => __('Recommendation style on the detail product page', 'mimi'),
                    'choices' => $image_choices,
                    'settings' => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_RECOMMENDATION_STYLE_ON_THE_DETAIL_PRODUCT_PAGE_SETTING,
                )
            )
        );
    }

    /**
     * Add number of product per page setting in product recommendations section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_product_recommendations_number_of_product_per_page_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_NUMBER_OF_PRODUCT_PER_ROW_SETTING,
            array(
                'default'           => 3,
                'sanitize_callback' => 'absint',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_NUMBER_OF_PRODUCT_PER_ROW_SETTING,
            array(
                'type' => 'number',
                'label' => __('Number of product per row', 'mimi'),
                'section' => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_SECTION,
                'settings' => CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_NUMBER_OF_PRODUCT_PER_ROW_SETTING,
                'input_attrs' => array(
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                ),
            )
        );
    }
}
