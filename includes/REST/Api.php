<?php

namespace VietDevelopers\MiMi\REST;

/**
 * API Manager class.
 *
 * All API classes would be registered here.
 *
 * @since 1.0.0
 */
class Api
{
    /**
     * Class dir and class name mapping.
     *
     * @var array
     *
     * @since 1.0.0
     */
    protected $class_map;

    /**
     * Array to store controller instances.
     *
     * @var array
     */
    protected $controllers = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (!class_exists('WP_REST_Server')) {
            return;
        }

        $this->class_map = apply_filters(
            'mimi_rest_api_class_map',
            [
                \VietDevelopers\MiMi\REST\DataExportController::class,
                \VietDevelopers\MiMi\REST\InformationOfVisitorsController::class,
                \VietDevelopers\MiMi\REST\IntegrationController::class,
                \VietDevelopers\MiMi\REST\InfoController::class,
                \VietDevelopers\MiMi\REST\SettingController::class,
                \VietDevelopers\MiMi\REST\AutomatedAIProjectsController::class
            ]
        );

        // Init REST API routes.
        add_action('rest_api_init', array($this, 'register_rest_routes'), 10);
    }

    /**
     * Register REST API routes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_rest_routes(): void
    {
        foreach ($this->class_map as $controller) {
            $this->controllers[$controller] = new $controller();
            $this->controllers[$controller]->register_routes();
        }
    }
}
