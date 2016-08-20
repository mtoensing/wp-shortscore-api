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

    $get_shortscore = sanitize_text_field($wp_query->get( 'get_shortscore' ));

    if ( ! $get_shortscore ) {
        return;
    }

    $shortscore_id = $get_shortscore;

    $user_shortscore = get_comment_meta($shortscore_id, 'score', true);
    $user_shortscore_url = get_comment_link($shortscore_id);

    $shortscore = get_comment( $shortscore_id );

    $game_id = $shortscore->comment_post_ID;
    $shortscore_average = get_post_meta($game_id, 'score_value', true);
    $shortscore_count = get_post_meta($game_id, 'score_count', true);
    $game_url = get_post_permalink($game_id);


    $shortscore_data = array(

        "user-shortscore" => array (
            "id" => $shortscore_id,
            "shortscore" => $user_shortscore,
            "url" => $user_shortscore_url
        ),
        "game" => array (
            "id" => $game_id,
            "url" => $game_url,
            "shortscore-average" => $shortscore_average,
            "shortscore-count" => $shortscore_count
        )

    );

    wp_send_json( $shortscore_data );

}
add_action( 'template_redirect', 'get_shortscore_endpoint_data' );