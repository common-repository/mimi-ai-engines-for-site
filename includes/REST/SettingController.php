<?php

namespace VietDevelopers\MiMi\REST;

use VietDevelopers\MiMi\Abstracts\RESTController;

use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WP_Error;
use VietDevelopers\MiMi\Traits\InputSanitizer;
use VietDevelopers\MiMi\Common\Keys;

/**
 * API SettingController class.
 *
 * @since 1.0.0
 */
class SettingController extends RESTController
{
    use InputSanitizer;

    /**
     * Route base.
     *
     * @var string
     */
    protected $base = 'settings';

    /**
     * Register all routes related with carts.
     *
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/search',
            [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'save_search'],
                    'permission_callback' => [$this, 'check_permission'],
                ],
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_search'],
                    'permission_callback' => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/recommendation',
            [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'save_recommendation'],
                    'permission_callback' => [$this, 'check_permission'],
                ],
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_recommendation'],
                    'permission_callback' => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/chatbot',
            [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'save_chatbot'],
                    'permission_callback' => [$this, 'check_permission'],
                ],
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_chatbot'],
                    'permission_callback' => [$this, 'check_permission'],
                ]
            ]
        );
    }

    /**
     * Check permission
     *
     * @return bool
     */
    public function check_permission(): bool
    {
        // return current_user_can('manage_options');
        return true;
    }

