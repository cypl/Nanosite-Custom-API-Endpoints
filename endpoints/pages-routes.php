<?php
/*

GET /wp-json/custom-api/v1/pages-routes

Retrieves:
{id: pageid, route: "/pathWithoutDomain"}

*/


// Callback function for pages routes
function get_pages_routes($request) {
    $args = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'fields' => 'ids',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    $pages = array();
    foreach ($query->posts as $post_id) {
        $permalink = str_replace(home_url(), '', get_permalink($post_id));
        $page = array(
            'id' => $post_id,
            //'route' => '/' . get_post_field('post_name', $post_id),
            'route' => $permalink,
        );
        $pages[] = $page;
    }

    return $pages;
}