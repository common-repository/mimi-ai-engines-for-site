<?php

namespace VietDevelopers\MiMi\Shortcodes;

use VietDevelopers\MiMi\Common\SearchPostTypeKeys;
use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Common\Keys;


/**
 * Shortcodes related hooks.
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
        $this->register_shortcodes();
    }

    /**
     * Register shortcodes
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function register_shortcodes()
    {
        add_shortcode(SearchPostTypeKeys::MIMI_SEARCH_FORM_POST_TYPE, array($this, 'search_form_shortcode'));
    }

    /**
     * Search form shortcode
     * 
     * @since 1.0.0
     * 
     */
    public function search_form_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'id' => '',
            ),
            $atts,
            SearchPostTypeKeys::MIMI_SEARCH_FORM_POST_TYPE
        );

        $search_form_id = $atts['id'];

        $custom_post = get_post($search_form_id);

        $default_search_settings = ['userSearchHistoryVisibility' => 0, 'topSearchKeywordVisibility' => 0];

        $search_settings = get_option(Keys::MIMI_SEARCH_SETTINGS) ? get_option(Keys::MIMI_SEARCH_SETTINGS) : $default_search_settings;

        if ($custom_post) {

            $search_box_style = get_theme_mod(CustomizeKeys::MIMI_SEARCH_BOX_STYLE_SETTING, 'mimi-search-box-style-1');
            $search_box_color = get_theme_mod(CustomizeKeys::MIMI_SEARCH_BOX_COLOR_SETTING);
            $search_history_visibility = $search_settings['userSearchHistoryVisibility'];
            $top_search_keyword_visibility = $search_settings['topSearchKeywordVisibility'];

            $live_result_style = get_theme_mod(CustomizeKeys::MIMI_LIVE_RESULTS_STYLE_SETTING);
            $live_result_color_hover = get_theme_mod(CustomizeKeys::MIMI_LIVE_RESULTS_COLOR_SETTING);
            $live_result_no_found = get_theme_mod(CustomizeKeys::MIMI_LIVE_RESULTS_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING);
            $live_result_no_found_img = get_theme_mod(CustomizeKeys::MIMI_LIVE_RESULTS_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING);

            $search_scope = get_post_meta($custom_post->ID, 'mimi_search_scope', true);

            $searchScope_pages = $search_scope['mimi_pages'];
            $searchScope_posts = $search_scope['mimi_posts'];
            $searchScope_products = $search_scope['mimi_products'];

            ob_start();
?>
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div id="mimi-search-bar-app" data-platform="wordpress" data-value="<?php echo esc_attr($search_form_id) ?>" data-search-style="<?php echo esc_attr($search_box_style) ?>" data-search-color="<?php echo esc_attr($search_box_color) ?>" data-search-scope-pages="<?php echo esc_attr($searchScope_pages) ?>" data-search-scope-posts="<?php echo esc_attr($searchScope_posts) ?>" data-search-scope-products="<?php echo esc_attr($searchScope_products) ?>" data-search-history="<?php echo esc_attr($search_history_visibility) ?>" data-top-search-keyword="<?php echo esc_attr($top_search_keyword_visibility) ?>" data-live-result-style="<?php echo esc_attr($live_result_style) ?>" data-live-result-color-hover="<?php echo esc_attr($live_result_color_hover) ?>" data-live-result-no-found="<?php echo esc_attr($live_result_no_found) ?>" data-live-result-no-found-img="<?php echo esc_url($live_result_no_found_img) ?>">
                </div>
            </form>
<?php

            return ob_get_clean();
        } else {
            return esc_html__('MiMi search shortcode not found', 'mimi');
        }
    }
}
