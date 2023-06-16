<?php
/*

GET /wp-json/custom-api/v1/bateaux-routes

Retrieves:
{id: postid, route: "/pathWithoutDomain"}

*/


// Callback function for pages routes
function get_bateaux_routes($request) {
    $args = array(
        'post_type' => 'bateau',
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
            'route' => $permalink,
        );
        $pages[] = $page;
    }

    return $pages;
}