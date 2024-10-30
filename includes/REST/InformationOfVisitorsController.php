<?php

namespace VietDevelopers\MiMi\REST;

use VietDevelopers\MiMi\Abstracts\RESTController;
use VietDevelopers\MiMi\InformationOfVisitors\InformationOfVisitor;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WP_Error;
use VietDevelopers\MiMi\Traits\InputSanitizer;

/**
 * API InformationOfVisitorsController class.
 *
 * @since 1.0.0
 */
class InformationOfVisitorsController extends RESTController
{
    use InputSanitizer;

    /**
     * Route base
     * 
     * @var string
     */
    protected $base = 'information-of-visitors';

    /**
     * Register all routes related with carts.
     * 
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_items'],
                    'permission_callback' => [$this, 'check_permission'],
                    'args' => $this->get_collection_params(),
                ],
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'create_item'],
                    'permission_callback' => '__return_true',
                    'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::CREATABLE),
                ],
                [
                    'methods' => WP_REST_Server::DELETABLE,
                    'callback' => [$this, 'delete_items'],
                    'permission_callback' => [$this, 'check_permission'],
                    'args' => [
                        'ids' => [
                            'type' => 'array',
                            'default' => [],
                            'description' => __('Information Of Visitor IDs which will be deleted.', 'mimi'),
                        ],
                    ],
                ],
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/(?P<id>[a-zA-Z0-9-]+)',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_item'],
                    'permission_callback' => [$this, 'check_permission'],
                    'args' => $this->get_collection_params(),
                ],
                [
                    'methods' => WP_REST_Server::EDITABLE,
                    'callback' => [$this, 'update_item'],
                    'permission_callback' => [$this, 'check_permission'],
                    'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE),
                ],
            ]
        );
    }

    /**
     * check permission
     *
     * @return bool
     */
    public function check_permission(): bool
    {
        return current_user_can('manage_options');
    }

    /**
     * Retrieves a collection of information of visitor items.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request): ?WP_REST_Response
    {
        $args = [];
        $data = [];
        $params = $this->get_collection_params();

        foreach ($params as $key => $value) {
            if (isset($request[$key])) {
                $args[$key] = $request[$key];
            }
        }

        $informationOfVisitors = mimi()->information_of_visitors->all($args);
        foreach ($informationOfVisitors as $informationOfVisitor) {
            $response = $this->prepare_item_for_response($informationOfVisitor, $request);
            $data[] = $this->prepare_response_for_collection($response);
        }

        $args['count'] = 1;
        $total = mimi()->information_of_visitors->all($args);
        $max_pages = ceil($total / (int) $args['limit']);

        $response = rest_ensure_response(
            [
                'isSuccess' => true,
                'message' => __('Get information of visitors successfully.', 'mimi'),
                'data' => $data,
            ]
        );

        $response->header('X-WP-Total', (int) $total);
        $response->header('X-WP-TotalPages', (int) $max_pages);

        return $response;
    }

    /**
     * Create new information for a visitor.
     *
     * @since 1.0.0
     *
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error
     */
    public function create_item($request)
    {
        // Check if email and visitor_id are provided
        if (isset($request['email']) && isset($request['visitor_id'])) {
            // If email is provided
            if (!empty($request['email'])) {
                $email = $this->sanitize($request['email'], 'email');
                $args = [
                    'key' => 'email',
                    'value' => $email,
                ];
            } else {
                // If email is empty, use visitor_id
                $visitor_id = $this->sanitize($request['visitor_id'], 'text');
                $args = [
                    'key' => 'visitor_id',
                    'value' => $visitor_id,
                ];
            }

            // Check if visitor exists
            $existing_visitor = mimi()->information_of_visitors->get($args);

            if (!$existing_visitor) {
                $prepared_data = $this->prepare_item_for_database($request);

                if (is_wp_error($prepared_data)) {
                    return $prepared_data;
                }

                // Insert the information of visitors
                $information_of_visitor_id = mimi()->information_of_visitors->create($prepared_data);

                if (is_wp_error($information_of_visitor_id)) {
                    return $information_of_visitor_id;
                }

                $response = [
                    'isSuccess' => true,
                    'message' => __('Created information of visitor successfully.', 'mimi'),
                    'data' => $information_of_visitor_id
                ];

                return rest_ensure_response($response);
            } else {
                // Visitor already exists
                $error_message = !empty($request['email']) ? __('The email already exists. Please try again later.', 'mimi') : __('This visitor already exists. Please try again later.', 'mimi');
                return new WP_Error(
                    'mimi_information_of_visitor_create_existing',
                    $error_message,
                    ['status' => 400]
                );
            }
        } else {

            $conversation_id = $this->sanitize($request['conversation_id'], 'text');

            $args = [
                'key' => 'conversation_id',
                'value' => $conversation_id,
            ];

            $existing_visitor = mimi()->information_of_visitors->get($args);

            if (!$existing_visitor) {
                $prepared_data = $this->prepare_item_for_database($request);

                if (is_wp_error($prepared_data)) {
                    return $prepared_data;
                }

                // Insert the information of visitors
                $information_of_visitor_id = mimi()->information_of_visitors->create($prepared_data);

                if (is_wp_error($information_of_visitor_id)) {
                    return $information_of_visitor_id;
                }

                $response = [
                    'isSuccess' => true,
                    'message' => __('Created information of visitor successfully.', 'mimi'),
                    'data' => $information_of_visitor_id
                ];

                return rest_ensure_response($response);
            } else {
                $response = [
                    'isSuccess' => false,
                    'message' => __('Information of visitor existed.', 'mimi'),

                ];

                return rest_ensure_response($response);
            }
        }
    }

