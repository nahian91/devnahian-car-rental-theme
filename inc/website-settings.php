<?php
/**
 * Dev Nahian - Complete Website Settings & Section Configuration
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'DEV_NAHIAN_SETTINGS_DIR' ) ) {
    define( 'DEV_NAHIAN_SETTINGS_DIR', plugin_dir_path( __FILE__ ) );
}

// 1. Load Primary Tab Modules (General tab excluded)
$tab_modules = array( 'header', 'footer', 'style', 'seo', 'pages' );
foreach ( $tab_modules as $mod ) {
    $file = DEV_NAHIAN_SETTINGS_DIR . 'settings-views/tab-' . $mod . '.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
}

// 2. Load Sub-Tab Modules inside Pages
$subtab_modules = array( 'home', 'about', 'services', 'cars', 'blogs', 'contact', 'gallery' );
foreach ( $subtab_modules as $smod ) {
    $subfile = DEV_NAHIAN_SETTINGS_DIR . 'settings-views/pages/subtab-' . $smod . '.php';
    if ( file_exists( $subfile ) ) {
        require_once $subfile;
    }
}

/**
 * Register Admin Menu Page
 */
function dev_nahian_settings_admin_menu() {
    add_menu_page(
        esc_html__( 'Website Settings & Config', 'dev-nahian-car' ),
        esc_html__( 'Website Config', 'dev-nahian-car' ),
        'manage_options',
        'dev-nahian-website-settings',
        'dev_nahian_render_full_settings_page',
        'dashicons-admin-generic',
        27
    );
}
add_action( 'admin_menu', 'dev_nahian_settings_admin_menu' );

/**
 * Enqueue Media Scripts
 */
function dev_nahian_settings_admin_assets( $hook ) {
    if ( strpos( $hook, 'dev-nahian-website-settings' ) === false ) {
        return;
    }
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'dev_nahian_settings_admin_assets' );

/**
 * Master Save Dispatcher
 */
