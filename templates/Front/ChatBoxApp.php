<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Common\Keys;

$default_chatbot_settings = array(
    'chatbotName' => 'MiMi',
    'welcomeMessage' => 'Welcome to MiMi',
    'sorryMessage' => 'I am sorry. Based on your context, I can’t provide a certain answer. Would you like to connect our staff for further conversation?',
    'contactCollectionForm' => 0,
    'contactCollectionFullname' => 1,
    'contactCollectionEmail' => 1,
    'contactCollectionPhoneNumber' => 1,
    'contactCollectionNote' => 1
);

$chatbot_settings = get_option(Keys::MIMI_CHATBOT_SETTINGS) ? get_option(Keys::MIMI_CHATBOT_SETTINGS) : $default_chatbot_settings;

$style = get_theme_mod(CustomizeKeys::MIMI_CHAT_BOX_STYLE_SETTING);
$mainColor = get_theme_mod(CustomizeKeys::MIMI_CHAT_BOX_MAIN_COLOR_SETTING);
$textColor = get_theme_mod(CustomizeKeys::MIMI_CHAT_BOX_TEXT_COLOR_SETTING);
$messageBotBackgroundColor = get_theme_mod(CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_BOT_BACKGROUND_COLOR_SETTING);
$messageVisitorBackgroundColor = get_theme_mod(CustomizeKeys::MIMI_CHAT_BOX_MESSAGE_VISITOR_BACKGROUND_COLOR_SETTING);
$chatbotLogo = get_theme_mod(CustomizeKeys::MIMI_CHAT_BOX_CHATBOT_LOGO_SETTING);
$chatbotName = $chatbot_settings['chatbotName'];
$welcomeMessage = $chatbot_settings['welcomeMessage'];
$sorryMessage = $chatbot_settings['sorryMessage'];
$contactCollectionForm = $chatbot_settings['contactCollectionForm'];
$contactCollectionFullname = $chatbot_settings['contactCollectionFullname'];
$contactCollectionEmail = $chatbot_settings['contactCollectionEmail'];
$contactCollectionPhoneNumber = $chatbot_settings['contactCollectionPhoneNumber'];
$contactCollectionNote = $chatbot_settings['contactCollectionNote'];
?>

<div id="mimi-chatbox-app" data-platform="wordpress" data-style="<?php echo esc_attr($style) ?>"
    data-main-color="<?php echo esc_attr($mainColor) ?>" data-text-color="<?php echo esc_attr($textColor) ?>"
    data-message-bot-background-color="<?php echo esc_attr($messageBotBackgroundColor) ?>"
    data-message-visitor-background-color="<?php echo esc_attr($messageVisitorBackgroundColor) ?>"
    data-chatbot-logo="<?php echo esc_attr($chatbotLogo) ?>" data-chatbot-name="<?php echo esc_attr($chatbotName) ?>"
    data-welcome-message="<?php echo esc_attr($welcomeMessage) ?>"
    data-contact-collection-form="<?php echo esc_attr($contactCollectionForm) ?>"
    data-sorry-message="<?php echo esc_attr($sorryMessage) ?>"
    data-contact-collection-fullname="<?php echo esc_attr($contactCollectionFullname) ?>"
    data-contact-collection-email="<?php echo esc_attr($contactCollectionEmail) ?>"
    data-contact-collection-phone="<?php echo esc_attr($contactCollectionPhoneNumber) ?>"
    data-contact-collection-note="<?php echo esc_attr($contactCollectionNote) ?>">

    <h2>
        <?php esc_html_e('Loading', 'mimi'); ?>...
    </h2>
</div>