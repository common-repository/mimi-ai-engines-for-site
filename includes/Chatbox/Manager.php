<?php

namespace VietDevelopers\MiMi\Chatbox;

/**
 * Chatbox class.
 */
class Manager
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

        add_action('wp_footer', [$this, 'displayChatBox']);
    }

    public function displayChatBox()
    {
        if ($this->status_imported_data == 1) {
            require_once MIMI_TEMPLATE_PATH . '/Front/ChatBoxApp.php';
        }
    }
}
