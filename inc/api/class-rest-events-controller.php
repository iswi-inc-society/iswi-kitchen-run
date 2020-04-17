<?php
namespace KitchenRun\Inc\Api;


use KitchenRun\Inc\Common\Model\Event;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Class Rest_Events_Controller
 * @package KitchenRun\Inc\Api
 *
 * Rest Controller for Rest Api to use to get events from database in other languages like javascript, etc
 *
 */
class Rest_Events_Controller
{
    public $namespace;
    public $resource_name;
    public $schema;

    // Here initialize our namespace and resource name.
    public function __construct() {
        $this->namespace     = '/kitchenrun';
        $this->resource_name = 'events';
    }

    // Register our routes.
    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->resource_name, array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
            ),
            // Register our schema callback.
            'schema' => array( $this, 'get_item_schema' ),
        ) );
        register_rest_route( $this->namespace, '/' . $this->resource_name . '/(?P<id>[\d]+)', array(
            // Notice how we are registering multiple endpoints the 'schema' equates to an OPTIONS request.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
            ),
            // Register our schema callback.
            'schema' => array( $this, 'get_item_schema' ),
        ) );
    }

    /**
     * Check permissions for the Event.
     *
     * @return bool|WP_Error
     */
    public function get_items_permissions_check() {
        if ( ! current_user_can( 'read' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot view the post resource.' ), array( 'status' => $this->authorization_status_code() ) );
        }
        return true;
    }

    /**
     * Get all Events for Rest Response.
     *
     * @return mixed|WP_REST_Response
     */
    public function get_items() {

        $events = Event::findAll();

        $data = array();

        if ( empty( $events ) ) {
            return rest_ensure_response( $data );
        }

        foreach ( $events as $event ) {
            $response = $this->prepare_item_for_response($event);
            $data[] = $this->prepare_response_for_collection( $response );
        }

        // Return all of our comment response data.
        return rest_ensure_response( $data );
    }

    /**
     * Check permissions for the event.
     *
     * @return bool|WP_Error
     */
    public function get_item_permissions_check() {
        if ( ! current_user_can( 'read' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot view the post resource.' ), array( 'status' => $this->authorization_status_code() ) );
        }
        return true;
    }

    /**
     * Grab Event by ID and prepare it for response.
     *
     * @param WP_REST_Request $request Current request.
     * @return mixed|WP_REST_Response
     */
    public function get_item( $request ) {
        $id = (int) $request['id'];
        $event = Event::findbyId($id);

        if ( empty( $event ) ) {
            return rest_ensure_response( array() );
        }

        $response = $this->prepare_item_for_response($event);

        // Return all of our post response data.
        return $response;
    }

    /**
     * Matches the event data to the schema we want.
     *
     * @param Event $event The comment object whose response is being prepared.
     * @return mixed|WP_REST_Response
     */
    public function prepare_item_for_response($event) {
        $event_data = array();

        $schema = $this->get_item_schema();

        // We are also renaming the fields to more understandable names.
        if ( isset( $schema['properties']['id'] ) ) {
            $event_data['id'] = (int) $event->getId();
        }

        if ( isset( $schema['properties']['name'] ) ) {
            $event_data['name'] = (string) $event->getName();
        }

        if ( isset( $schema['properties']['current'] ) ) {
            $event_data['current'] = (boolean) $event->getCurrent();
        }

        if ( isset( $schema['properties']['opening_date'] ) ) {
            $event_data['opening_date'] = (int) $event->getOpeningDate()->getTimestamp();
        }

        if ( isset( $schema['properties']['closing_date'] ) ) {
            $event_data['closing_date'] = (int) $event->getClosingDate()->getTimestamp();
        }

        if ( isset( $schema['properties']['event_date'] ) ) {
            $event_data['event_date'] = (int) $event->getEventDate()->getTimestamp();
        }

        if ( isset( $schema['properties']['manager'] ) ) {
            $event_data['manager'] = (int) $event->getManager()->ID;
        }

        if ( isset( $schema['properties']['paired'] ) ) {
            $event_data['paired'] = (boolean) $event->getPaired();
        }

        return rest_ensure_response( $event_data );
    }

    /**
     * Prepare a response for inserting into a collection of responses.
     *
     * This is copied from WP_REST_Controller class in the WP REST API v2 plugin.
     *
     * @param WP_REST_Response $response Response object.
     * @return array|WP_REST_Response
     */
    public function prepare_response_for_collection( $response ) {
        if ( ! ( $response instanceof WP_REST_Response ) ) {
            return $response;
        }

        $data = (array) $response->get_data();
        $server = rest_get_server();

        if ( method_exists( $server, 'get_compact_response_links' ) ) {
            $links = call_user_func( array( $server, 'get_compact_response_links' ), $response );
        } else {
            $links = call_user_func( array( $server, 'get_response_links' ), $response );
        }

        if ( ! empty( $links ) ) {
            $data['_links'] = $links;
        }

        return $data;
    }

    /**
     * Get our sample schema for a event.
     *
     * @return array
     */
    public function get_item_schema() {
        if ( $this->schema ) {
            // Since WordPress 5.3, the schema can be cached in the $schema property.
            return $this->schema;
        }

        $this->schema = array(
            // This tells the spec of JSON Schema we are using which is draft 4.
            '$schema'               => 'http://json-schema.org/draft-04/schema#',
            // The title property marks the identity of the resource.
            'title'                 => 'events',
            'type'                  => 'object',
            // In JSON Schema you can specify object properties in the properties attribute.
            'properties'            => array(
                'id'    => array(
                    'description'   => esc_html__( 'Unique identifier for the object.', 'kitchen-run' ),
                    'type'          => 'integer',
                    'context'       => array( 'view', 'edit', 'embed' ),
                    'readonly'      => true,
                ),
                'name'  => array(
                    'description'   => esc_html__( 'Name of the Event.', 'kitchen-run' ),
                    'type'          => 'string',
                ),
                'current' => array(
                    'description'   => esc_html__( 'Is this the current Event?', 'kitchen-run' ),
                    'type'          => 'boolean',
                ),
                'opening_date' => array(
                    'description'   => esc_html__( 'Timestamp of the opening date for the sign up form.', 'kitchen-run' ),
                    'type'          => 'integer',
                ),
                'closing_date' => array(
                    'description'   => esc_html__( 'Timestamp of the closing date for the sign up form.', 'kitchen-run' ),
                    'type'          => 'integer',
                ),
                'event_date' => array(
                    'description'   => esc_html__( 'Timestamp of the date the event takes place.', 'kitchen-run' ),
                    'type'          => 'integer',
                ),
                'manager' => array(
                    'description'   => esc_html__( 'ID of manager.', 'kitchen-run' ),
                    'type'          => 'integer',
                ),
                'paired' => array(
                    'description'   => esc_html__( 'Is the event already paired.', 'kitchen-run' ),
                    'type'          => 'boolean',
                ),
            ),
        );

        return $this->schema;
    }

    // Sets up the proper HTTP status code for authorization.
    public function authorization_status_code() {

        $status = 401;

        if ( is_user_logged_in() ) {
            $status = 403;
        }

        return $status;
    }
}