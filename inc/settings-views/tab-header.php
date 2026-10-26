<?php
/**
 * Settings Tab: Header Settings
 * Converted to full page-load architecture with professional SaaS UI/UX,
 * clean visual grouping, and polished form fields.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handle form save for the Header tab.
 */
add_action( 'dev_nahian_save_settings_data', function( $data ) {
    if ( ! isset( $data['dev_nahian_active_tab_tracker'] ) || 'header' !== $data['dev_nahian_active_tab_tracker'] ) {
        return;
    }

    // Save Logo URL
    update_option( 'dev_nahian_site_logo', esc_url_raw( trim( $data['dev_nahian_site_logo'] ?? '' ) ) );

    $show_topbar = isset( $data['dev_nahian_header_show_topbar'] ) ? 1 : 0;
    update_option( 'dev_nahian_header_show_topbar', $show_topbar );

    if ( $show_topbar ) {
        update_option( 'dev_nahian_contact_phone', sanitize_text_field( $data['dev_nahian_contact_phone'] ?? '' ) );
        update_option( 'dev_nahian_contact_email', sanitize_email( $data['dev_nahian_contact_email'] ?? '' ) );
        update_option( 'dev_nahian_contact_hours', sanitize_textarea_field( $data['dev_nahian_contact_hours'] ?? '' ) );
        update_option( 'dev_nahian_contact_address', sanitize_textarea_field( $data['dev_nahian_contact_address'] ?? '' ) );
    }
});

/**
 * Render the Header settings view on page reload.
 */
