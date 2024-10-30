<?php

namespace VietDevelopers\MiMi\Customizes;

use WP_Customize_Manager;
use VietDevelopers\MiMi\Common\CustomizeKeys;
use WP_Customize_Image_Control;

/**
 * Class SearchResultsPageSection
 * @package VietDevelopers\MiMi\Customizes
 */
class SearchResultsPageSection
{
    /**
     * Add search results page section in theme and styles panel
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    public static function add_section($wp_customize)
    {
        // Add section to panel
        $wp_customize->add_section(CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SECTION, array(
            'title'       => __('Search Results Page', 'mimi'),
            'panel'       => CustomizeKeys::MIMI_SETTINGS_PANEL, // ID của panel mà section này thuộc về
        ));

        self::add_search_results_page_filter_on_search_results_page_setting($wp_customize);
        self::add_search_results_page_sort_on_search_results_page_setting($wp_customize);
        self::add_search_results_page_number_of_results_per_page_setting($wp_customize);
        self::add_search_results_page_default_message_for_no_results_found_setting($wp_customize);
        self::add_search_results_page_no_results_found_default_image_setting($wp_customize);
    }

    /**
     * Add filter on search results page setting in search results page section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_results_page_filter_on_search_results_page_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_FILTER_ON_SEARCH_RESULTS_PAGE_SETTING,
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_FILTER_ON_SEARCH_RESULTS_PAGE_SETTING,
            array(
                'label'    => __('Filters on Search results page', 'mimi'),
                'section'  => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_FILTER_ON_SEARCH_RESULTS_PAGE_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }

    /**
     * Add sort on search results page setting in search results page section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_results_page_sort_on_search_results_page_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SORT_ON_SEARCH_RESULTS_PAGE_SETTING,
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SORT_ON_SEARCH_RESULTS_PAGE_SETTING,
            array(
                'label'    => __('Sort on Search results page', 'mimi'),
                'section'  => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SORT_ON_SEARCH_RESULTS_PAGE_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }

    /**
     * Add number of results per page setting in search results page section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_results_page_number_of_results_per_page_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NUMBER_OF_SEARCH_RESULTS_PAGE_SETTING,
            array(
                'default'           => 10,
                'sanitize_callback' => 'absint',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NUMBER_OF_SEARCH_RESULTS_PAGE_SETTING,
            array(
                'type' => 'number',
                'label' => __('Number of results per page (Pagination)', 'mimi'),
                'section' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NUMBER_OF_SEARCH_RESULTS_PAGE_SETTING,
                'input_attrs' => array(
                    'min' => 1,
                    'max' => 50,
                    'step' => 1,
                ),
            )
        );
    }

    /**
     * Add default message for "no results found" setting in search results page section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_results_page_default_message_for_no_results_found_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING,
            array(
                'default'           => 'Sorry, there is nothing that matches your search!',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING,
            array(
                'label'    => __('Default message for "No results found"', 'mimi'),
                'section'  => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SECTION,
                'settings' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING,
                'type'     => 'text', // Loại control, ví dụ: text, color, image, vv.
            )
        );
    }

    /**
     * Add "no results found" default image setting in search results page section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_search_results_page_no_results_found_default_image_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING,
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING,
                array(
                    'label' => __('"No results found" default image', 'mimi'),
                    'section' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_SECTION,
                    'settings' => CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING,
                )
            )
        );
    }
}
