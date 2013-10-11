<?php

/* ======================================================================

    Google-Hosted jQuery Options
    Let's user specify version number

 * ====================================================================== */


/* ======================================================================
    THEME OPTION FIELDS
    Create the theme option fields.
 * ====================================================================== */

// Create sample text input field
function ghjquery_settings_field_version_number() {
    $options = ghjquery_get_theme_options();
    ?>
    <input type="text" name="ghjquery_theme_options[version_number]" id="version-number" value="<?php echo esc_attr( $options['version_number'] ); ?>" /><br />
    <label class="description" for="version-number"><?php _e( 'Default: <code>1.9.1</code>', 'imgcs' ); ?></label>
    <?php
}





/* ======================================================================
    THEME OPTIONS MENU
    Create the theme options menu.
 * ====================================================================== */

// Register the theme options page and its fields
function ghjquery_theme_options_init() {
    register_setting(
        'ghjquery_options', // Options group, see settings_fields() call in ghjquery_theme_options_render_page()
        'ghjquery_theme_options', // Database option, see ghjquery_get_theme_options()
        'ghjquery_theme_options_validate' // The sanitization callback, see ghjquery_theme_options_validate()
    );

    // Register our settings field group
    add_settings_section(
        'general', // Unique identifier for the settings section
        '', // Section title (we don't want one)
        '__return_false', // Section callback (we don't want anything)
        'ghjquery_theme_options' // Menu slug, used to uniquely identify the page; see ghjquery_theme_options_add_page()
    );

    // Register our individual settings fields
    // add_settings_field( $id, $title, $callback, $page, $section );
    // $id - Unique identifier for the field.
    // $title - Setting field title.
    // $callback - Function that creates the field (from the Theme Option Fields section).
    // $page - The menu page on which to display this field.
    // $section - The section of the settings page in which to show the field.

    add_settings_field( 'version_number', 'jQuery Version #', 'ghjquery_settings_field_version_number', 'ghjquery_theme_options', 'general' );
}
add_action( 'admin_init', 'ghjquery_theme_options_init' );



// Create theme options menu
// The content that's rendered on the menu page.
function ghjquery_theme_options_render_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php _e( 'Google CDN jQuery Options', 'ghjquery' ); ?></h2>

        <form method="post" action="options.php">
            <?php
                settings_fields( 'ghjquery_options' );
                do_settings_sections( 'ghjquery_theme_options' );
                submit_button();
            ?>
        </form>
    </div>
    <?php
}



// Add the theme options page to the admin menu
function ghjquery_theme_options_add_page() {
    $theme_page = add_submenu_page(
        'options-general.php', // parent slug
        'Google CDN jQuery', // Label in menu
        'Google CDN jQuery', // Label in menu
        'edit_theme_options', // Capability required
        'ghjquery_theme_options', // Menu slug, used to uniquely identify the page
        'ghjquery_theme_options_render_page' // Function that renders the options page
    );
}
add_action( 'admin_menu', 'ghjquery_theme_options_add_page' );



// Restrict access to the theme options page to admins
function ghjquery_option_page_capability( $capability ) {
    return 'edit_theme_options';
}
add_filter( 'option_page_capability_ghjquery_options', 'ghjquery_option_page_capability' );







/* ======================================================================
    PROCESS THEME OPTIONS
    Process and save updates to the theme options.

    Each option field requires a default value under ghjquery_get_theme_options(),
    and an if statement under ghjquery_theme_options_validate();
 * ====================================================================== */

// Get the current options from the database.
// If none are specified, use these defaults.
function ghjquery_get_theme_options() {
    $saved = (array) get_option( 'ghjquery_theme_options' );
    $defaults = array(
        'version_number'     => '',
    );

    $defaults = apply_filters( 'ghjquery_default_theme_options', $defaults );

    $options = wp_parse_args( $saved, $defaults );
    $options = array_intersect_key( $options, $defaults );

    return $options;
}



// Sanitize and validate updated theme options
function ghjquery_theme_options_validate( $input ) {
    $output = array();

    // The sample text input must be safe text with no HTML tags
    if ( isset( $input['version_number'] ) && ! empty( $input['version_number'] ) )
        $output['version_number'] = wp_filter_nohtml_kses( $input['version_number'] );

    return apply_filters( 'ghjquery_theme_options_validate', $output, $input );
}



// Get jQuery Version Number
function ghjquery_get_jquery_version_number() {
    $options = ghjquery_get_theme_options();
    if ( $options['version_number'] == '' ) {
        $setting = '1.9.1';
    } else {
        $setting = $options['version_number'];
    }
    return $setting;
}

?>