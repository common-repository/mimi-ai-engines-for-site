<?php

namespace VietDevelopers\MiMi\DataExport;

use WP_Query;

/**
 * Class WP Post Export.
 *
 * @since 1.0.0
 */
class WPPostsExport
{
    /**
     * Export wp posts data .
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function export_WPPostsData()
    {
        return self::get_posts_data();
    }

    /**
     * Get posts, pages data
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_posts_data()
    {
        $posts = array();

        // Query to get posts data (customize as needed)
        $post_query = new WP_Query(array(
            'post_type' => array('post', 'page'),
            'post_status' => array('publish'),
            'posts_per_page' => -1,
        ));

        while ($post_query->have_posts()) {
            $post_query->the_post();

            $post_data = array(
                "type" => get_post_type(),
                "id" => get_the_ID(),
                "url" => get_permalink(),
                "title" => get_the_title(),
                "slug" => get_post_field('post_name'),
                "status" => get_post_status(),
                "thumbnailURL" => get_the_post_thumbnail_url() != false ? get_the_post_thumbnail_url() : "",
                "description" => get_the_excerpt(),
                "content" => get_the_content()
            );

            $posts[] = $post_data;
        }

        wp_reset_postdata();

        return $posts;
    }
}
