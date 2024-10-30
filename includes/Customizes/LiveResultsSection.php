<?php

namespace VietDevelopers\MiMi\Customizes;

use WP_Customize_Manager;
use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Customizes\CustomizeControl\SelectImageControl;
use WP_Customize_Color_Control;
use WP_Customize_Image_Control;

/**
 * Class LiveResultsSection
 * @package VietDevelopers\MiMi\Customizes
 */
class LiveResultsSection
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
        $wp_customize->add_section(CustomizeKeys::MIMI_LIVE_RESULTS_SECTION, array(
            'title'       => __('Live Results', 'mimi'),
            'panel'       => CustomizeKeys::MIMI_SETTINGS_PANEL, // ID của panel mà section này thuộc về
        ));

        self::add_live_results_style_setting($wp_customize);
        self::add_live_results_color_setting($wp_customize);
        self::add_live_results_default_message_for_no_results_found_setting($wp_customize);
        self::add_live_results_no_results_found_default_image_setting($wp_customize);
    }

    /**
     * Add live results style setting in live results section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_live_results_style_setting($wp_customize)
    {
        $plugin_images_dir = plugin_dir_path(MIMI_FILE) . 'assets/images/live-results-styles/';
        $plugin_images_uri = MIMI_ASSETS . '/images/live-results-styles/';

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
            CustomizeKeys::MIMI_LIVE_RESULTS_STYLE_SETTING,
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_key', // Sử dụng sanitize callback để chỉ chấp nhận một trong các giá trị được xác định
            )
        );

        // Thêm control cho setting trong section con
        $wp_customize->add_control(
            new SelectImageControl(
                $wp_customize,
                CustomizeKeys::MIMI_LIVE_RESULTS_STYLE_SETTING,
                array(
                    'section' =>  CustomizeKeys::MIMI_LIVE_RESULTS_SECTION,
                    'label' => __('Live results style', 'mimi'),
                    'choices' => $image_choices,
                    'settings' => CustomizeKeys::MIMI_LIVE_RESULTS_STYLE_SETTING,
                )
            )
        );
    }

    /**
     * Add live results setting in live results section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_live_results_color_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_LIVE_RESULTS_COLOR_SETTING,
            array(
                'default'           => '#FE9300',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            CustomizeKeys::MIMI_LIVE_RESULTS_COLOR_SETTING,
            array(
                'label'    => __('Color', 'mimi'),
                'section'  => CustomizeKeys::MIMI_LIVE_RESULTS_SECTION,
                'settings' => CustomizeKeys::MIMI_LIVE_RESULTS_COLOR_SETTING,
            )
        ));
    }

    /**
     * Add default message for "no results found" setting in live results section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_live_results_default_message_for_no_results_found_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_LIVE_RESULTS_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING,
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_LIVE_RESULTS_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING,
            array(
                'label'    => __('Default message for "No results found"', 'mimi'),
                'section'  => CustomizeKeys::MIMI_LIVE_RESULTS_SECTION,
                'settings' => CustomizeKeys::MIMI_LIVE_RESULTS_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING,
                'type'     => 'text', // Loại control, ví dụ: text, color, image, vv.
            )
        );
    }

    /**
     * Add "no results found" default image setting in live results section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_live_results_no_results_found_default_image_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_LIVE_RESULTS_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING,
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                CustomizeKeys::MIMI_LIVE_RESULTS_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING,
                array(
                    'label' => __('"No results found" default image', 'mimi'),
                    'section' => CustomizeKeys::MIMI_LIVE_RESULTS_SECTION,
                    'settings' => CustomizeKeys::MIMI_LIVE_RESULTS_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING,
                )
            )
        );
    }
}
