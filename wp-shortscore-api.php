<?php
/**
 * Plugin Name: WP SHORTSCORE API
 * Plugin URI: http://shortscore.org
 * Description: Retreive SHORTSCORE data by providing a shortscore ID: `?get_shortscore=1`
 * Author: MarcDK
 * Author URI: http://marc.tv
 * Version: 0.0.1
 * License: GPLv2
 */


/**
 * Rewrite an endpoint to get shortscore data
 */
function get_shortscore_endpoint() {

    add_rewrite_tag( '%get_shortscore%', '([^&]+)' );
    add_rewrite_rule( 'gifs/([^&]+)/?', 'index.php?get_shortscore=$matches[1]', 'top' );

}
add_action( 'init', 'get_shortscore_endpoint' );

/**
 * Pass through the data to the endpoint.
 */
function get_shortscore_endpoint_data() {

    global $wp_query;

    $get_shortscore = $wp_query->get( 'get_shortscore' );

    if ( ! $get_shortscore ) {
        return;
    }


    $shortscore = get_comment( $get_shortscore );
    $game_id = $shortscore->comment_post_ID ;

    $shortscore_data = array(
        'game' => $game_id
    );

    wp_send_json( $shortscore_data );

}
add_action( 'template_redirect', 'get_shortscore_endpoint_data' );