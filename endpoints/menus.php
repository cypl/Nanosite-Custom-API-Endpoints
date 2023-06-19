<?php
/*

GET /wp-json/custom-api/v1/menus

Retrieves data from registered menus (only work for public menu):
[
  {
    "location": "menu-name",
    "items": [
      {
        "title": "Accueil",
        "url": "http://localhost:8888/headless-wp/"
      },
      {
        "title": "Qui sommes-nous",
        "url": "http://localhost:8888/headless-wp/qui-sommes-nous/"
      },
    ]
  }
]

*/
// Callback pour récupérer les données des menus
function get_menus_data() {
    $menus = get_registered_nav_menus();
    $data = array();

    foreach ( $menus as $location => $description ) {
        $items = wp_get_nav_menu_items( $location );

        if ( ! empty( $items ) ) {
            $menu_items = array();

            foreach ( $items as $item ) {
                $menu_items[] = array(
                    'title' => $item->title,
                    'url'   => $item->url,
                );
            }

            $data[] = array(
                'location' => $location,
                'items'    => $menu_items,
            );
        }
    }

    return $data;
}
