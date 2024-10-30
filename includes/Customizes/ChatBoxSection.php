<?php

namespace VietDevelopers\MiMi\Customizes;

use WP_Customize_Manager;
use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Customizes\CustomizeControl\ContactCollectionFormControl;
use VietDevelopers\MiMi\Customizes\CustomizeControl\SelectImageControl;
use WP_Customize_Color_Control;
use WP_Customize_Image_Control;

/**
 * Class ChatBoxSection
 * @package VietDevelopers\MiMi\Customizes
 */
class ChatBoxSection
{
    /**
     * Add search box section in theme and styles panel
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    public static function add_section($wp_customize)
    {
        // Add section to panel
        $wp_customize->add_section(CustomizeKeys::MIMI_CHAT_BOX_SECTION, array(
            'title'       => __('Chat Box', 'mimi'),
            'panel'       => CustomizeKeys::MIMI_SETTINGS_PANEL, // ID của panel mà section này thuộc về
        ));

        self::add_chat_box_style_setting($wp_customize);
        self::add_chat_box_main_color_setting($wp_customize);
        self::add_chat_box_text_color_setting($wp_customize);
        self::add_chat_box_message_bot_background_color_setting($wp_customize);
        self::add_chat_box_message_visitor_background_color_setting($wp_customize);
        self::add_chat_box_chatbot_logo_setting($wp_customize);
        self::add_chat_box_chatbot_name_setting($wp_customize);
        self::add_chat_box_welcome_message_setting($wp_customize);
        self::add_chat_box_contact_collection_form_setting($wp_customize);
        self::add_chat_box_sorry_message_setting($wp_customize);
    }

    /**
     * Add chat box style setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_style_setting($wp_customize)
    {
        $plugin_images_dir = plugin_dir_path(MIMI_FILE) . 'assets/images/chat-box-styles/';
        $plugin_images_uri = MIMI_ASSETS . '/images/chat-box-styles/';

        // Lấy danh sách các tệp ảnh trong thư mục plugin
        $images = glob($plugin_images_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        // Tạo mảng chứa lựa chọn cho người dùng
        $image_choices = array();

        // Lặp qua các ảnh và thêm vào mảng lựa chọn
        foreach ($images as $image) {
            // Lấy tên tệp ảnh
            $image_name = basename($image);

            // Lấy tên của file ảnh
            $file_name = pathinfo($image, PATHINFO_FILENAME);

            // Thêm vào mảng lựa chọn với key là tên tệp và value là tên tệp ảnh
            $image_choices[$file_name] = $plugin_images_uri . $image_name;
        }

        // Thêm setting mới cho section con
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_STYLE_SETTING,
            array(
                'default'           => 'mimi-chat-box-style-1',
                'sanitize_callback' => 'sanitize_key', // Sử dụng sanitize callback để chỉ chấp nhận một trong các giá trị được xác định
            )
        );

        // Thêm control cho setting trong section con
        $wp_customize->add_control(
            new SelectImageControl(
                $wp_customize,
                CustomizeKeys::MIMI_CHAT_BOX_STYLE_SETTING,
                array(
                    'section' =>  CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                    'label' => __('Chat box style', 'mimi'),
                    'choices' => $image_choices,
                    'settings' => CustomizeKeys::MIMI_CHAT_BOX_STYLE_SETTING,
                )
            )
        );
    }

    /**
     * Add chat box main color setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_main_color_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_MAIN_COLOR_SETTING,
            array(
                'default'           => '#FE9300',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            CustomizeKeys::MIMI_CHAT_BOX_MAIN_COLOR_SETTING,
            array(
                'label'    => __('Main color', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_MAIN_COLOR_SETTING,
            )
        ));
    }

    /**
     * Add chat box text color setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_text_color_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_TEXT_COLOR_SETTING,
            array(
                'default'           => '#000000',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            CustomizeKeys::MIMI_CHAT_BOX_TEXT_COLOR_SETTING,
            array(
                'label'    => __('Text color', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_TEXT_COLOR_SETTING,
            )
        ));
    }

    /**
     * Add chat box message bot background color setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_message_bot_background_color_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_BOT_BACKGROUND_COLOR_SETTING,
            array(
                'default'           => '#F0F0F1',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_BOT_BACKGROUND_COLOR_SETTING,
            array(
                'label'    => __('Message (Bot) background color', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_BOT_BACKGROUND_COLOR_SETTING,
            )
        ));
    }

    /**
     * Add chat box message visitor background color setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_message_visitor_background_color_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_VISITOR_BACKGROUND_COLOR_SETTING,
            array(
                'default'           => '#FFDEB1',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_VISITOR_BACKGROUND_COLOR_SETTING,
            array(
                'label'    => __('Message (Visitor) background color', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_VISITOR_BACKGROUND_COLOR_SETTING,
            )
        ));
    }

    /**
     * Add chatbot's logo setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_chatbot_logo_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_LOGO_SETTING,
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_LOGO_SETTING,
                array(
                    'label' => __('Chatbot\'s logo', 'mimi'),
                    'section' => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                    'settings' => CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_LOGO_SETTING,
                )
            )
        );
    }

    /**
     * Add chatbot's name setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_chatbot_name_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_NAME_SETTING,
            array(
                'default'           => 'MiMi',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_NAME_SETTING,
            array(
                'label'    => __('Chatbot \'s name', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_NAME_SETTING,
                'type'     => 'text', // Loại control, ví dụ: text, color, image, vv.
            )
        );
    }

    /**
     * Add welcome message setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_welcome_message_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_WELCOME_MESSAGE_SETTING,
            array(
                'default'           => 'Welcome to my shop!',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_CHAT_BOX_WELCOME_MESSAGE_SETTING,
            array(
                'label'    => __('Welcome message', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_WELCOME_MESSAGE_SETTING,
                'type'     => 'text', // Loại control, ví dụ: text, color, image, vv.
            )
        );
    }

    private static function add_chat_box_contact_collection_form_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_CONTACT_COLLECTION_FORM_SETTING,
            array(
                'default'           => 0,
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_CHAT_BOX_CONTACT_COLLECTION_FORM_SETTING,
            array(
                'label'    => __('Contact collection form', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_CONTACT_COLLECTION_FORM_SETTING,
                'type'     => 'checkbox', // Loại control là checkbox
            )
        );
    }

    /**
     * Add sorry message setting in chat box section
     *
     * @param WP_Customize_Manager $wp_customize
     * @since 1.0.0
     */
    private static function add_chat_box_sorry_message_setting($wp_customize)
    {
        // Add new setting
        $wp_customize->add_setting(
            CustomizeKeys::MIMI_CHAT_BOX_SORRY_MESSAGE_SETTING,
            array(
                'default'           => "I am sorry. Based on your context, I can't provide a certain answer. Would you like to connect our staff for further conversation?",
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        // Add control to setting in section
        $wp_customize->add_control(
            CustomizeKeys::MIMI_CHAT_BOX_SORRY_MESSAGE_SETTING,
            array(
                'label'    => __('Sorry message', 'mimi'),
                'section'  => CustomizeKeys::MIMI_CHAT_BOX_SECTION,
                'settings' => CustomizeKeys::MIMI_CHAT_BOX_SORRY_MESSAGE_SETTING,
                'type'     => 'text', // Loại control, ví dụ: text, color, image, vv.
            )
        );
    }
}
