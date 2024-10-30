<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.vietdevelopers.com/
 * @since             1.1.0
 * @package           Mimi
 *
 * @wordpress-plugin
 * Plugin Name:       MiMi - AI engines for site
 * Description:       Turn your site smarter to enhance user experience & boost your sale performance with AI core features such as AI search (semantic search), AI Chatbot, Product Recommendations and much more.
 * Version:           1.1.0
 * Author:            MiMi
 * Author URI:        https://themimi.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mimi
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * MiMi App class.
 *
 * @class MiMi The class that holds the entire MiMi App plugin
 */
final class MiMi
{
    /**
     * Plugin version.
     *
     * @var string
     */
    const VERSION = '1.1.0';

    /**
     * Plugin slug.
     *
     * @var string
     *
     * @since 1.0.0
     */
    const SLUG = 'mimi';

    /**
     * Holds various class instances.
     *
     * @var array
     *
     * @since 1.0.0
     */
    private $container = array();

    /**
     * Constructor for the mimi class.
     *
     * Sets up all the appropriate hooks and actions within our plugin.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        require_once __DIR__ . '/vendor/autoload.php';

        $this->define_constants();

        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        add_action('wp_loaded', [$this, 'flush_rewrite_rules']);
        add_action('activated_plugin', [$this, 'mimi_activation_redirect']);

        $this->init_plugin();
    }

    /**
     * Initializes the MiMi() class.
     *
     * Checks for an existing MiMi() instance
     * and if it doesn't find one, creates it.
     *
     * @since 1.0.0
     *
     * @return MiMi|bool
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new MiMi();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @since 1.0.0
     *
     * @param string $prop class name.
     *
     * @return mixed
     */
    public function __get($prop)
    {
        if (array_key_exists($prop, $this->container)) {
            return $this->container[$prop];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @since 1.0.0
     *
     * @param string $prop class name to access from container.
     *
     * @return mixed
     */
    public function __isset($prop)
    {
        return isset($this->{$prop}) || isset($this->container[$prop]);
    }

    /**
     * Define the constants.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function define_constants()
    {
        define('MIMI_VERSION', self::VERSION);
        define('MIMI_SLUG', self::SLUG);
        define('MIMI_FILE', __FILE__);
        define('MIMI_DIR', __DIR__);
        define('MIMI_PATH', dirname(MIMI_FILE));
        define('MIMI_INCLUDES', MIMI_PATH . '/includes');
        define('MIMI_TEMPLATE_PATH', MIMI_PATH . '/templates');
        define('MIMI_URL', plugins_url('', MIMI_FILE));
        define('MIMI_BUILD', MIMI_URL . '/build');
        define('MIMI_ASSETS', MIMI_URL . '/assets');
        define('MIMI_TEMPLATE_URL', MIMI_URL . '/templates');
        define('MIMI_API_V1', 'https://api.themimi.net/v1/');
        define('MIMI_API_RECOMMENDATION', "https://recommendations.themimi.net/site-knn/model");
    }

    /**
     * Load the plugin after all plugins are loaded.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_plugin()
    {
        $this->includes();
        $this->init_hooks();

        /**
         * Fires after the plugin is loaded.
         *
         * @since 1.0.0
         */
        do_action('mimi_loaded');
    }

    /**
     * Activating the plugin.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function activate()
    {
        // Run the installer to create necessary migrations, seeders and options.
        $this->install();
    }

    /**
     * Placeholder for deactivation function.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function deactivate()
    {
        // Run the uninstaller to remove necessary migrations, seeders and options.
        $this->uninstall();
    }

    /**
     * Flush rewrite rules after plugin is activated.
     *
     * Nothing being added here yet.
     *
     * @since 1.0.0
     */
    public function flush_rewrite_rules()
    {
        // fix rewrite rules
    }

    /**
     * Run the installer to create necessary migrations, seeders and options.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function install()
    {
        $installer = new \VietDevelopers\MiMi\Setup\Installer();
        $installer->run();
    }

    /**
     * Run the uninstaller to remove necessary migrations, seeders and options.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function uninstall()
    {
        $uninstaller = new \VietDevelopers\MiMi\Setup\Uninstaller();
        $uninstaller->run();
    }

    /**
     * Include the required files.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function includes()
    {
        if ($this->is_request('admin')) {
            // Show this only if administrator role is enabled.
            $this->container['admin_menu'] = new VietDevelopers\MiMi\Admin\Menu();
        }

        if ($this->is_request('admin') && $this->is_request('ajax')) {
            $this->container['admin_welcome_page_ajax'] = new VietDevelopers\MiMi\Ajax\Admin\WelcomePageAjax();
            $this->container['admin_search_forms_page_ajax'] = new VietDevelopers\MiMi\Ajax\Admin\SearchFormsPageAjax();
        }

        // Common classes
        $this->container['assets']                      = new VietDevelopers\MiMi\Assets\Manager();
        $this->container['rest_api']                    = new VietDevelopers\MiMi\REST\Api();
        $this->container['chatbox']                     = new VietDevelopers\MiMi\Chatbox\Manager();
        $this->container['information_of_visitors']     = new VietDevelopers\MiMi\InformationOfVisitors\Manager();
        $this->container['customizes']                  = new \VietDevelopers\MiMi\Customizes\Customize();
        $this->container['search_results_page']         = new  VietDevelopers\MiMi\SearchResultsPage\Manager();
        $this->container['product_recommendations']     = new \VietDevelopers\MiMi\ProductRecommendations\Manager();
        $this->container['landing_page']                = new \VietDevelopers\MiMi\LandingPage\Manager();
    }

    /**
     * Initialize the hooks.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_hooks()
    {
        // Init classes.
        add_action('init', array($this, 'init_classes'));

        // Localize our plugin.
        add_action('init', array($this, 'localization_setup'));

        // Add the plugin page links.
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
    }

    /**
     * Instantiate the required classes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_classes()
    {
        // // Init necessary hooks
        // new ducchien\MiMi\User\Hooks();

        // Init Custom Post Types
        new VietDevelopers\MiMi\CustomPostTypes\Hooks();

        // Init shortcodes
        new VietDevelopers\MiMi\Shortcodes\Hooks();
    }

    /**
     * Initialize plugin for localization.
     *
     * @uses load_plugin_textdomain()
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function localization_setup()
    {
        load_plugin_textdomain('mimi', false, dirname(plugin_basename(__FILE__)) . '/languages/');

        // Load the React-pages translations.
        if (is_admin()) {
            // Load wp-script translation for mimi-app
            wp_set_script_translations('mimi-app', 'mimi', plugin_dir_path(__FILE__) . 'languages/');
        }
    }

    /**
     * What type of request is this.
     *
     * @since 1.0.0
     *
     * @param string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();

            case 'ajax':
                return defined('DOING_AJAX');

            case 'rest':
                return defined('REST_REQUEST');

            case 'cron':
                return defined('DOING_CRON');

            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }

    /**
     * Plugin action links
     *
     * @param array $links necessary links in plugin list page.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function plugin_action_links($links)
    {
        $links[] = '<a href="' . admin_url('admin.php?page=mimi#/settings') . '">' . __('Settings', 'mimi') . '</a>';


        return $links;
    }

    public function mimi_activation_redirect($plugin)
    {
        if ($plugin == plugin_basename(__FILE__)) {
            $url = admin_url('admin.php?page=mimi');
            wp_redirect($url);
            exit;
        }
    }
}

/**
 * Initialize the main plugin.
 *
 * @since 1.0.0
 *
 * @return \MiMi|bool
 */
function mimi()
{
    return MiMi::init();
}

/*
 * Kick-off the plugin.
 *
 * @since 1.0.0
 */
mimi();

if (class_exists('WooCommerce')) {
    require_once ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php';
}
