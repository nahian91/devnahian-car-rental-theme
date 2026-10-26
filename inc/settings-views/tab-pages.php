<?php
/**
 * Settings Tab: Pages Settings Container
 * Converted to full page-load architecture with native link navigation.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render the Pages tab and active sub-tab.
 */
function dev_nahian_render_pages_tab_content( $active_subtab = 'home' ) {
    $active_subtab = ! empty( $active_subtab ) ? sanitize_key( $active_subtab ) : 'home';

    $pages_subtabs = array(
        'home'     => __( 'Home', 'dev-nahian-car' ),
        'about'    => __( 'About', 'dev-nahian-car' ),
        'services' => __( 'Services', 'dev-nahian-car' ),
        'cars'     => __( 'Cars', 'dev-nahian-car' ),
        'blogs'    => __( 'Blogs', 'dev-nahian-car' ),
        'contact'  => __( 'Contact', 'dev-nahian-car' ),
        'gallery'  => __( 'Gallery', 'dev-nahian-car' ),
    );
    ?>
    <div id="tab-panel-pages">
        
        <!-- Sub-Tab Navigation Bar (Native Page-Load Links) -->
        <nav class="dev-nahian-subtabs-bar" aria-label="<?php esc_attr_e( 'Pages Sub-tabs', 'dev-nahian-car' ); ?>">
            <?php foreach ( $pages_subtabs as $sub_slug => $sub_label ) : 
                $is_sub_active = ( $active_subtab === $sub_slug ) ? 'is-active' : '';
                $subtab_url    = add_query_arg( array(
                    'page'   => 'dev-nahian-website-settings',
                    'tab'    => 'pages',
                    'subtab' => $sub_slug,
                ), admin_url( 'admin.php' ) );
            ?>
                <a href="<?php echo esc_url( $subtab_url ); ?>" class="dev-nahian-subtab-chip <?php echo esc_attr( $is_sub_active ); ?>">
                    <?php echo esc_html( $sub_label ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <?php
        // Execute the active subtab once
        if ( has_action( 'dev_nahian_render_subtab_' . $active_subtab ) ) {
            do_action( 'dev_nahian_render_subtab_' . $active_subtab );
        } else {
            do_action( 'dev_nahian_render_pages_subtabs', $active_subtab );
        }
        ?>
    </div>
    <?php
}

// Register only to the direct panel hook
add_action( 'dev_nahian_render_tab_panel_pages', 'dev_nahian_render_pages_tab_content', 10, 1 );