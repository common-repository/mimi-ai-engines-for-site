<?php

namespace VietDevelopers\MiMi\Admin;

/**
 * Menu generator class.
 *
 * Ensure admin menu registrations.
 *
 * @since 1.0.0
 */
class Menu
{
    private $status_imported_data;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->status_imported_data = get_option('mimi_status_imported_data');

        add_action('admin_menu', array($this, 'init_menu'));
    }

    /**
     * Init Menu.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_menu()
    {
        global $submenu;

        $slug          = MIMI_SLUG;
        $menu_position = 50;
        $capability    = 'manage_options';

        $logo_icon = MIMI_ASSETS . '/images/mimi-logo.svg';

        add_menu_page(esc_attr__('MiMi AI', 'mimi'), esc_attr__('MiMi AI', 'mimi'), $capability, $slug, array($this, 'plugin_page'), $logo_icon, $menu_position);

        // Register this only for Administrator user.
        if (current_user_can($capability) && $this->status_imported_data == 1) {
            $submenu[$slug][] = array(esc_attr__('Settings', 'mimi'), $capability, 'admin.php?page=' . $slug . '#/'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            add_submenu_page($slug, esc_attr__('MiMi Search Forms', 'mimi'), esc_attr__('Search Forms', 'mimi'), $capability, $slug . '-search-forms', array($this, 'search_form_page'));
            $submenu[$slug][] = array(esc_attr__('Automated AI Projects', 'mimi'), $capability, 'admin.php?page=' . $slug . '#/automated-ai-projects'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $submenu[$slug][] = array(esc_attr__('Conversations', 'mimi'), $capability, 'admin.php?page=' . $slug . '#/conversations'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $submenu[$slug][] = array(esc_attr__('Contacts', 'mimi'), $capability, 'admin.php?page=' . $slug . '#/contacts'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $submenu[$slug][] = array(esc_attr__('Train AI', 'mimi'), $capability, 'admin.php?page=' . $slug . '#/train-ai'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $submenu[$slug][] = array(esc_attr__('Upgrade', 'mimi'), $capability, 'https://www.themimi.net/pricing/'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        }
    }

    /**
     * Render the plugin page.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function plugin_page()
    {
        if ($this->status_imported_data == 0) {
            require_once MIMI_TEMPLATE_PATH . '/Admin/WelcomePage.php';
        } else {
            require_once MIMI_TEMPLATE_PATH . '/Admin/AdminApp.php';
        }
    }

    public function search_form_page()
    {
        require_once MIMI_TEMPLATE_PATH . '/Admin/SearchFormPage.php';
    }
}
