<?php

namespace VietDevelopers\MiMi\Assets;

use VietDevelopers\MiMi\Common\Keys;

/**
 * Asset Manager class.
 *
 * Responsible for managing all of the assets (CSS, JS, Images, Locales).
 */
class Manager
{

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('init', [$this, 'register_all_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_public_assets']);
    }

    /**
     * Register all scripts and styles.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_all_scripts()
    {
        $this->register_styles($this->get_styles());
        $this->register_scripts($this->get_scripts());
    }

    /**
     * Get all styles.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_styles(): array
    {
        return [
            'mimi-admin-app' => [
                'src' => MIMI_BUILD . '/adminApp.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-chatbox' => [
                'src' => MIMI_BUILD . '/chatBoxApp.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-search-bar' => [
                'src' => MIMI_BUILD . '/searchBarApp.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-search-results-page' => [
                'src' => MIMI_BUILD . '/searchResultsPageApp.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-frequently-bought-together-products' => [
                'src' => MIMI_BUILD . '/frequentlyBoughtTogetherProductsApp.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-related-products' => [
                'src' => MIMI_BUILD . '/relatedProductApp.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-admin-welcome-app' => [
                'src' => MIMI_ASSETS . '/css/mimi-welcome-app.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-admin-search-form' => [
                'src' => MIMI_ASSETS . '/css/mimi-search-form.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
            'mimi-admin-fontawesome' => [
                'src' => MIMI_ASSETS . '/font-awesome/css/all.css',
                'version' => MIMI_VERSION,
                'deps' => [],
            ],
        ];
    }

    /**
     * Get all scripts.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_scripts(): array
    {
        return [
            'mimi-admin-app' => [
                'src' => MIMI_BUILD . '/adminApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-chatbox' => [
                'src' => MIMI_BUILD . '/chatBoxApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-search-bar' => [
                'src' => MIMI_BUILD . '/searchBarApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-search-results-page' => [
                'src' => MIMI_BUILD . '/searchResultsPageApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-frequently-bought-together-products' => [
                'src' => MIMI_BUILD . '/frequentlyBoughtTogetherProductsApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-related-products' => [
                'src' => MIMI_BUILD . '/relatedProductApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-landing-page' => [
                'src' => MIMI_BUILD . '/landingPageApp.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-admin-welcome-app' => [
                'src' => MIMI_ASSETS . '/js/mimi-welcome-app.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],
            'mimi-admin-search-form' => [
                'src' => MIMI_ASSETS . '/js/mimi-search-form.js',
                'version' => bin2hex(random_bytes(20)),
                'deps' => ['jquery'],
                'in_footer' => true,
            ],

        ];
    }

    /**
     * Register styles.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_styles(array $styles)
    {
        foreach ($styles as $handle => $style) {
            wp_register_style($handle, $style['src'], $style['deps'], $style['version']);
        }
    }

    /**
     * Register scripts.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_scripts(array $scripts)
    {
        foreach ($scripts as $handle => $script) {
            wp_register_script($handle, $script['src'], $script['deps'], $script['version'], $script['in_footer']);
        }
    }

    /**
     * Enqueue admin styles and scripts.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_admin_assets()
    {
        $status_imported_data = get_option(Keys::MIMI_STATUS_IMPORTED_DATA);
        $page = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';

        if (is_admin()) {

            if ($status_imported_data == 0 && $page === 'mimi') {
                // Enqueue assets for the welcome page
                wp_enqueue_style('mimi-admin-welcome-app');

                wp_enqueue_script('mimi-admin-welcome-app');
                wp_localize_script('mimi-admin-welcome-app', 'mimiAdminLocalizer', [
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('mimi_admin_nonce'),
                ]);
            } elseif ($status_imported_data != 0 && $page === 'mimi-search-forms') {
                // Enqueue assets for the search forms page
                wp_enqueue_style('mimi-admin-search-form');
                wp_enqueue_style('mimi-admin-fontawesome');

                wp_enqueue_script('mimi-admin-search-form');
                wp_localize_script('mimi-admin-search-form', 'mimiAdminLocalizer', [
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('mimi_admin_nonce')
                ]);
            } elseif ($status_imported_data != 0 && $page === 'mimi') {
                $api_key_option = get_option(Keys::MIMI_API_KEY);

                // Enqueue assets for other admin pages
                wp_enqueue_style('mimi-admin-app');

                wp_enqueue_script('mimi-admin-app');
                wp_localize_script('mimi-admin-app', 'mimiAdminLocalizer', [
                    'adminUrl' => admin_url('/'),
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'apiUrl' => esc_url_raw(rest_url()),
                    'nonce' => wp_create_nonce('wp_rest'),
                    'apiKey' => $api_key_option
                ]);
            }
        }
    }

    /**
     * Enqueue admin styles and scripts.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_public_assets()
    {

        $status_imported_data = get_option(Keys::MIMI_STATUS_IMPORTED_DATA);

        if ($status_imported_data == 1) {

            $api_key_option = get_option(Keys::MIMI_API_KEY);

            wp_enqueue_style('mimi-search-bar');
            wp_enqueue_script('mimi-search-bar');
            wp_localize_script('mimi-search-bar', 'mimiSearchbarLocalizer', [
                'ajaxUrl'   => admin_url('admin-ajax.php'),
                'apiUrl'    => esc_url_raw(rest_url()),
                'nonce'     => wp_create_nonce('wp_rest'),
                'apiKey'    => $api_key_option,
                'homeUrl'   => home_url('/')
            ]);

            wp_enqueue_style('mimi-chatbox');
            wp_enqueue_script('mimi-chatbox');
            wp_localize_script('mimi-chatbox', 'mimiChatboxLocalizer', [
                'ajaxUrl'   => admin_url('admin-ajax.php'),
                'apiUrl'    => esc_url_raw(rest_url()),
                'nonce'     => wp_create_nonce('wp_rest'),
                'apiKey'    => $api_key_option
            ]);

            wp_enqueue_script('mimi-landing-page');

            if (is_search()) {
                wp_enqueue_style('mimi-search-results-page');
                wp_enqueue_script('mimi-search-results-page');
                wp_localize_script('mimi-search-results-page', 'mimiSearchResultsPageLocalizer', [
                    'ajaxUrl'   => admin_url('admin-ajax.php'),
                    'apiUrl'    => esc_url_raw(rest_url()),
                    'nonce'     => wp_create_nonce('wp_rest'),
                    'apiKey'    => $api_key_option
                ]);
            }

            if (class_exists('WooCommerce') && is_product()) {
                wp_enqueue_style('mimi-frequently-bought-together-products');
                wp_enqueue_script('mimi-frequently-bought-together-products');
                wp_localize_script('mimi-frequently-bought-together-products', 'mimiBoughtTogetherLocalizer', [
                    'siteUrl'   => get_bloginfo('url', 'display'),
                    'apiKey'    => $api_key_option
                ]);

                wp_enqueue_style('mimi-related-products');
                wp_enqueue_script('mimi-related-products');
                wp_localize_script('mimi-related-products', 'mimiRelatedProductsLocalizer', [
                    'siteUrl'   => get_bloginfo('url', 'display'),
                    'apiKey'    => $api_key_option
                ]);
            }
        }
    }
}
