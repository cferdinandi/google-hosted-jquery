<?php

/* ======================================================================

    Plugin Name: Google-Hosted jQuery
    Plugin URI: http://github.com/cferdinandi/google-hosted-jquery
    Description: Use the Google CDN version of jQuery in WordPress, with a local fallback. Change the default jQuery version under <a href="options-general.php?page=ghjquery_theme_options">Settings &rarr; Google CDN jQuery</a>.
    Version: 1.1
    Author: Chris Ferdinandi
    Author URI: http://gomakethings.com
    License: MIT

    Forked from Travis Smith's script on GitHub.
    https://gist.github.com/wpsmith/4083811

 * ====================================================================== */

require_once( dirname( __FILE__) . '/ghjquery-options.php' );
require_once( dirname( __FILE__) . '/ghjquery-get-jquery.php' );

?>