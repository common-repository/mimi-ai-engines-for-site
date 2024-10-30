<?php

namespace VietDevelopers\MiMi\Utils;

use WP_Error;

/**
 * Class MiMi API
 * 
 * @since 1.1.0
 */
class MiMiAPI
{
    /**
     * MiMi API - Khởi tạo site
     * 
     * @since 1.1.0
     * 
     * @param string $email Email của admin
     * @param string $url URL của site
     * @return string Trả về API Key nếu thành công, hoặc error nếu lỗi
     */
    public static function do_init_site($email, $url)
    {
        // URL của API endpoint
        $api_endpoint = MIMI_API_V1 . 'sites';

        // Dữ liệu gửi đi
        $data = array(
            'email' => $email,
            'url'   => $url
        );

        // Tham số cho wp_remote_post
        $args = array(
            'body'    => wp_json_encode($data), // Chuyển mảng thành JSON
            'headers' => array(
                'Content-Type' => 'application/json', // Đặt kiểu dữ liệu là JSON
            ),
        );

        // Gọi API bằng wp_remote_post
        $response = wp_remote_post($api_endpoint, $args);

        // Kiểm tra nếu có lỗi xảy ra
        if (is_wp_error($response)) {
            return 'error';
        }

        // Lấy nội dung từ phản hồi
        $body = wp_remote_retrieve_body($response);

        // Giải mã JSON từ phản hồi
        $data = json_decode($body);

        // Kiểm tra phản hồi từ API
        if (isset($data->isSuccess) && $data->isSuccess == true) {
            return $data->data->apiKey;
        } else {
            return 'error';
        }
    }
}
