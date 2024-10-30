<?php

namespace VietDevelopers\MiMi\LandingPage;

/**
 * Landing page class
 */
class Manager
{
    /**
     * Constructor
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        add_filter('template_include', array($this, 'load_custom_landing_page_template'));
        add_action('template_redirect', array($this, 'add_data_template_to_template'));
    }

    // Hàm xác định đường dẫn template từ plugin
    function load_custom_landing_page_template($template)
    {
        global $post;

        if ($post) {
            $template_name = get_post_meta($post->ID, '_wp_page_template', true);
            $dataTemplate = get_post_meta($post->ID, 'mimi_data_template', true);
            if ($template_name && $dataTemplate) {
                $template_path = MIMI_TEMPLATE_PATH . '/Front/' . $template_name;
                $template = $template_path;
            }
        }

        return $template;
    }

    // Hàm truyền biến vào template
    function add_data_template_to_template()
    {
        if (is_page()) {
            global $post;
            $dataTemplate = get_post_meta($post->ID, 'mimi_data_template', true);
            if ($dataTemplate) {
                set_query_var('mimi_data_template', $dataTemplate);
            }
        }
    }
}
