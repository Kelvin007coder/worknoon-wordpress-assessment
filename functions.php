<?php
/**
 * Worknoon Landing Theme - functions.php
 *
 * Handles: enqueue scripts/styles, schema markup injection,
 * Google Analytics integration, performance optimizations,
 * and custom Gutenberg blocks registration.
 *
 * @package WorknoonTheme
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'WORKNOON_VERSION', '1.0.0' );
define( 'WORKNOON_DIR', get_stylesheet_directory() );
define( 'WORKNOON_URI', get_stylesheet_directory_uri() );

/* =========================================================
   THEME SETUP
   ========================================================= */
add_action( 'after_setup_theme', 'worknoon_theme_setup' );
function worknoon_theme_setup() {
    // Make theme translation-ready
    load_child_theme_textdomain( 'worknoon-theme', WORKNOON_DIR . '/languages' );

    // Enable post thumbnails / featured images
    add_theme_support( 'post-thumbnails' );

    // Enable HTML5 markup for search forms, comment forms, comments, gallery, caption
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ) );

    // Enable title tag support
    add_theme_support( 'title-tag' );

    // Enable responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Enable wide and full alignment in Gutenberg
    add_theme_support( 'align-wide' );

    // Disable block patterns from core (optional - reduces bloat)
    remove_theme_support( 'core-block-patterns' );

    // Register primary navigation menu
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'worknoon-theme' ),
        'footer'  => __( 'Footer Menu', 'worknoon-theme' ),
    ) );
}

/* =========================================================
   ENQUEUE STYLES & SCRIPTS
   ========================================================= */
add_action( 'wp_enqueue_scripts', 'worknoon_enqueue_assets' );
function worknoon_enqueue_assets() {
    // Google Fonts — Inter & Poppins (preconnect for performance)
    wp_enqueue_style(
        'worknoon-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@700;800&display=swap',
        array(),
        null
    );

    // Parent theme stylesheet
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( get_template() )->get( 'Version' )
    );

    // Child theme stylesheet
    wp_enqueue_style(
        'worknoon-theme',
        WORKNOON_URI . '/style.css',
        array( 'parent-style' ),
        WORKNOON_VERSION
    );

    // Main JS (deferred for performance)
    wp_enqueue_script(
        'worknoon-main',
        WORKNOON_URI . '/assets/js/main.js',
        array(),
        WORKNOON_VERSION,
        true // Load in footer
    );

    // Pass AJAX URL and nonce to JS
    wp_localize_script( 'worknoon-main', 'worknoonData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'worknoon_nonce' ),
        'siteUrl' => get_site_url(),
    ) );
}

/* =========================================================
   GOOGLE ANALYTICS 4 INTEGRATION
   ========================================================= */
add_action( 'wp_head', 'worknoon_google_analytics', 1 );
function worknoon_google_analytics() {
    // Measurement ID — replace with actual GA4 ID
    $measurement_id = get_option( 'worknoon_ga4_id', 'G-XXXXXXXXXX' );

    if ( empty( $measurement_id ) || is_admin() ) {
        return;
    }
    ?>
    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $measurement_id ); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js( $measurement_id ); ?>', {
            'anonymize_ip': true,
            'page_path': window.location.pathname
        });
    </script>
    <?php
}

/* =========================================================
   SCHEMA MARKUP — JSON-LD INJECTION
   ========================================================= */
