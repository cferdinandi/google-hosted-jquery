<?php

/* ======================================================================

    Google-Hosted jQuery Get jQuery
    Get's and registers jQuery file.

 * ====================================================================== */


function ghjquery_use_google_hosted_jquery() {

    // Setup Google URI, default
    $protocol = ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) ? 'https' : 'http';

    // Get version number
    $ver = ghjquery_get_jquery_version_number();

    // Get Specific Version
    $url = $protocol . '://ajax.googleapis.com/ajax/libs/jquery/' . $ver . '/jquery.min.js';

    // Setup WordPress URI
    $wpurl = get_bloginfo( 'wpurl') . '/wp-includes/js/jquery/jquery.js';

    // Deregister WordPress default jQuery
    wp_deregister_script( 'jquery' );

    // Check transient, if false, set URI to WordPress URI
    delete_transient( 'google_jquery' );

    if ( 'false' == ( $google = get_transient( 'google_jquery' ) ) ) {
        $url = $wpurl;
    }
    // Transient failed
    elseif ( false === $google ) {
        // Ping Google
        $resp = wp_remote_head( $url );

        // Use Google jQuery
        if ( ! is_wp_error( $resp ) && 200 == $resp['response']['code'] ) {
            // Set transient for 5 minutes
            set_transient( 'google_jquery', 'true', 60 * 5 );
        }

        // Use WordPress jQuery
        else {
            // Set transient for 5 minutes
            set_transient( 'google_jquery', 'false', 60 * 5 );

            // Use WordPress URI
            $url = $wpurl;

            // Set jQuery Version, WP stanards
            $ver = '1.8.2';
        }
    }

    // Register surefire jQuery
    wp_register_script( 'jquery', $url, array(), $ver, true );

    // Enqueue jQuery
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'ghjquery_use_google_hosted_jquery' );

?>