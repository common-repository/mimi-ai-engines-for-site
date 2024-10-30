<?php

namespace VietDevelopers\MiMi\Utils;

/**
 * Class Remove Background API
 * 
 * @since 1.1.0
 */
class RemoveBackgroundAPI
{
    /**
     * Remove background with api remove bg
     * 
     * @since 1.1.0
     * 
     * @return string 
     */
    public static function do_remove_bg($image_url, $image_name)
    {
        // API Key của Remove.bg
        $api_key_remove_bg = 'G14q9NYzz3vFzpnMRWQvAWNz';
        // URL API của Remove.bg
        $api_url_remove_bg = 'https://api.remove.bg/v1.0/removebg';

        $data_body = array(
            'image_url' => $image_url,
            'size' => 'auto'
        );

        $args = array(
            'headers' => array(
                'X-Api-Key' => $api_key_remove_bg
            ),
            'body' => $data_body
        );

        $response = wp_remote_post($api_url_remove_bg, $args);

        if (is_wp_error($response)) {
            // Kiểm tra lỗi
            return $image_url;
        } else {
            // Lấy nội dung phản hồi
            $body = wp_remote_retrieve_body($response);

            // Lưu ảnh vào thư mục uploads
            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['path'] . '/removal-' . sanitize_file_name($image_name) . '.png';
            $file_url = $upload_dir['url'] . '/removal-' . sanitize_file_name($image_name) . '.png';

            // Sử dụng WP_Filesystem để lưu dữ liệu nhị phân vào file
            global $wp_filesystem;

            if (!function_exists('request_filesystem_credentials')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            // Kiểm tra và khởi tạo WP_Filesystem nếu cần thiết
            if (!WP_Filesystem()) {
                request_filesystem_credentials(site_url());
            }

            // Kiểm tra xem đối tượng $wp_filesystem đã sẵn sàng chưa
            if (!$wp_filesystem || !is_object($wp_filesystem)) {
                return $image_url;
            }

            // Lưu dữ liệu vào file
            $wp_filesystem->put_contents($file_path, $body, FS_CHMOD_FILE);

            // Trả về URL của ảnh đã lưu
            return $file_url;
        }
    }
}
