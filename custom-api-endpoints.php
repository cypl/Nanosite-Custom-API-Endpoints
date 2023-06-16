<?php
/*
Plugin Name: Nanosite Custom API Endpoints
Description: Adds custom API endpoints to retrieve data from Nanosite.
Author: Cyrille Plenchette
Version: 1.0
*/

// Routes
require_once plugin_dir_path(__FILE__) . 'endpoints/pages-routes.php';
require_once plugin_dir_path(__FILE__) . 'endpoints/posts-routes.php';
require_once plugin_dir_path(__FILE__) . 'endpoints/bateaux-routes.php'; // = Custom Post Type

// Register custom API endpoints
function custom_api_endpoints_init() {
    register_rest_route('custom-api/v1', '/pages-routes', array(
        'methods' => 'GET',
        'callback' => 'get_pages_routes',
    ));
	register_rest_route('custom-api/v1', '/posts-routes', array(
        'methods' => 'GET',
        'callback' => 'get_posts_routes',
    ));
	register_rest_route('custom-api/v1', '/bateaux-routes', array(
        'methods' => 'GET',
        'callback' => 'get_bateaux_routes',
    ));
}
add_action('rest_api_init', 'custom_api_endpoints_init');