    /**
     * Get search settings saved in database
     * 
     * @since 1.0.0
     *
     * @return WP_REST_Response|WP_Error
     */
    public function get_search()
    {
        $data_setting_key = get_option(Keys::MIMI_SEARCH_SETTINGS);

        if (!$data_setting_key) {
            return new WP_Error(
                'mimi_settings_search_key_save_missing',
                __('Setting missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }

        return rest_ensure_response(
            [
                'isSuccess' => true,
                'message' => __('Search setting succesfully.', 'mimi'),
                'data' => $data_setting_key
            ]
        );
    }
    /**
     * Create search setting
     * 
     * @since 1.0.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error
     */
    public function save_search($request)
    {
        if (isset($request['userSearchHistoryVisibility']) && isset($request['topSearchKeywordVisibility']) && isset($request['filterResultsPage']) && isset($request['sortOnResultsPage']) && isset($request['numbersOfResultsPage'])) {
            if (empty($request['userSearchHistoryVisibility']) && empty($request['topSearchKeywordVisibility']) && empty($request['filterResultsPage']) && empty($request['sortOnResultsPage']) && empty($request['numbersOfResultsPage'])) {
                return new WP_Error(
                    'mimi_settings_search_key_save_missing',
                    __('Setting missing. Please try again later.', 'mimi'),
                    ['status' => 400]
                );
            } else {
                $userSearchHistoryVisibility = $this->sanitize($request['userSearchHistoryVisibility'], 'boolean');
                $topSearchKeywordVisibility = $this->sanitize($request['topSearchKeywordVisibility'], 'boolean');
                $filterResultsPage = $this->sanitize($request['filterResultsPage'], 'boolean');
                $sortOnResultsPage = $this->sanitize($request['sortOnResultsPage'], 'boolean');
                $numbersOfResultsPage = $this->sanitize($request['numbersOfResultsPage'], 'number');

                $data_setting = array(
                    'userSearchHistoryVisibility' => $userSearchHistoryVisibility,
                    'topSearchKeywordVisibility' => $topSearchKeywordVisibility,
                    'filterResultsPage' => $filterResultsPage,
                    'sortOnResultsPage' => $sortOnResultsPage,
                    'numbersOfResultsPage' => $numbersOfResultsPage
                );

                $data_setting_key = get_option(Keys::MIMI_SEARCH_SETTINGS);

                if (!$data_setting_key) {
                    add_option(Keys::MIMI_SEARCH_SETTINGS, $data_setting);
                } else {
                    update_option(Keys::MIMI_SEARCH_SETTINGS, $data_setting);
                }

                return rest_ensure_response(
                    [
                        'isSuccess' => true,
                        'message' => __('Search setting succesfully.', 'mimi'),
                        'data' => get_option(Keys::MIMI_SEARCH_SETTINGS)
                    ]
                );
            }
        } else {
            return new WP_Error(
                'mimi_settings_search_key_save_missing',
                __('Setting missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }
    }

    /**
     * Get recommendation settings saved in database
     */
    public function get_recommendation()
    {
        $data_setting_key = get_option(Keys::MIMI_RECOMMENDATION_SETTINGS);

        if (!$data_setting_key) {
            return new WP_Error(
                'mimi_settings_recommendation_key_save_missing',
                __('Setting missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }

        return rest_ensure_response(
            [
                'isSuccess' => true,
                'message' => __('Recommendation setting succesfully.', 'mimi'),
                'data' => $data_setting_key
            ]
        );
    }

    /**
     * Create recommendation setting
     * 
     * @since 1.0.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error
     */

    public function save_recommendation($request)
    {
        if (isset($request['similarProducts']) && isset($request['frequentlyBoughtTogetherProducts']) && isset($request['numberOfProduct'])) {
            if (empty($request['similarProducts']) && empty($request['frequentlyBoughtTogetherProducts']) && empty($request['numberOfProduct'])) {
                return new WP_Error(
                    'mimi_settings_search_key_save_missing',
                    __('Setting missing. Please try again later.', 'mimi'),
                    ['status' => 400]
                );
            } else {
                $similarProducts = $this->sanitize($request['similarProducts'], 'boolean');
                $frequentlyBoughtTogetherProducts = $this->sanitize($request['frequentlyBoughtTogetherProducts'], 'boolean');
                $numberOfProduct = $this->sanitize($request['numberOfProduct'], 'number');

                $data_setting = array(
                    'similarProducts' => $similarProducts,
                    'frequentlyBoughtTogetherProducts' => $frequentlyBoughtTogetherProducts,
                    'numberOfProduct' => $numberOfProduct
                );

                $data_setting_key = get_option(Keys::MIMI_RECOMMENDATION_SETTINGS);

                if (!$data_setting_key) {
                    add_option(Keys::MIMI_RECOMMENDATION_SETTINGS, $data_setting);
                } else {
                    update_option(Keys::MIMI_RECOMMENDATION_SETTINGS, $data_setting);
                }

                return rest_ensure_response(
                    [
                        'isSuccess' => true,
                        'message' => __('Recommendation setting succesfully.', 'mimi'),
                        'data' => get_option(Keys::MIMI_RECOMMENDATION_SETTINGS)
                    ]
                );
            }
        } else {
            return new WP_Error(
                'mimi_settings_recommendation_key_save_missing',
                __('Setting missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }
    }

    /**
     * Get chatbot settings saved in database
     */
    public function get_chatbot()
    {
        $data_setting_key = get_option(Keys::MIMI_CHATBOT_SETTINGS);

        if (!$data_setting_key) {
            return new WP_Error(
                'mimi_settings_chatbot_key_save_missing',
                __('Setting missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }

        return rest_ensure_response(
            [
                'isSuccess' => true,
                'message' => __('chatbot setting succesfully.', 'mimi'),
                'data' => $data_setting_key
            ]
        );
    }

    /**
     * Create chatbot setting
     * 
     * @since 1.0.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error
     */

    public function save_chatbot($request)
    {
        if (isset($request['chatbotName']) && isset($request['welcomeMessage']) && isset($request['sorryMessage']) && isset($request['contactCollectionForm']) && isset($request['contactCollectionFullname']) && isset($request['contactCollectionEmail']) && isset($request['contactCollectionPhoneNumber']) && isset($request['contactCollectionNote'])) {
            if (empty($request['chatbotName']) && empty($request['welcomeMessage']) && empty($request['sorryMessage']) && empty($request['contactCollectionForm']) && empty($request['contactCollectionFullname']) && empty($request['contactCollectionEmail']) && empty($request['contactCollectionPhoneNumber']) && empty($request['contactCollectionNote'])) {
                return new WP_Error(
                    'mimi_settings_search_key_save_missing',
                    __('Setting missing. Please try again later.', 'mimi'),
                    ['status' => 400]
                );
            } else {
                $chatbotName = $this->sanitize($request['chatbotName'], 'text');
                $welcomeMessage = $this->sanitize($request['welcomeMessage'], 'text');
                $sorryMessage = $this->sanitize($request['sorryMessage'], 'text');
                $contactCollectionForm = $this->sanitize($request['contactCollectionForm'], 'boolean');
                $contactCollectionFullname = $this->sanitize($request['contactCollectionFullname'], 'boolean');
                $contactCollectionEmail = $this->sanitize($request['contactCollectionEmail'], 'boolean');
                $contactCollectionPhoneNumber = $this->sanitize($request['contactCollectionPhoneNumber'], 'boolean');
                $contactCollectionNote = $this->sanitize($request['contactCollectionNote'], 'boolean');

                $data_setting = array(
                    'chatbotName' => $chatbotName,
                    'welcomeMessage' => $welcomeMessage,
                    'sorryMessage' => $sorryMessage,
                    'contactCollectionForm' => $contactCollectionForm,
                    'contactCollectionFullname' => $contactCollectionFullname,
                    'contactCollectionEmail' => $contactCollectionEmail,
                    'contactCollectionPhoneNumber' => $contactCollectionPhoneNumber,
                    'contactCollectionNote' => $contactCollectionNote,
                );

                $data_setting_key = get_option(Keys::MIMI_CHATBOT_SETTINGS);

                if (!$data_setting_key) {
                    add_option(Keys::MIMI_CHATBOT_SETTINGS, $data_setting);
                } else {
                    update_option(Keys::MIMI_CHATBOT_SETTINGS, $data_setting);
                }

                return rest_ensure_response(
                    [
                        'isSuccess' => true,
                        'message' => __('Chatbot setting succesfully.', 'mimi'),
                        'data' => get_option(Keys::MIMI_CHATBOT_SETTINGS)
                    ]
                );
            }
        } else {
            return new WP_Error(
                'mimi_settings_chatbot_key_save_missing',
                __('Setting missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }
    }
}
