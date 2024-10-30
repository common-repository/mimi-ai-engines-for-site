<?php

namespace VietDevelopers\MiMi\Customizes;

use WP_Customize_Manager;
use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Customizes\CustomizeControl\SelectImageControl;
use WP_Customize_Color_Control;

/**
 * Class SearchBoxSection
 * @package VietDevelopers\MiMi\Customizes
 */
class SearchBoxSection
{
    /**
     * Add search box section in theme and styles panel
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    public static function add_section($wp_customize)
    {
        // Add section to panel
        $wp_customize->add_section(CustomizeKeys::MIMI_SEARCH_BOX_SECTION, array(
            'title'       => __('Search Box', 'mimi'),
            'panel'       => CustomizeKeys::MIMI_SETTINGS_PANEL, // ID của panel mà section này thuộc về
        ));

        self::add_search_box_style_setting($wp_customize);
        self::add_search_box_color_setting($wp_customize);
        self::add_search_history_visibility_setting($wp_customize);
        self::add_top_search_keyword_visibility_setting($wp_customize);
    }

    /**
     * Add search box style setting in search box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_box_style_setting($wp_customize)
    {
        $plugin_images_dir = plugin_dir_path(MIMI_FILE) . 'assets/images/search-box-styles/';
        $plugin_images_uri = MIMI_ASSETS . '/images/search-box-styles/';

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
            CustomizeKeys::MIMI_SEARCH_BOX_STYLE_SETTING,
            array(
                'default'           => 'mimi-search-box-style-1',
                'sanitize_callback' => 'sanitize_key', // Sử dụng sanitize callback để chỉ chấp nhận một trong các giá trị được xác định
            )
        );

        // Thêm control cho setting trong section con
        $wp_customize->add_control(
            new SelectImageControl(
                $wp_customize,
                CustomizeKeys::MIMI_SEARCH_BOX_STYLE_SETTING,
                array(
                    'section' =>  CustomizeKeys::MIMI_SEARCH_BOX_SECTION,
                    'label' => __('Search box style', 'mimi'),
                    'choices' => $image_choices,
                    'settings' => CustomizeKeys::MIMI_SEARCH_BOX_STYLE_SETTING,
                )
            )
        );
    }

    /**
     * Add search box setting in search box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_box_color_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_BOX_COLOR_SETTING,
            array(
                'default'           => '#FE9300',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            CustomizeKeys::MIMI_SEARCH_BOX_COLOR_SETTING,
            array(
                'label'    => __('Color', 'mimi'),
                'section'  => CustomizeKeys::MIMI_SEARCH_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_BOX_COLOR_SETTING,
            )
        ));
    }

    /**
     * Add search history visibility setting in search box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_history_visibility_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_BOX_SEARCH_HISTORY_VISIBILITY_SETTING,
            array(
                'default'           => 0,
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_SEARCH_BOX_SEARCH_HISTORY_VISIBILITY_SETTING,
            array(
                'label'    => __('User\'s search history visibility on Search box', 'mimi'),
                'section'  => CustomizeKeys::MIMI_SEARCH_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_BOX_SEARCH_HISTORY_VISIBILITY_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }

    /**
     * Add top search keyword visibility setting in search box section
     * 
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_top_search_keyword_visibility_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_BOX_TOP_SEARCH_KEYWORD_VISIBILITY_SETTING,
            array(
                'default'   => 0,
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_SEARCH_BOX_TOP_SEARCH_KEYWORD_VISIBILITY_SETTING,
            array(
                'label'    => __('Top search keyword visibility on Search box', 'mimi'),
                'section'  => CustomizeKeys::MIMI_SEARCH_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_BOX_TOP_SEARCH_KEYWORD_VISIBILITY_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }
}
