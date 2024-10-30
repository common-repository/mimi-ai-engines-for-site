<?php

namespace VietDevelopers\MiMi\Ajax\Admin;

use VietDevelopers\MiMi\Traits\InputSanitizer;
use VietDevelopers\MiMi\Common\SearchPostTypeKeys;

/**
 * Ajax generator class.
 * 
 * Ensure admin ajax registration
 * 
 * @since 1.0.0
 */
class SearchFormsPageAjax
{
    use InputSanitizer;

    /**
     * Constructor.
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('wp_ajax_mimi_get_search_form_posts_ajax_action', array($this, 'get_search_form_posts_ajax_callback'));
        add_action('wp_ajax_mimi_save_search_form_ajax_action', array($this, 'save_search_form_ajax_callback'));
        add_action('wp_ajax_mimi_delete_search_form_ajax_action', array($this, 'delete_search_form_ajax_callback'));
    }

    /**
     * Create/Update search form ajax
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function save_search_form_ajax_callback()
    {
        // Kiểm tra nonce
        check_ajax_referer('mimi_admin_nonce', 'nonce');

        // Kiểm tra quyền của người dùng
        if (!current_user_can('manage_options')) {
            $json = array(
                "isSuccess"     => false,
            );

            echo wp_json_encode($json);
            wp_die();
        }

        if (isset($_POST['formName']) && isset($_POST['pagesSearchScope']) && isset($_POST['postsSearchScope']) && isset($_POST['productsSearchScope'])) {
            $formName = $this->sanitize($_POST['formName'], 'text');

            $pagesSearchScope = $this->sanitize($_POST['pagesSearchScope'], 'boolean');
            $postsSearchScope = $this->sanitize($_POST['postsSearchScope'], 'boolean');
            $productsSearchScope = $this->sanitize($_POST['productsSearchScope'], 'boolean');

            $search_scope = array(
                "mimi_pages" => $pagesSearchScope,
                "mimi_posts" => $postsSearchScope,
                "mimi_products" => $productsSearchScope,
            );

            if (!isset($_POST['id'])) {
                $post_id = wp_insert_post(
                    array(
                        'post_title'    => $formName,
                        'post_type'     => SearchPostTypeKeys::MIMI_SEARCH_FORM_POST_TYPE,
                        'post_status'   => 'publish',
                    )
                );

                add_post_meta($post_id, SearchPostTypeKeys::MIMI_SEARCH_SCOPE_POST_META, $search_scope);

                $json = array(
                    "isSuccess"     => true,
                    "message"       => "Create successfully",
                    "data"          => $post_id,
                );

                echo wp_json_encode($json);
                wp_die();
            } else {
                $post_id = $this->sanitize($_POST['id'], 'number');

                $post_data = array(
                    'ID'            => $post_id,
                    'post_title'    => $formName,
                );

                wp_update_post($post_data);

                update_post_meta($post_id, SearchPostTypeKeys::MIMI_SEARCH_SCOPE_POST_META, $search_scope);

                $json = array(
                    "isSuccess"     => true,
                    "message"       => "Updated successfully",
                    "data"          => $post_id,
                );

                echo wp_json_encode($json);
                wp_die();
            }
        } else {
            wp_die();
        }
    }

    /**
     * Get search form posts ajax
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function get_search_form_posts_ajax_callback()
    {
        // Kiểm tra nonce
        check_ajax_referer('mimi_admin_nonce', 'nonce');

        // Kiểm tra quyền của người dùng
        if (!current_user_can('manage_options')) {
            $json = array(
                "isSuccess"     => false,
            );

            echo wp_json_encode($json);
            wp_die();
        }

        $data = array();

        $posts = get_posts(
            array(
                'post_type' => 'mimi-search-form',
                'posts_per_page' => -1,
            )
        );

        foreach ($posts as $post) {
            $id = $post->ID;
            $title = $post->post_title;
            $search_scope = get_post_meta($id, 'mimi_search_scope', true);

            $data[] = array(
                "id"            => $id,
                "shortcode"     => '[mimi-search-form id="' . $id . '"]',
                "title"         => $title,
                "searchScope"   => $search_scope
            );
        }

        $json = array(
            "isSuccess"     => true,
            "data"          => $data,
        );

        echo wp_json_encode($json);
        wp_die();
    }

    /**
     * Delete search form post ajax
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function delete_search_form_ajax_callback()
    {
        // Kiểm tra nonce
        check_ajax_referer('mimi_admin_nonce', 'nonce');

        // Kiểm tra quyền của người dùng
        if (!current_user_can('manage_options')) {
            $json = array(
                "isSuccess"     => false,
            );

            echo wp_json_encode($json);
            wp_die();
        }

        if (isset($_POST['id'])) {
            $id = $this->sanitize($_POST['id'], 'number');

            if (!empty($id) || get_post_status($id)) {
                // Delete the post
                wp_delete_post($id, true);

                $json = array(
                    "isSuccess"     => true,
                );

                echo wp_json_encode($json);
            }

            wp_die();
        } else {
            wp_die();
        }
    }
}
