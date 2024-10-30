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
 * API IntegrationController class.
 *
 * @since 1.0.0
 */
class IntegrationController extends RESTController
{
    use InputSanitizer;

    /**
     * Route base.
     *
     * @var string
     */
    protected $base = 'integration';

    /**
     * Register all routes related with carts.
     *
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/open-ai',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_key_open_ai'],
                    'permission_callback' => [$this, 'check_permission'],
                ],
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'save_key_open_ai'],
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
        return current_user_can('manage_options');
    }

    /**
     * Get key open ai saved in database
     */
    public function get_key_open_ai()
    {
        $openAI_key = get_option(Keys::MIMI_OPEN_AI_KEY);

        if (!$openAI_key) {
            return new WP_Error(
                'mimi_open_ai_key_not_found',
                __('OpenAI Key not found. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }

        return rest_ensure_response(
            [
                'isSuccess'     => true,
                'message'       => __('Get Open AI key succesfully.', 'mimi'),
                'data'          => $openAI_key
            ]
        );
    }

    /**
     * Create or update open ai.
     *
     * @since 1.0.0
     *
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error
     */
    public function save_key_open_ai($request)
    {
        if (isset($request['key']) && isset($request['model'])) {

            if (empty($request['model']) && empty($request['key'])) {
                return new WP_Error(
                    'mimi_open_ai_key_save_empty',
                    __('OpenAI Key or OpenAI Model empty. Please try again later.', 'mimi'),
                    ['status' => 400]
                );
            } else {
                $key = $this->sanitize($request['key'], 'text');
                $model = $this->sanitize($request['model'], 'text');

                $openAI = array(
                    'key' => $key,
                    'model' => $model
                );

                $openAI_key = get_option(Keys::MIMI_OPEN_AI_KEY);

                if (!$openAI_key) {
                    add_option(Keys::MIMI_OPEN_AI_KEY, $openAI);
                } else {
                    update_option(Keys::MIMI_OPEN_AI_KEY, $openAI);
                }
            }

            return rest_ensure_response(
                [
                    'isSuccess'     => true,
                    'message'       => __('Save Open AI key succesfully.', 'mimi')
                ]
            );
        } else {
            // Key and Model ID missing
            return new WP_Error(
                'mimi_open_ai_key_save_missing',
                __('OpenAI Key and OpenAI Model missing. Please try again later.', 'mimi'),
                ['status' => 400]
            );
        }
    }
}