    /**
     * Retrieves a collection of information of visitors items.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        if (is_numeric($request['id'])) {
            $args = [
                'key' => 'id',
                'value' => absint($request['id']),
            ];
        } else {
            $args = [
                'key' => 'conversation_id',
                'value' => $this->sanitize($request['id'], 'text'),
            ];
        }

        $informationOfVisitor = mimi()->information_of_visitors->get($args);

        if (!$informationOfVisitor) {
            return new WP_Error(
                'mimi_rest_information_of_visitor_not_found',
                __('Information of visitor not found. May be information of visitor has been deleted or you don\'t have access to that.', 'mimi'),
                ['status' => 404]
            );
        }

        // Prepare response.
        $informationOfVisitor = $this->prepare_item_for_response($informationOfVisitor, $request);

        $response = array(
            'isSuccess' => true,
            'message' => __('Information of visitor found.', 'mimi'),
            'data' => $informationOfVisitor
        );

        return rest_ensure_response($response);
    }

    /**
     * Update a information of visitor.
     *
     * @since 1.0.0
     *
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error
     */
    public function update_item($request)
    {
        if (empty($request['id'])) {
            return new WP_Error(
                'mimi_rest_information_of_visitor_template_exists',
                __('Invalid Information_Of_Visitor ID.', 'mimi'),
                array('status' => 400)
            );
        }

        $prepared_data = $this->prepare_item_for_database($request);

        if (is_wp_error($prepared_data)) {
            return $prepared_data;
        }

        // Update the information of visitor.
        $informationOfVisitor_id = absint($request['id']);
        $informationOfVisitor_id = mimi()->information_of_visitors->update($prepared_data, $informationOfVisitor_id);

        if (is_wp_error($informationOfVisitor_id)) {
            return $informationOfVisitor_id;
        }

        $response = rest_ensure_response(
            [
                "isSuccess" => true,
                "message" => __('Updated information of visitor successfully.', 'mimi'),
                // "data"      => $informationOfVisitor_id
            ]
        );

        return $response;
    }

    /**
     * Delete single or multiple information of visitors.
     *
     * @since 1.0.0
     *
     * @param array $request
     *
     * @return WP_REST_Response|WP_Error
     */
    public function delete_items($request)
    {
        if (!isset($request['ids'])) {
            return new WP_Error(
                'no_ids',
                __('No information of visitors ids found.', 'mimi'),
                ['status' => 400]
            );
        }

        $deleted = mimi()->information_of_visitors->delete($request['ids']);

        if ($deleted) {
            $message = __('Information of visitors deleted successfully.', 'mimi');

            return rest_ensure_response(
                [
                    'isSuccess' => true,
                    'message' => $message,
                    'total' => $deleted,
                ]
            );
        }

        return new WP_Error(
            'mimi_no_information_of_visitor_deleted',
            __('No information of visitor deleted. Information of visitor has already been deleted. Please try again.', 'mimi'),
            ['status' => 400]
        );
    }

    /**
     * Prepares the item for the REST response.
     *
     * @since 1.0.0
     *
     * @param InformationOfVisitor      $item    WordPress representation of the item
     * @param WP_REST_Request           $request request object
     *
     * @return WP_Error|WP_REST_Response
     */
    public function prepare_item_for_response($item, $request)
    {
        $data = [];

        $data = InformationOfVisitor::to_array($item);

        $data = $this->prepare_response_for_collection($data);

        $context = !empty($request['context']) ? $request['context'] : 'view';
        $data = $this->filter_response_by_context($data, $context);

        return $data;
    }

    /**
     * Prepares a single infomrmation of visitor template for create or update.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request Request object.
     *
     * @return object|WP_Error
     */
    protected function prepare_item_for_database($request)
    {
        $data = [];
        $data['visitor_id'] = $request['visitor_id'];
        $data['fullname'] = $request['fullname'];
        $data['email'] = $request['email'];
        $data['phone_number'] = $request['phone_number'];
        $data['note'] = $request['note'];
        $data['conversation_id'] = $request['conversation_id'];

        return $data;
    }

    /**
     * Retrieves the query params for collections.
     *
     * @since 0.3.0
     *
     * @return array
     */
    public function get_collection_params(): array
    {
        $params = parent::get_collection_params();

        $params['limit']['default'] = 10;
        $params['search']['default'] = '';
        $params['orderby']['default'] = 'id';
        $params['order']['default'] = 'ASC';

        return $params;
    }
}
