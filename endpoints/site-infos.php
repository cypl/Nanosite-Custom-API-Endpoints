<?php
/*

GET /wp-json/custom-api/v1/site-infos

Retrieves data from WP settings:
{
    "name": "Nom du site",
    "description": "Description du site.",
    "language": "fr_FR"
}

*/
// Callback pour récupérer les données des menus
function get_site_infos() {
    $site_info = array(
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'language' => get_locale()
    );
    return $site_info;
}