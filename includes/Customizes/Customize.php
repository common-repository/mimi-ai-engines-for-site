<?php

namespace VietDevelopers\MiMi\Customizes;

use WP_Customize_Manager;
use VietDevelopers\MiMi\Common\CustomizeKeys;

/**
 * Customize styles for search box, live results, chat box, search results page
 * 
 * @since 1.0.0
 */
class Customize
{
    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('customize_register', array($this, 'custom_theme_customize_register'));
    }

    /**
     * Register custom theme customizer settings and controls
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    public function custom_theme_customize_register($wp_customize)
    {
        $this->add_theme_and_styles_panel($wp_customize);
        SearchBoxSection::add_section($wp_customize);
        LiveResultsSection::add_section($wp_customize);
        SearchResultsPageSection::add_section($wp_customize);
        ChatBoxSection::add_section($wp_customize);

        if (class_exists('WooCommerce')) {
            ProductRecommendationsSection::add_section($wp_customize);
        }
        // Thêm các section và setting khác tùy theo nhu cầu của bạn
    }

    /**
     * Add theme and styles panel
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private function add_theme_and_styles_panel($wp_customize)
    {
        // Thêm panel mới
        $wp_customize->add_panel(CustomizeKeys::MIMI_SETTINGS_PANEL, array(
            'title'    => __('MiMi Settings', 'mimi'),
            'priority' => 200, // Độ ưu tiên của panel
        ));
    }
}
