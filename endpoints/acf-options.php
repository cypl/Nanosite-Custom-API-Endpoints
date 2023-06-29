<?php
/*

GET /wp-json/custom-api/v1/options/all

Retrieves data from acf options pages.

*/
// Callback pour récupérer les données de l'onglet “Customisation du thème”
function acf_options_route() {
    return get_fields('options');
}