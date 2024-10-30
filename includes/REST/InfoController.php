<?php

namespace VietDevelopers\MiMi\REST;

use VietDevelopers\MiMi\Abstracts\RESTController;
use VietDevelopers\MiMi\Common\Keys;

use WP_REST_Server;
use WP_Error;

/**
 * API InfoController class.
 *
 * @since 1.0.0
 */
class InfoController extends RESTController
{
    /**
     * Route base.
     *
     * @var string
     */
    protected $base = 'info';

    /**
     * Register all routes related with carts.
     *
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/chatbox',
            [
                [
                    'methods'   => WP_REST_Server::READABLE,
                    'callback'  => [$this, 'get_info_for_chatbox'],
                    'permission_callback' => [$this, 'check_permission'],
                ]
            ]
        );
    }

    /**
     * check permission
     *
     * @return bool
     */
    public function check_permission(): bool
    {
        // return current_user_can('manage_options');
        return true;
    }

    /**
     * Get info user fot chatbox
     * 
     * @since 1.0.0
     * @return WP_REST_Response Response object on success
     */
    public function get_info_for_chatbox()
    {
        $username = '';

        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();

            // Kiểm tra xem có người dùng nào đang đăng nhập không
            if ($current_user->ID != 0) {
                // Lấy tên người dùng
                $username = $current_user->user_login;
            }
        }


        $site_title = get_bloginfo('name');

        $data = array(
            "username"      => $username,
            "site_title"    => $site_title
        );

        return rest_ensure_response(
            array(
                'isSucccess'    => true,
                'message'       => 'Get info for chatbox sucessfully',
                'data'          => $data
            )
        );
    }
}