add_action( 'dev_nahian_render_tab_panels', function( $active_tab ) {
    if ( 'header' !== $active_tab ) {
        return;
    }

    // Ensure WordPress media uploader scripts are active
    wp_enqueue_media();

    $logo_url    = get_option( 'dev_nahian_site_logo', '' );
    $show_topbar = (int) get_option( 'dev_nahian_header_show_topbar', 1 );
    $phone       = get_option( 'dev_nahian_contact_phone', '+1 (800) 456-7890' );
    $email       = get_option( 'dev_nahian_contact_email', 'concierge@velocefleet.com' );
    $hours       = get_option( 'dev_nahian_contact_hours', '24/7 Dispatch' );
    $address     = get_option( 'dev_nahian_contact_address', "750 Lexington Ave, 24th Fl\nNew York, NY 10022" );
    ?>

    <style>
        .dn-header-studio-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dn-header-studio-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px -2px rgba(15, 23, 42, 0.05);
        }
        .dn-studio-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .dn-studio-card-title {
            font-size: 14.5px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.01em;
        }
        .dn-studio-card-title .dashicons {
            color: #0d9488;
            font-size: 18px;
            width: 18px;
            height: 18px;
        }
        .dn-field-box label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            margin-bottom: 6px !important;
        }
        .dev-nahian-input, .dev-nahian-textarea {
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 0 14px !important;
            font-size: 13.5px !important;
            transition: all 0.2s ease !important;
        }
        .dev-nahian-input:focus, .dev-nahian-textarea:focus {
            background: #ffffff !important;
            border-color: #0f172a !important;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08) !important;
        }
        .dev-nahian-textarea {
            padding: 10px 14px !important;
        }
    </style>

    <div id="tab-panel-header">

        <!-- SECTION 1: BRAND LOGO SETUP -->
        <div class="dn-header-studio-card">
            <div class="dn-studio-card-header">
                <h3 class="dn-studio-card-title">
                    <span class="dashicons dashicons-format-image"></span>
                    <?php esc_html_e( 'Master Header Brand Identity', 'dev-nahian-car' ); ?>
                </h3>
            </div>

            <div class="dev-nahian-grid-2">
                <div class="dev-nahian-field-box dev-nahian-grid-full">
                    <label for="dev_nahian_site_logo"><?php esc_html_e( 'Header Brand Logo Asset', 'dev-nahian-car' ); ?></label>
                    <div class="dev-nahian-media-upload">
                        <input type="text" id="dev_nahian_site_logo" name="dev_nahian_site_logo" class="dev-nahian-input dn-header-logo-url" value="<?php echo esc_attr( $logo_url ); ?>" placeholder="https://example.com/logo.png">
                        <button type="button" class="dev-nahian-media-btn dn-header-upload-btn"><?php esc_html_e( 'Upload Logo', 'dev-nahian-car' ); ?></button>
                        <button type="button" class="dev-nahian-media-btn dn-header-remove-btn" style="<?php echo empty( $logo_url ) ? 'display:none;' : ''; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                    </div>
                    <div class="dn-header-preview-wrap" style="<?php echo empty( $logo_url ) ? 'display:none;' : ''; ?> margin-top: 10px;">
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="Logo Preview" class="dn-header-preview-img" style="height: 44px; width: auto; border-radius: 6px; border: 1px solid #cbd5e1; background: #0f172a; padding: 6px 12px; object-fit: contain;">
                    </div>
                    <p class="dev-nahian-hint" style="margin-top: 6px;">
                        <?php esc_html_e( 'Recommended format: Transparent PNG or SVG (max height 48px). If left blank, the site title text is rendered.', 'dev-nahian-car' ); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- SECTION 2: TOPBAR CONFIGURATION -->
        <div class="dn-header-studio-card">
            <div class="dn-studio-card-header">
                <h3 class="dn-studio-card-title">
                    <span class="dashicons dashicons-editor-kitchensink"></span>
                    <?php esc_html_e( 'Header Topbar Configuration', 'dev-nahian-car' ); ?>
                </h3>
            </div>

            <div class="dev-nahian-toggle-bar" style="margin-bottom: 24px;">
                <div class="dev-nahian-toggle-text">
                    <strong><?php esc_html_e( 'Show Topbar Strip?', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Display the secondary notification strip above the primary navigation bar.', 'dev-nahian-car' ); ?></span>
                </div>
                <label class="dev-nahian-switch">
                    <input type="checkbox" id="dev_nahian_header_show_topbar" name="dev_nahian_header_show_topbar" value="1" <?php checked( $show_topbar, 1 ); ?>>
                    <span class="dev-nahian-slider"></span>
                </label>
            </div>

            <!-- Conditional Fields Container -->
            <div id="dev_nahian_topbar_fields_wrap" style="<?php echo ( $show_topbar === 1 ) ? 'display: block;' : 'display: none;'; ?>">
                <h4 style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.08em; margin: 0 0 16px;">
                    <?php esc_html_e( 'Topbar Contact & Dispatch Coordinates', 'dev-nahian-car' ); ?>
                </h4>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_phone"><?php esc_html_e( 'Direct Phone Line', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_contact_phone" name="dev_nahian_contact_phone" class="dev-nahian-input" value="<?php echo esc_attr( $phone ); ?>" placeholder="+1 (800) 456-7890">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_email"><?php esc_html_e( 'Concierge Email Address', 'dev-nahian-car' ); ?></label>
                        <input type="email" id="dev_nahian_contact_email" name="dev_nahian_contact_email" class="dev-nahian-input" value="<?php echo esc_attr( $email ); ?>" placeholder="concierge@velocefleet.com">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_hours"><?php esc_html_e( 'Operating / Dispatch Hours', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_contact_hours" name="dev_nahian_contact_hours" class="dev-nahian-input" value="<?php echo esc_attr( $hours ); ?>" placeholder="24/7 Priority Dispatch">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_address"><?php esc_html_e( 'Primary Location / Address', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_contact_address" name="dev_nahian_contact_address" class="dev-nahian-textarea" style="height: 40px; min-height: 40px; padding: 8px 14px;" placeholder="750 Lexington Ave, New York, NY"><?php echo esc_textarea( $address ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle & Media Uploader Script -->
    <script id="dn-header-settings-js">
    (function($) {
        'use strict';

        $(document).ready(function() {
            // Topbar Switch Toggle Behavior
            var topbarCheckbox = document.getElementById('dev_nahian_header_show_topbar');
            var fieldsContainer = document.getElementById('dev_nahian_topbar_fields_wrap');

            if (topbarCheckbox && fieldsContainer) {
                topbarCheckbox.addEventListener('change', function() {
                    fieldsContainer.style.display = this.checked ? 'block' : 'none';
                });
            }

            // Header Logo Media Uploader Frame
            $('.dn-header-upload-btn').on('click', function(e) {
                e.preventDefault();
                var wrap = $(this).closest('.dev-nahian-field-box');
                var uploader = wp.media({
                    title: '<?php echo esc_js( __( 'Select Brand Logo Asset', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use Logo', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    wrap.find('.dn-header-logo-url').val(attachment.url);
                    wrap.find('.dn-header-preview-img').attr('src', attachment.url);
                    wrap.find('.dn-header-preview-wrap').show();
                    wrap.find('.dn-header-remove-btn').show();
                }).open();
            });

            $('.dn-header-remove-btn').on('click', function(e) {
                e.preventDefault();
                var wrap = $(this).closest('.dev-nahian-field-box');
                wrap.find('.dn-header-logo-url').val('');
                wrap.find('.dn-header-preview-img').attr('src', '');
                wrap.find('.dn-header-preview-wrap').hide();
                $(this).hide();
            });
        });
    })(jQuery);
    </script>
    <?php
});