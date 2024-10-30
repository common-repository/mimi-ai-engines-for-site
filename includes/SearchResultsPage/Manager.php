<?php

namespace VietDevelopers\MiMi\SearchResultsPage;

/**
 * Search results page class
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
        add_filter('template_include', array($this, 'custom_search_results_page_template'));
    }

    public function custom_search_results_page_template($template)
    {
        // Kiểm tra nếu đang ở trang tìm kiếm
        if (is_search()) {

            $template_path = MIMI_TEMPLATE_PATH . '/Front/SearchResultsPageApp.php';

            // Thay đổi template thành đường dẫn tới file custom-search.php trong thư mục plugin
            $template = $template_path;
        }

        return $template;
    }
}
