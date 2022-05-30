<?php


class Forbidden_Island {

    public function __construct() {
        $this->load_dependencies();
        $this->define_api_routes();
    }

    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api-route.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/function.php';
    }

    private function define_api_routes() {
        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden-island/v1';
            $rout = '/get-residents/';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'select_residents',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/get-residents/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_resident',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/edit-resident/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'edit_resident',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/add_resident/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'add_resident',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/remove-resident/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'DELETE',
                'callback' => 'remove_resident',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/get-residents/';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_resident_items',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/get-items/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_items',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/add-items/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'add_items',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/remove-items/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'DELETE',
                'callback' => 'remove_items',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/add-island-lot/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'add_island_lot',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/auction/';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'auction',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/get-my-items/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_my_items',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/get-customer-items/(?P<id>\d+)';
            $rout_params = [
                'methods'  => 'GET',
                'callback' => 'get_customer_items',
                'args' => [
                    'id'
                ],
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/open-auction-bid/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'open_auction_bid',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

        add_action( 'rest_api_init', function(){
            $namespace = 'forbidden/v1';
            $rout = '/close-auction-bid/';
            $rout_params = [
                'methods'  => 'POST',
                'callback' => 'closed_auction_bid',
            ];
            register_rest_route( $namespace, $rout, $rout_params );
        });

    }
}