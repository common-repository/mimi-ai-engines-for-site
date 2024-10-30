<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

get_header(); // Gọi header của trang
$query_search = get_search_query();

use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Common\Keys;

$default_search_results_settings = array(
    'filterResultsPage' => 1,
    'sortOnResultsPage' => 1,
    'numbersOfResultsPage' => 10
);

$search_results_settings = get_option(Keys::MIMI_SEARCH_SETTINGS) ? get_option(Keys::MIMI_SEARCH_SETTINGS) : $default_search_results_settings;

$filtersOnSearchResultsPage = $search_results_settings['filterResultsPage'];
$sortOnSearchResultsPage = $search_results_settings['sortOnResultsPage'];
$numberOfResultsPerPage = $search_results_settings['numbersOfResultsPage'];
$messageForNoResultsFound = get_theme_mod(CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_DEFAULT_MESSAGE_FOR_NO_RESULTS_FOUND_SETTING);
$imageForNoResultsFound = get_theme_mod(CustomizeKeys::MIMI_SEARCH_RESULTS_PAGE_NO_RESULTS_FOUND_DEFAULT_IMAGE_SETTING);
$result_color_hover = get_theme_mod(CustomizeKeys::MIMI_LIVE_RESULTS_COLOR_SETTING);

?>

<div id="mimi-search-results-page-app" data-platform="wordpress" data-value="<?php echo esc_attr($query_search) ?>" data-filters="<?php echo esc_attr($filtersOnSearchResultsPage) ?>" data-sort="<?php echo esc_attr($sortOnSearchResultsPage) ?>" data-number-of-results-per-page="<?php echo esc_attr($numberOfResultsPerPage) ?>" data-message-for-no-results-found="<?php echo esc_attr($messageForNoResultsFound) ?>" data-image-for-no-results-found="<?php echo esc_url($imageForNoResultsFound) ?>" data-result-color-hover="<?php echo esc_attr($result_color_hover) ?>">
    <h2>
        <?php esc_html_e('Loading', 'mimi'); ?>...
    </h2>
</div>

<?php
get_footer(); // Gọi footer của trang
