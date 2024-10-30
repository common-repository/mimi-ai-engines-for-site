<?php

namespace VietDevelopers\MiMi\InformationOfVisitors;

use VietDevelopers\MiMi\Abstracts\BaseModel;
use VietDevelopers\MiMi\Common\WPDBTableNames;

/**
 * InformationOfVisitor class.
 *
 * @since 1.0.0
 */
class InformationOfVisitor extends BaseModel
{

    /**
     * Table Name.
     *
     * @var string
     */
    protected $table = WPDBTableNames::MIMI_INFORMATIONS_OF_VISITORS;

    /**
     * Information of visitor item to a formatted array.
     *
     * @since 1.0.0
     *
     * @param object $information_of_visitor
     *
     * @return array
     */
    public static function to_array(object $information_of_visitor): array
    {
        return [
            'id'                => (int) $information_of_visitor->id,
            'visitor_id'        => $information_of_visitor->visitor_id,
            'fullname'          => $information_of_visitor->fullname,
            'email'             => $information_of_visitor->email,
            'phone_number'      => $information_of_visitor->phone_number,
            'note'              => $information_of_visitor->note,
            'joined_time'       => $information_of_visitor->joined_time,
            'conversation_id'   => $information_of_visitor->conversation_id,
        ];
    }

    /**
     * Prepare datasets for database operation.
     *
     * @since 1.0.0
     *
     * @param array $request
     * @return array
     */
    public function prepare_for_database(array $data): array
    {
        $defaults = [
            'visitor_id'        => '',
            'fullname'          => '',
            'email'             => '',
            'phone_number'      => '',
            'note'              => '',
            // 'joined_time'       => current_datetime()->format('Y-m-d H:i:s'),
            'conversation_id'   => '',
        ];

        $data = wp_parse_args($data, $defaults);

        // Sanitize template data
        return [
            'visitor_id'        => $this->sanitize($data['visitor_id'], 'text'),
            'fullname'          => $this->sanitize($data['fullname'], 'text'),
            'email'             => $this->sanitize($data['email'], 'email'),
            'phone_number'      => $this->sanitize($data['phone_number'], 'text'),
            'note'              => $this->sanitize($data['note'], 'text'),
            // 'joined_time'       => $this->sanitize($data['joined_time'], 'text'),
            'conversation_id'   => $this->sanitize($data['conversation_id'], 'text'),
        ];
    }
}
