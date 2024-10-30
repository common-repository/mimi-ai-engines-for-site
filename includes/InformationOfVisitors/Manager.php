<?php

namespace VietDevelopers\MiMi\InformationOfVisitors;

class Manager
{
    /**
     * InformationOfVisitor class.
     *
     * @var InformationOfVisitor
     */
    public $informationOfVisitor;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->informationOfVisitor = new InformationOfVisitor();
    }

    /**
     * Get all information of visitors by criteria.
     *
     * @since 1.0.0
     *
     * @param array $args
     * @return array|object|string|int
     */
    public function all(array $args = [])
    {
        $defaults = [
            'page'     => 1,
            'per_page' => 10,
            'orderby'  => 'id',
            'order'    => 'ASC',
            'search'   => '',
            'count'    => false,
            'where'    => [],
        ];

        $args = wp_parse_args($args, $defaults);

        if (!empty($args['search'])) {
            global $wpdb;
            $like = '%' . $wpdb->esc_like(sanitize_text_field(wp_unslash($args['search']))) . '%';
            $args['where'][] = $wpdb->prepare(' fullname LIKE %s OR email LIKE %s OR phone_number LIKE %s ', $like, $like, $like);
        }

        if (!empty($args['where'])) {
            $args['where'] = ' WHERE ' . implode(' AND ', $args['where']);
        } else {
            $args['where'] = '';
        }

        $informationOfVisitors = $this->informationOfVisitor->all($args);

        if ($args['count']) {
            return (int) $informationOfVisitors;
        }

        return $informationOfVisitors;
    }

    /**
     * Create a new information of visitor.
     *
     * @since 1.0.0
     *
     * @param array $data
     *
     * @return int | WP_Error $id
     */
    public function create($data)
    {
        // Prepare information of visitor data for database-insertion.
        $informationOfVisitor_data = $this->informationOfVisitor->prepare_for_database($data);

        // Create information of visitor now.
        $informationOfVisitor_id = $this->informationOfVisitor->create(
            $informationOfVisitor_data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                // '%s',
            ]
        );

        if (!$informationOfVisitor_id) {
            return new \WP_Error('mimi_information_of_visitor_create_failed', __('Failed to create information of visitor.', 'mimi'));
        }

        /**
         * Fires after a information of visitor has been created.
         *
         * @since 1.0.0
         *
         * @param int   $informationOfVisitor_id
         * @param array $informationOfVisitor_data
         */
        do_action('mimi_information_of_visitor_created', $informationOfVisitor_id, $informationOfVisitor_data);

        return $informationOfVisitor_id;
    }

    /**
     * Get single information of visitor by id.
     *
     * @since 1.0.0
     *
     * @param array $args
     * @return array|object|null
     */
    public function get(array $args = [])
    {
        $defaults = [
            'key' => 'id',
            'value' => '',
        ];

        $args = wp_parse_args($args, $defaults);

        if (empty($args['value'])) {
            return null;
        }

        return $this->informationOfVisitor->get_by($args['key'], $args['value']);
    }

    /**
     * Update information of visitor.
     *
     * @since 1.0.0
     *
     * @param array $data
     * @param int   $informationOfVisitor_id
     *
     * @return int | WP_Error $id
     */
    public function update(array $data, int $informationOfVisitor_id)
    {
        // Prepare information of visitor data for database-insertion.
        $informationOfVisitor_data = $this->informationOfVisitor->prepare_for_database($data);

        // Update information of visitor.
        $updated = $this->informationOfVisitor->update(
            $informationOfVisitor_data,
            [
                'id' => $informationOfVisitor_id,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                // '%s',
            ],
            [
                '%d',
            ]
        );

        if (!$updated) {
            return new \WP_Error(
                'mimi_information_of_visitor_update_failed',
                __('Failed to update information of visitor.', 'mimi')
            );
        }

        if ($updated >= 0) {
            /**
             * Fires after a information of visitor is being updated.
             *
             * @since 1.0.0
             *
             * @param int   $informationOfVisitor_id
             * @param array $informationOfVisitor_data
             */
            do_action('mimi_information_of_visitors_updated', $informationOfVisitor_id, $informationOfVisitor_data);

            return $informationOfVisitor_id;
        }

        return new \WP_Error(
            'mimi_information_of_visitor_update_failed',
            __('Failed to update information of visitor.', 'mimi')
        );
    }

    /**
     * Delete information of visitors data.
     *
     * @since 1.0.0
     *
     * @param array|int $information_of_visitor_ids
     *
     * @return int|WP_Error
     */
    public function delete($information_of_visitor_ids)
    {
        if (is_array($information_of_visitor_ids)) {
            $information_of_visitor_ids = array_map('absint', $information_of_visitor_ids);
        } else {
            $information_of_visitor_ids = [absint($information_of_visitor_ids)];
        }

        try {
            $this->informationOfVisitor->query('START TRANSACTION');

            $total_deleted = 0;
            foreach ($information_of_visitor_ids as $information_of_visitor_id) {
                $deleted = $this->informationOfVisitor->delete(
                    [
                        'id' => $information_of_visitor_id,
                    ],
                    [
                        '%d',
                    ]
                );

                if ($deleted) {
                    $total_deleted += intval($deleted);
                }

                /**
                 * Fires after a information of visitor has been deleted.
                 *
                 * @since 1.0.0
                 *
                 * @param int $information_of_visitor_id
                 */
                do_action('mimi_information_of_visitors_deleted', $information_of_visitor_id);
            }

            $this->informationOfVisitor->query('COMMIT');

            return $total_deleted;
        } catch (\Exception $e) {
            $this->informationOfVisitor->query('ROLLBACK');

            return new \WP_Error('mimi-information-of-visitors-delete-error', $e->getMessage());
        }
    }
}
