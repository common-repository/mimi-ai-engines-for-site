<?php

namespace VietDevelopers\MiMi\CustomPostTypes;

use VietDevelopers\MiMi\Common\SearchPostTypeKeys;

/**
 * Custom post type related hooks.
 *
 * @since 1.0.0
 */
class Hooks
{
    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->register_search_form_custom_post_type();
    }

    /**
     * Register search_form custom post type
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function register_search_form_custom_post_type()
    {
        /*
        * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
        */
        $label = array(
            "name" => __("MiMi Search forms", 'mimi'), //Tên post type dạng số nhiều
            "singular_name" => __("MiMi Search form", 'mimi'), //Tên post type dạng số ít
        );

        /*
        * Biến $args là những tham số quan trọng trong Post Type
        */
        $args = array(
            "labels" => $label, //Gọi các label trong biến $label ở trên
            // "description" => "Post type đăng sản phẩm", //Mô tả của post type
            // "supports" => array(
            //     "title",
            //     "trackbacks",
            //     "custom-fields"
            // ), //Các tính năng được hỗ trợ trong post type

            // "public" => true, //Kích hoạt post type
            // "show_ui" => true, //Hiển thị khung quản trị như Post/Page
            // "show_in_menu" => $this->plugin_name, //Hiển thị trên Admin Menu (tay trái)
        );

        register_post_type(SearchPostTypeKeys::MIMI_SEARCH_FORM_POST_TYPE, $args); //Tạo post type với slug tên là mimi-search-form và các tham số trong biến $args ở trên

    }
}