add_action( 'wp_head', 'worknoon_inject_schema', 5 );
function worknoon_inject_schema() {
    // Organization + WebSite schema (all pages)
    $schema_graph = array(
        '@context' => 'https://schema.org',
        '@graph'   => array(
            // Organization
            array(
                '@type'       => 'Organization',
                '@id'         => home_url( '/#organization' ),
                'name'        => get_bloginfo( 'name' ),
                'url'         => home_url(),
                'logo'        => array(
                    '@type'      => 'ImageObject',
                    '@id'        => home_url( '/#logo' ),
                    'url'        => WORKNOON_URI . '/assets/images/worknoon-logo.png',
                    'caption'    => get_bloginfo( 'name' ),
                    'width'      => 300,
                    'height'     => 60,
                ),
                'sameAs' => array(
                    'https://twitter.com/worknoon',
                    'https://linkedin.com/company/worknoon',
                    'https://facebook.com/worknoon',
                    'https://instagram.com/worknoon',
                    'https://www.crunchbase.com/organization/worknoon',
                ),
                'contactPoint' => array(
                    '@type'           => 'ContactPoint',
                    'contactType'     => 'Customer Support',
                    'email'           => 'careers@worknoon.com',
                    'availableLanguage' => 'English',
                ),
            ),
            // WebSite
            array(
                '@type'     => 'WebSite',
                '@id'       => home_url( '/#website' ),
                'url'       => home_url(),
                'name'      => get_bloginfo( 'name' ),
                'publisher' => array( '@id' => home_url( '/#organization' ) ),
                'potentialAction' => array(
                    '@type'       => 'SearchAction',
                    'target'      => array(
                        '@type'       => 'EntryPoint',
                        'urlTemplate' => home_url( '/?s={search_term_string}' ),
                    ),
                    'query-input' => 'required name=search_term_string',
                ),
                'inLanguage' => 'en-US',
            ),
        ),
    );

    // On the About page: also add Person (Founder) schema
    if ( is_page( 'about' ) ) {
        $schema_graph['@graph'][] = array(
            '@type'     => 'Person',
            '@id'       => home_url( '/#founder' ),
            'name'      => 'Worknoon Founder',
            'jobTitle'  => 'Founder & CEO',
            'worksFor'  => array( '@id' => home_url( '/#organization' ) ),
            'url'       => home_url( '/about' ),
        );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema_graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}

/* =========================================================
   PERFORMANCE OPTIMIZATIONS
   ========================================================= */

// Remove query strings from static assets (cache-busting)
add_filter( 'script_loader_src', 'worknoon_remove_query_strings' );
add_filter( 'style_loader_src',  'worknoon_remove_query_strings' );
function worknoon_remove_query_strings( $src ) {
    if ( strpos( $src, '?ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}

// Disable emoji scripts (saves ~10KB)
add_action( 'init', 'worknoon_disable_emojis' );
function worknoon_disable_emojis() {
    remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles',    'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed',   'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss',   'wp_staticize_emoji' );
    remove_filter( 'wp_mail',            'wp_staticize_emoji_for_email' );
}

// Remove RSD link from head (unneeded)
remove_action( 'wp_head', 'rsd_link' );
// Remove Windows Live Writer link
remove_action( 'wp_head', 'wlwmanifest_link' );
// Remove WordPress version number from head
remove_action( 'wp_head', 'wp_generator' );
// Remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Add preconnect for Google Fonts
add_action( 'wp_head', 'worknoon_preconnect_origins', 1 );
function worknoon_preconnect_origins() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://www.google-analytics.com">' . "\n";
}

// Add resource hints for faster asset loading
add_filter( 'wp_resource_hints', 'worknoon_resource_hints', 10, 2 );
function worknoon_resource_hints( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        $hints[] = '//www.googletagmanager.com';
        $hints[] = '//www.google-analytics.com';
    }
    return $hints;
}

/* =========================================================
   CUSTOM POST TYPE — TESTIMONIALS
   ========================================================= */
add_action( 'init', 'worknoon_register_testimonials_cpt' );
function worknoon_register_testimonials_cpt() {
    $labels = array(
        'name'               => __( 'Testimonials', 'worknoon-theme' ),
        'singular_name'      => __( 'Testimonial', 'worknoon-theme' ),
        'add_new'            => __( 'Add New', 'worknoon-theme' ),
        'add_new_item'       => __( 'Add New Testimonial', 'worknoon-theme' ),
        'edit_item'          => __( 'Edit Testimonial', 'worknoon-theme' ),
        'view_item'          => __( 'View Testimonial', 'worknoon-theme' ),
        'all_items'          => __( 'All Testimonials', 'worknoon-theme' ),
        'search_items'       => __( 'Search Testimonials', 'worknoon-theme' ),
        'not_found'          => __( 'No testimonials found.', 'worknoon-theme' ),
    );

    register_post_type( 'testimonial', array(
        'labels'             => $labels,
        'public'             => false,   // Not publicly accessible
        'show_ui'            => true,    // Show in admin
        'show_in_menu'       => true,
        'show_in_rest'       => true,   // Gutenberg support
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'rewrite'            => false,
    ) );
}

/* =========================================================
   CUSTOM POST TYPE — SERVICES
   ========================================================= */
add_action( 'init', 'worknoon_register_services_cpt' );
function worknoon_register_services_cpt() {
    register_post_type( 'service', array(
        'labels' => array(
            'name'          => __( 'Services', 'worknoon-theme' ),
            'singular_name' => __( 'Service', 'worknoon-theme' ),
            'add_new_item'  => __( 'Add New Service', 'worknoon-theme' ),
            'edit_item'     => __( 'Edit Service', 'worknoon-theme' ),
        ),
        'public'       => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-awards',
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'has_archive'  => true,
        'rewrite'      => array( 'slug' => 'services' ),
    ) );
}

/* =========================================================
   CONTACT FORM AJAX HANDLER
   ========================================================= */
add_action( 'wp_ajax_worknoon_contact',        'worknoon_handle_contact_form' );
add_action( 'wp_ajax_nopriv_worknoon_contact', 'worknoon_handle_contact_form' );
function worknoon_handle_contact_form() {
    // Verify nonce
    check_ajax_referer( 'worknoon_nonce', 'nonce' );

    // Sanitize inputs
    $name    = sanitize_text_field( $_POST['name'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $subject = sanitize_text_field( $_POST['subject'] ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    // Validate
    if ( empty( $name ) || ! is_email( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields with valid information.' ) );
    }

    // Send email
    $to      = get_option( 'admin_email' );
    $subject = sprintf( '[Worknoon] %s', $subject ?: 'New Contact Form Submission' );
    $body    = sprintf(
        "Name: %s\nEmail: %s\n\nMessage:\n%s",
        $name, $email, $message
    );
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        sprintf( 'Reply-To: %s <%s>', $name, $email ),
    );

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Thank you! Your message has been sent.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Message could not be sent. Please try again.' ) );
    }
}

/* =========================================================
   SETTINGS PAGE — GA4 ID
   ========================================================= */
add_action( 'admin_menu', 'worknoon_add_settings_page' );
function worknoon_add_settings_page() {
    add_options_page(
        'Worknoon Settings',
        'Worknoon',
        'manage_options',
        'worknoon-settings',
        'worknoon_render_settings_page'
    );
}

add_action( 'admin_init', 'worknoon_register_settings' );
function worknoon_register_settings() {
    register_setting( 'worknoon_settings', 'worknoon_ga4_id', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    ) );
}

function worknoon_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Worknoon Theme Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'worknoon_settings' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="worknoon_ga4_id">Google Analytics 4 Measurement ID</label></th>
                    <td>
                        <input type="text" id="worknoon_ga4_id" name="worknoon_ga4_id"
                            value="<?php echo esc_attr( get_option( 'worknoon_ga4_id' ) ); ?>"
                            class="regular-text" placeholder="G-XXXXXXXXXX">
                        <p class="description">Enter your GA4 Measurement ID. Found in Google Analytics → Admin → Data Streams.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
