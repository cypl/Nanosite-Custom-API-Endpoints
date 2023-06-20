<?php
/*

GET /wp-json/custom-api/v1/menus

Retrieves data from registered menus (only work for public menu):
[
    {
      "location": "menu-principal",
      "items": [
        {
          "title": "Qui sommes-nous",
          "url": "/qui-sommes-nous/",
          "children": [
            {
              "title": "Ma liste de bateaux",
              "url": "/ma-liste-de-bateaux/",
              "children": []
            },
            {
              "title": "Déclaration d’accessibilité",
              "url": "/declaration-daccessibilite/",
              "children": []
            }
          ]
        },
        {
          "title": "Contact",
          "url": "/contact/",
          "children": []
        },
        {
          "title": "Plan du site",
          "url": "/plan-du-site/",
          "children": []
        }
      ]
    }
  ]

*/
// Callback pour récupérer les données des menus
function get_menus_data() {
    $menus = get_registered_nav_menus();
    $data = array();

    $home_url = home_url(); // Obtenir l'URL de la page d'accueil

    foreach ( $menus as $location => $description ) {
        $items = wp_get_nav_menu_items( $location );

        if ( ! empty( $items ) ) {
            $all_menu_items = array();

            foreach ( $items as $item ) {
                $all_menu_items[] = $item;
            }

            $menu_items = array();

            foreach ( $all_menu_items as $item ) {
                // Vérifier la visibilité de l'élément pour les utilisateurs non connectés
                if ( $item->menu_item_parent == 0 && ( ! is_user_logged_in() || current_user_can( 'read' ) ) ) {
                    $route = str_replace( $home_url, '', $item->url ); // Supprimer l'URL de la page d'accueil de l'URL complète

                    $children = get_menu_item_children( $item->ID, $all_menu_items );

                    $menu_items[] = array(
                        'title'    => $item->title,
                        'url'      => $route,
                        'children' => $children,
                    );
                }
            }

            $data[] = array(
                'location' => $location,
                'items'    => $menu_items,
            );
        }
    }

    return $data;
}

// Fonction récursive pour récupérer les éléments enfants d'un item de menu
function get_menu_item_children( $parent_id, $all_menu_items ) {
    $menu_items = array();
    
    $home_url = home_url(); // Obtenir l'URL de la page d'accueil

    foreach ( $all_menu_items as $item ) {
        if ( $item->menu_item_parent == $parent_id ) {
            $route = str_replace( $home_url, '', $item->url ); // Supprimer l'URL de la page d'accueil de l'URL complète

            $children = get_menu_item_children( $item->ID, $all_menu_items );

            $menu_items[] = array(
                'title'    => $item->title,
                'url'      => $route,
                'children' => $children,
            );
        }
    }

    return $menu_items;
}