function dev_nahian_process_save_website_settings() {
    if ( ! isset( $_POST['dev_nahian_custom_save_trigger'] ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Unauthorized access.', 'dev-nahian-car' ) );
    }

    check_admin_referer( 'dev_nahian_save_website_settings_action', 'dev_nahian_settings_nonce_field' );

    // Triggers save actions in all registered tab & subtab files
    do_action( 'dev_nahian_save_settings_data', $_POST );

    $current_tab    = sanitize_key( $_POST['dev_nahian_active_tab_tracker'] ?? 'header' );
    $current_subtab = sanitize_key( $_POST['dev_nahian_active_subtab_tracker'] ?? 'home' );

    $redirect_args = array(
        'page'             => 'dev-nahian-website-settings',
        'tab'              => $current_tab,
        'settings-updated' => 'true',
    );

    if ( 'pages' === $current_tab ) {
        $redirect_args['subtab'] = $current_subtab;
    }

    wp_safe_redirect( add_query_arg( $redirect_args, admin_url( 'admin.php' ) ) );
    exit;
}
add_action( 'admin_init', 'dev_nahian_process_save_website_settings' );

/**
 * Main Shell Renderer
 */
function dev_nahian_render_full_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $active_tab    = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'header';
    $active_subtab = isset( $_GET['subtab'] ) ? sanitize_key( $_GET['subtab'] ) : 'home';

    $nav_tabs = array(
        'header'  => array( 'label' => __( 'Header', 'dev-nahian-car' ),  'icon' => 'dashicons-heading' ),
        'footer'  => array( 'label' => __( 'Footer', 'dev-nahian-car' ),  'icon' => 'dashicons-editor-contract' ),
        'style'   => array( 'label' => __( 'Style', 'dev-nahian-car' ),   'icon' => 'dashicons-art' ),
        'seo'     => array( 'label' => __( 'SEO', 'dev-nahian-car' ),     'icon' => 'dashicons-search' ),
        'pages'   => array( 'label' => __( 'Pages', 'dev-nahian-car' ),   'icon' => 'dashicons-admin-page' ),
    );
    ?>

    <style>
        .dev-nahian-fullset-wrap { 
            max-width: 1240px; 
            margin: 20px 20px 0 0; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            color: #0f172a; 
        }
        .dev-nahian-alert-success { 
            background: #f0fdf4; 
            border: 1px solid #86efac; 
            color: #166534; 
            padding: 12px 16px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 13.5px; 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
        .dev-nahian-fullset-header { 
            background: #ffffff; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 22px 28px; 
            margin-bottom: 22px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04); 
            flex-wrap: wrap; 
            gap: 12px; 
        }
        .dev-nahian-fullset-header h1 { 
            margin: 0 0 4px; 
            font-size: 20px; 
            font-weight: 800; 
            color: #0f172a; 
            letter-spacing: -0.02em; 
        }
        .dev-nahian-fullset-header p { 
            margin: 0; 
            font-size: 13px; 
            color: #64748b; 
        }

        /* Primary Tabs Navigation */
        .dev-nahian-fullset-tabs { 
            display: flex; 
            gap: 6px; 
            margin-bottom: 22px; 
            border-bottom: 1px solid #e2e8f0; 
            padding-bottom: 12px; 
            flex-wrap: wrap; 
        }
        .dev-nahian-tab-chip { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            padding: 9px 20px; 
            border-radius: 8px; 
            color: #475569; 
            font-size: 13.5px; 
            font-weight: 700; 
            background: #ffffff; 
            border: 1px solid #e2e8f0; 
            text-decoration: none; 
            transition: all 0.15s ease; 
        }
        .dev-nahian-tab-chip:hover { 
            color: #0f172a; 
            border-color: #cbd5e1; 
            background: #f8fafc; 
        }
        .dev-nahian-tab-chip.is-active { 
            background: #0f172a; 
            color: #ffffff; 
            border-color: #0f172a; 
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1); 
        }
        .dev-nahian-tab-chip .dashicons { 
            font-size: 16px; 
            width: 16px; 
            height: 16px; 
        }

        /* Sub-Tabs Navigation */
        .dev-nahian-subtabs-bar { 
            display: flex; 
            gap: 8px; 
            margin-bottom: 24px; 
            padding-bottom: 12px; 
            border-bottom: 1px solid #f1f5f9; 
            flex-wrap: wrap; 
        }
        .dev-nahian-subtab-chip { 
            padding: 6px 14px; 
            border-radius: 6px; 
            font-size: 12.5px; 
            font-weight: 700; 
            color: #64748b; 
            background: #f8fafc; 
            border: 1px solid #e2e8f0; 
            text-decoration: none; 
            transition: all 0.15s ease; 
        }
        .dev-nahian-subtab-chip:hover { 
            color: #0f172a; 
            background: #f1f5f9; 
        }
        .dev-nahian-subtab-chip.is-active { 
            background: #0f172a; 
            color: #ffffff; 
            border-color: #0f172a; 
        }

        /* Surface Card & Isolation Guards */
        .dev-nahian-surface-card { 
            background: #ffffff; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 28px; 
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04); 
            margin-bottom: 22px; 
        }
        
        /* Isolation guard: Never allow inactive panels to display */
        .dev-nahian-tab-panel:not(.is-active) { 
            display: none !important; 
        }
        .dev-nahian-subtab-panel:not(.is-active) { 
            display: none !important; 
        }

        .dev-nahian-grid-2 { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 20px; 
        }
        @media (max-width: 820px) { 
            .dev-nahian-grid-2 { 
                grid-template-columns: 1fr; 
            } 
        }
        .dev-nahian-grid-full { 
            grid-column: 1 / -1; 
        }
        .dev-nahian-field-box { 
            display: flex; 
            flex-direction: column; 
            gap: 6px; 
        }
        .dev-nahian-field-box label { 
            font-size: 11.5px; 
            font-weight: 700; 
            text-transform: capitalize; 
            letter-spacing: 0.05em; 
            color: #475569; 
        }
        .dev-nahian-input, .dev-nahian-select, .dev-nahian-textarea { 
            width: 100%; 
            height: 40px; 
            border: 1px solid #e2e8f0; 
            border-radius: 6px; 
            padding: 0 12px; 
            font-size: 13.5px; 
            color: #0f172a; 
            outline: none; 
            box-sizing: border-box; 
            background: #ffffff; 
            transition: border-color 0.15s ease, box-shadow 0.15s ease; 
        }
        .dev-nahian-textarea { 
            height: 84px; 
            padding: 10px 12px; 
            resize: vertical; 
        }
        .dev-nahian-input:focus, .dev-nahian-select:focus, .dev-nahian-textarea:focus { 
            border-color: #0f172a; 
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06); 
        }
        .dev-nahian-hint { 
            font-size: 11.5px; 
            color: #64748b; 
            margin: 2px 0 0; 
            line-height: 1.4; 
        }
        .dev-nahian-section-legend { 
            font-size: 14px; 
            font-weight: 800; 
            color: #0f172a; 
            margin: 0 0 18px; 
            padding-bottom: 8px; 
            border-bottom: 1px dashed #e2e8f0; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
        .dev-nahian-toggle-bar { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 14px 0; 
            border-bottom: 1px dashed #e2e8f0; 
            gap: 16px; 
        }
        .dev-nahian-toggle-bar:last-child { 
            border-bottom: none; 
            padding-bottom: 0; 
        }
        .dev-nahian-toggle-text { 
            display: flex; 
            flex-direction: column; 
            gap: 2px; 
        }
        .dev-nahian-toggle-text strong { 
            font-size: 13.5px; 
            color: #0f172a; 
        }
        .dev-nahian-toggle-text span { 
            font-size: 12px; 
            color: #64748b; 
        }
        .dev-nahian-switch { 
            position: relative; 
            display: inline-block; 
            width: 44px; 
            height: 24px; 
            flex-shrink: 0; 
        }
        .dev-nahian-switch input { 
            opacity: 0; 
            width: 0; 
            height: 0; 
        }
        .dev-nahian-slider { 
            position: absolute; 
            cursor: pointer; 
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0; 
            background-color: #cbd5e1; 
            transition: .2s; 
            border-radius: 24px; 
        }
        .dev-nahian-slider:before { 
            position: absolute; 
            content: ""; 
            height: 18px; 
            width: 18px; 
            left: 3px; 
            bottom: 3px; 
            background-color: white; 
            transition: .2s; 
            border-radius: 50%; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.15); 
        }
        .dev-nahian-switch input:checked + .dev-nahian-slider { 
            background-color: #0d9488; 
        }
        .dev-nahian-switch input:checked + .dev-nahian-slider:before { 
            transform: translateX(20px); 
        }
        .dev-nahian-media-upload { 
            display: flex; 
            gap: 8px; 
            align-items: center; 
        }
        .dev-nahian-media-btn { 
            background: #f1f5f9; 
            border: 1px solid #cbd5e1; 
            color: #334155; 
            padding: 0 14px; 
            height: 40px; 
            border-radius: 6px; 
            font-size: 12.5px; 
            font-weight: 700; 
            cursor: pointer; 
            white-space: nowrap; 
        }
        .dev-nahian-media-btn:hover { 
            background: #e2e8f0; 
            color: #0f172a; 
        }
        .dev-nahian-color-field { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .dev-nahian-color-picker { 
            width: 44px; 
            height: 40px; 
            padding: 2px; 
            border: 1px solid #e2e8f0; 
            border-radius: 6px; 
            cursor: pointer; 
            background: #fff; 
        }
        .dev-nahian-btn-submit { 
            background: #0f172a !important; 
            border: 1px solid #0f172a !important; 
            color: #ffffff !important; 
            padding: 12px 28px !important; 
            font-weight: 700 !important; 
            border-radius: 6px !important; 
            font-size: 14px !important; 
            cursor: pointer !important; 
            display: inline-block !important; 
        }
        .dev-nahian-btn-submit:hover { 
            background: #1e293b !important; 
        }
    </style>

    <div class="wrap dev-nahian-fullset-wrap">

        <?php if ( isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated'] ) : ?>
            <div class="dev-nahian-alert-success">
                <span class="dashicons dashicons-yes-alt"></span>
                <?php esc_html_e( 'Settings successfully updated and stored in the database.', 'dev-nahian-car' ); ?>
            </div>
        <?php endif; ?>

        <header class="dev-nahian-fullset-header">
            <div>
                <h1><?php esc_html_e( 'Website Settings & Configuration', 'dev-nahian-car' ); ?></h1>
                <p><?php esc_html_e( 'Master control for site identity, navigation menus, styles, SEO directives, and page targets.', 'dev-nahian-car' ); ?></p>
            </div>
            <div>
                <span style="font-size: 11px; font-weight: 700; color: #0d9488; background: #f0fdfa; border: 1px solid #ccfbf1; padding: 5px 12px; border-radius: 999px;">
                    &bull; <?php esc_html_e( 'Config Engine Ready', 'dev-nahian-car' ); ?>
                </span>
            </div>
        </header>

        <!-- Primary Tabs (Page Load Links) -->
        <nav class="dev-nahian-fullset-tabs" aria-label="<?php esc_attr_e( 'Settings Tabs', 'dev-nahian-car' ); ?>">
            <?php foreach ( $nav_tabs as $slug => $meta ) : 
                $is_active = ( $active_tab === $slug ) ? 'is-active' : '';
                $tab_url   = add_query_arg( array(
                    'page' => 'dev-nahian-website-settings',
                    'tab'  => $slug,
                ), admin_url( 'admin.php' ) );

                if ( 'pages' === $slug ) {
                    $tab_url = add_query_arg( 'subtab', $active_subtab, $tab_url );
                }
            ?>
                <a href="<?php echo esc_url( $tab_url ); ?>" class="dev-nahian-tab-chip <?php echo esc_attr( $is_active ); ?>">
                    <span class="dashicons <?php echo esc_attr( $meta['icon'] ); ?>"></span>
                    <?php echo esc_html( $meta['label'] ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <form id="devNahianSettingsForm" method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=dev-nahian-website-settings' ) ); ?>" novalidate>
            <?php wp_nonce_field( 'dev_nahian_save_website_settings_action', 'dev_nahian_settings_nonce_field' ); ?>
            <input type="hidden" name="dev_nahian_custom_save_trigger" value="1">
            <input type="hidden" name="dev_nahian_active_tab_tracker" id="dev_nahian_active_tab_tracker" value="<?php echo esc_attr( $active_tab ); ?>">
            <input type="hidden" name="dev_nahian_active_subtab_tracker" id="dev_nahian_active_subtab_tracker" value="<?php echo esc_attr( $active_subtab ); ?>">

            <div class="dev-nahian-surface-card">
                <?php
                // 1. Direct hook for the active tab (prevents module collisions)
                do_action( 'dev_nahian_render_tab_panel_' . $active_tab, $active_subtab );

                // 2. Generic hook with active tab pass-through for backwards compatibility
                do_action( 'dev_nahian_render_tab_panels', $active_tab, $active_subtab );
                ?>
            </div>

            <p style="margin: 24px 0 0 0;">
                <button type="submit" class="dev-nahian-btn-submit" id="dev_nahian_save_btn">
                    <?php esc_html_e( 'Save Configuration Settings', 'dev-nahian-car' ); ?>
                </button>
            </p>
        </form>
    </div>

    <!-- Media Library Uploader Script -->
    <script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            $(document).on('click', '.dev-nahian-upload-btn, .dev-nahian-media-btn', function(e) {
                e.preventDefault();
                var targetInput = $(this).data('target');
                if (!targetInput) return;

                var customUploader = wp.media({
                    title: '<?php echo esc_js( __( 'Select or Upload Media Asset', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use this Asset', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = customUploader.state().get('selection').first().toJSON();
                    $(targetInput).val(attachment.url).trigger('change');
                }).open();
            });
        });
    })(jQuery);
    </script>
    <?php
}