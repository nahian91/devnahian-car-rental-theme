<?php
/**
 * Settings Tab: Footer Settings
 * Built with native page-load architecture, professional SaaS UI/UX,
 * structured visual cards, and polished form fields.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Dedicated Direct Save Handler for Footer Tab
 */
add_action( 'dev_nahian_save_settings_data', function( $data ) {
    if ( ! isset( $data['dev_nahian_active_tab_tracker'] ) || 'footer' !== $data['dev_nahian_active_tab_tracker'] ) {
        return;
    }

    // Identity & Content
    update_option( 'dev_nahian_footer_logo', esc_url_raw( trim( $data['dev_nahian_footer_logo'] ?? '' ) ), false );
    update_option( 'dev_nahian_footer_copyright', wp_kses_post( $data['dev_nahian_footer_copyright'] ?? '' ), false );
    update_option( 'dev_nahian_footer_short_desc', sanitize_textarea_field( $data['dev_nahian_footer_short_desc'] ?? '' ), false );

    // Column Titles
    update_option( 'dev_nahian_footer_col2_title', sanitize_text_field( $data['dev_nahian_footer_col2_title'] ?? '' ), false );
    update_option( 'dev_nahian_footer_col3_title', sanitize_text_field( $data['dev_nahian_footer_col3_title'] ?? '' ), false );
    update_option( 'dev_nahian_footer_col4_title', sanitize_text_field( $data['dev_nahian_footer_col4_title'] ?? '' ), false );

    // Column 4 Contact Items Repeater
    $contact_items = array();
    if ( ! empty( $data['contact_items'] ) && is_array( $data['contact_items'] ) ) {
        foreach ( $data['contact_items'] as $item ) {
            $text = sanitize_text_field( $item['text'] ?? '' );
            $type = sanitize_key( $item['type'] ?? 'custom' );
            $link = sanitize_text_field( $item['link'] ?? '' );

            if ( ! empty( $text ) ) {
                $contact_items[] = array(
                    'type' => $type,
                    'text' => $text,
                    'link' => $link,
                );
            }
        }
    }
    update_option( 'dev_nahian_footer_contact_items', $contact_items, false );

    // Social Links
    update_option( 'dev_nahian_social_fb', esc_url_raw( trim( $data['dev_nahian_social_fb'] ?? '' ) ), false );
    update_option( 'dev_nahian_social_twitter', esc_url_raw( trim( $data['dev_nahian_social_twitter'] ?? '' ) ), false );
    update_option( 'dev_nahian_social_instagram', esc_url_raw( trim( $data['dev_nahian_social_instagram'] ?? '' ) ), false );
    update_option( 'dev_nahian_social_tiktok', esc_url_raw( trim( $data['dev_nahian_social_tiktok'] ?? '' ) ), false );
    update_option( 'dev_nahian_social_linkedin', esc_url_raw( trim( $data['dev_nahian_social_linkedin'] ?? '' ) ), false );
    update_option( 'dev_nahian_social_youtube', esc_url_raw( trim( $data['dev_nahian_social_youtube'] ?? '' ) ), false );
});

/**
 * 2. Render Panel UI
 */
function dev_nahian_render_footer_tab_content( $active_tab = 'footer' ) {
    if ( 'footer' !== $active_tab ) {
        return;
    }

    $footer_logo   = get_option( 'dev_nahian_footer_logo', '' );
    $copyright     = get_option( 'dev_nahian_footer_copyright', '' );
    $short_desc    = get_option( 'dev_nahian_footer_short_desc', '' );
    $col2_title    = get_option( 'dev_nahian_footer_col2_title', '' );
    $col3_title    = get_option( 'dev_nahian_footer_col3_title', '' );
    $col4_title    = get_option( 'dev_nahian_footer_col4_title', '' );
    $contact_items = get_option( 'dev_nahian_footer_contact_items', array() );

    // Fallback: If empty, give an initial blank row ready for input
    if ( empty( $contact_items ) || ! is_array( $contact_items ) ) {
        $contact_items = array(
            array(
                'type' => 'address',
                'text' => '',
                'link' => '',
            ),
        );
    }

    $social_fb = get_option( 'dev_nahian_social_fb', '' );
    $social_tw = get_option( 'dev_nahian_social_twitter', '' );
    $social_ig = get_option( 'dev_nahian_social_instagram', '' );
    $social_tk = get_option( 'dev_nahian_social_tiktok', '' );
    $social_li = get_option( 'dev_nahian_social_linkedin', '' );
    $social_yt = get_option( 'dev_nahian_social_youtube', '' );
    ?>
    <style id="dn-footer-tab-styles">
        .dn-footer-studio-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dn-footer-studio-card:hover {
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
        .dev-nahian-field-box label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            margin-bottom: 6px !important;
        }
        .dev-nahian-input, .dev-nahian-select, .dev-nahian-textarea {
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 0 14px !important;
            font-size: 13.5px !important;
            transition: all 0.2s ease !important;
        }
        .dev-nahian-input:focus, .dev-nahian-select:focus, .dev-nahian-textarea:focus {
            background: #ffffff !important;
            border-color: #0f172a !important;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08) !important;
        }
        .dev-nahian-textarea {
            padding: 10px 14px !important;
        }
        .dn-repeater-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
            margin-bottom: 14px;
        }
        .dn-repeater-row {
            display: grid;
            grid-template-columns: 180px 1.5fr 1fr 40px;
            gap: 10px;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 12px 14px;
            transition: border-color 0.15s ease;
        }
        .dn-repeater-row:hover {
            border-color: #94a3b8;
        }
        @media (max-width: 820px) {
            .dn-repeater-row {
                grid-template-columns: 1fr;
            }
        }
        .dn-btn-repeater-remove {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            height: 38px;
            width: 38px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            line-height: 1;
            transition: all 0.15s ease;
        }
        .dn-btn-repeater-remove:hover {
            background: #fecaca;
            color: #7f1d1d;
        }
        .dn-btn-repeater-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dn-btn-repeater-add:hover {
            background: #f1f5f9;
            border-color: #0f172a;
        }
        .dn-footer-logo-preview-box {
            margin-top: 10px;
            padding: 14px;
            background: #0f172a;
            border-radius: 8px;
            display: inline-block;
            border: 1px solid #334155;
        }
        .dn-footer-logo-img {
            max-height: 44px;
            width: auto;
            display: block;
        }
        .dn-btn-remove-logo {
            background: #fee2e2 !important;
            border-color: #fca5a5 !important;
            color: #b91c1c !important;
        }
        .dn-btn-remove-logo:hover {
            background: #fecaca !important;
            color: #7f1d1d !important;
        }
        .dn-hidden {
            display: none !important;
        }
    </style>

    <div id="tab-panel-footer">

        <!-- Active Tab Tracker (Required for Save Handler) -->
        <input type="hidden" name="dev_nahian_active_tab_tracker" value="footer">

        <!-- CARD 1: FOOTER IDENTITY & COLUMN TITLES -->
        <div class="dn-footer-studio-card">
            <div class="dn-studio-card-header">
                <h3 class="dn-studio-card-title">
                    <span class="dashicons dashicons-editor-contract"></span>
                    <?php esc_html_e( 'Footer Identity & Column Architecture', 'dev-nahian-car' ); ?>
                </h3>
            </div>

            <div class="dev-nahian-grid-2" style="margin-bottom: 20px;">
                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_footer_logo"><?php esc_html_e( 'Footer Logo Asset', 'dev-nahian-car' ); ?></label>
                    <div class="dev-nahian-media-upload">
                        <input type="text" id="dev_nahian_footer_logo" name="dev_nahian_footer_logo" class="dev-nahian-input" value="<?php echo esc_attr( $footer_logo ); ?>" placeholder="https://example.com/footer-logo.svg">
                        <button type="button" class="dev-nahian-media-btn" id="dn_upload_footer_logo_btn"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                        <button type="button" class="dev-nahian-media-btn dn-btn-remove-logo <?php echo empty( $footer_logo ) ? 'dn-hidden' : ''; ?>" id="dn_remove_footer_logo_btn"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                    </div>
                    <p class="dev-nahian-hint"><?php esc_html_e( 'Brand logo rendered inside the footer section.', 'dev-nahian-car' ); ?></p>

                    <!-- Live Logo Preview -->
                    <div id="dn_footer_logo_preview_wrap" class="dn-footer-logo-preview-box <?php echo empty( $footer_logo ) ? 'dn-hidden' : ''; ?>">
                        <img id="dn_footer_logo_preview" class="dn-footer-logo-img" src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php esc_attr_e( 'Footer Logo Preview', 'dev-nahian-car' ); ?>">
                    </div>
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_footer_copyright"><?php esc_html_e( 'Copyright Notice', 'dev-nahian-car' ); ?></label>
                    <input type="text" id="dev_nahian_footer_copyright" name="dev_nahian_footer_copyright" class="dev-nahian-input" value="<?php echo esc_attr( $copyright ); ?>" placeholder="e.g. © 2026 Dev Nahian. All rights reserved.">
                    <p class="dev-nahian-hint"><?php esc_html_e( 'Displayed in the bottom footer bar. HTML tags permitted.', 'dev-nahian-car' ); ?></p>
                </div>

                <div class="dev-nahian-field-box dev-nahian-grid-full">
                    <label for="dev_nahian_footer_short_desc"><?php esc_html_e( 'Short Brand Description', 'dev-nahian-car' ); ?></label>
                    <textarea id="dev_nahian_footer_short_desc" name="dev_nahian_footer_short_desc" class="dev-nahian-textarea" placeholder="<?php esc_attr_e( 'Brief summary of your company displayed below the footer logo...', 'dev-nahian-car' ); ?>"><?php echo esc_textarea( $short_desc ); ?></textarea>
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_footer_col2_title"><?php esc_html_e( 'Column 2 Title', 'dev-nahian-car' ); ?></label>
                    <input type="text" id="dev_nahian_footer_col2_title" name="dev_nahian_footer_col2_title" class="dev-nahian-input" value="<?php echo esc_attr( $col2_title ); ?>" placeholder="e.g. Navigation">
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_footer_col3_title"><?php esc_html_e( 'Column 3 Title', 'dev-nahian-car' ); ?></label>
                    <input type="text" id="dev_nahian_footer_col3_title" name="dev_nahian_footer_col3_title" class="dev-nahian-input" value="<?php echo esc_attr( $col3_title ); ?>" placeholder="e.g. Client Portal">
                </div>

                <div class="dev-nahian-field-box dev-nahian-grid-full">
                    <label for="dev_nahian_footer_col4_title"><?php esc_html_e( 'Column 4 Title', 'dev-nahian-car' ); ?></label>
                    <input type="text" id="dev_nahian_footer_col4_title" name="dev_nahian_footer_col4_title" class="dev-nahian-input" value="<?php echo esc_attr( $col4_title ); ?>" placeholder="e.g. Headquarters & Concierge">
                </div>
            </div>
        </div>

        <!-- CARD 2: COLUMN 4 CONTACT DETAILS REPEATER -->
        <div class="dn-footer-studio-card">
            <div class="dn-studio-card-header">
                <h3 class="dn-studio-card-title">
                    <span class="dashicons dashicons-location"></span>
                    <?php esc_html_e( 'Column 4 Contact & Concierge Items', 'dev-nahian-car' ); ?>
                </h3>
            </div>
            <p class="dev-nahian-hint" style="margin-bottom: 14px;"><?php esc_html_e( 'Configure dynamic contact lines, phone numbers, addresses, and hours displayed in footer column 4.', 'dev-nahian-car' ); ?></p>

            <div class="dn-repeater-list" id="dn_contact_repeater_list">
                <?php foreach ( $contact_items as $idx => $c_item ) : 
                    $c_type = sanitize_key( $c_item['type'] ?? 'custom' );
                    $c_text = sanitize_text_field( $c_item['text'] ?? '' );
                    $c_link = sanitize_text_field( $c_item['link'] ?? '' );
                ?>
                    <div class="dn-repeater-row">
                        <select name="contact_items[<?php echo esc_attr( (string) $idx ); ?>][type]" class="dev-nahian-select">
                            <option value="address" <?php selected( $c_type, 'address' ); ?>><?php esc_html_e( 'Address / Location', 'dev-nahian-car' ); ?></option>
                            <option value="phone" <?php selected( $c_type, 'phone' ); ?>><?php esc_html_e( 'Phone Number', 'dev-nahian-car' ); ?></option>
                            <option value="email" <?php selected( $c_type, 'email' ); ?>><?php esc_html_e( 'Email Address', 'dev-nahian-car' ); ?></option>
                            <option value="hours" <?php selected( $c_type, 'hours' ); ?>><?php esc_html_e( 'Working Hours', 'dev-nahian-car' ); ?></option>
                            <option value="custom" <?php selected( $c_type, 'custom' ); ?>><?php esc_html_e( 'Custom Text', 'dev-nahian-car' ); ?></option>
                        </select>
                        <input type="text" name="contact_items[<?php echo esc_attr( (string) $idx ); ?>][text]" class="dev-nahian-input" value="<?php echo esc_attr( $c_text ); ?>" placeholder="<?php esc_attr_e( 'Display Text / Address / Phone', 'dev-nahian-car' ); ?>">
                        <input type="text" name="contact_items[<?php echo esc_attr( (string) $idx ); ?>][link]" class="dev-nahian-input" value="<?php echo esc_attr( $c_link ); ?>" placeholder="<?php esc_attr_e( 'Optional Link (tel:, mailto:, https://)', 'dev-nahian-car' ); ?>">
                        <button type="button" class="dn-btn-repeater-remove" onclick="dnRemoveContactRow(this);" title="<?php esc_attr_e( 'Remove Row', 'dev-nahian-car' ); ?>">&times;</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="dn-btn-repeater-add" onclick="dnAddContactRow();">
                <span class="dashicons dashicons-plus-alt2" style="font-size: 16px; line-height: 22px;"></span> <?php esc_html_e( 'Add Contact Line', 'dev-nahian-car' ); ?>
            </button>
        </div>

        <!-- CARD 3: SOCIAL MEDIA PROFILES -->
        <div class="dn-footer-studio-card">
            <div class="dn-studio-card-header">
                <h3 class="dn-studio-card-title">
                    <span class="dashicons dashicons-share"></span>
                    <?php esc_html_e( 'Social Media Profiles', 'dev-nahian-car' ); ?>
                </h3>
            </div>
            
            <div class="dev-nahian-grid-2">
                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_social_fb"><?php esc_html_e( 'Facebook URL', 'dev-nahian-car' ); ?></label>
                    <input type="url" id="dev_nahian_social_fb" name="dev_nahian_social_fb" class="dev-nahian-input" value="<?php echo esc_attr( $social_fb ); ?>" placeholder="https://facebook.com/yourbrand">
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_social_twitter"><?php esc_html_e( 'Twitter / X URL', 'dev-nahian-car' ); ?></label>
                    <input type="url" id="dev_nahian_social_twitter" name="dev_nahian_social_twitter" class="dev-nahian-input" value="<?php echo esc_attr( $social_tw ); ?>" placeholder="https://x.com/yourbrand">
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_social_instagram"><?php esc_html_e( 'Instagram URL', 'dev-nahian-car' ); ?></label>
                    <input type="url" id="dev_nahian_social_instagram" name="dev_nahian_social_instagram" class="dev-nahian-input" value="<?php echo esc_attr( $social_ig ); ?>" placeholder="https://instagram.com/yourbrand">
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_social_tiktok"><?php esc_html_e( 'TikTok URL', 'dev-nahian-car' ); ?></label>
                    <input type="url" id="dev_nahian_social_tiktok" name="dev_nahian_social_tiktok" class="dev-nahian-input" value="<?php echo esc_attr( $social_tk ); ?>" placeholder="https://tiktok.com/@yourbrand">
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_social_linkedin"><?php esc_html_e( 'LinkedIn URL', 'dev-nahian-car' ); ?></label>
                    <input type="url" id="dev_nahian_social_linkedin" name="dev_nahian_social_linkedin" class="dev-nahian-input" value="<?php echo esc_attr( $social_li ); ?>" placeholder="https://linkedin.com/company/yourbrand">
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_social_youtube"><?php esc_html_e( 'YouTube URL', 'dev-nahian-car' ); ?></label>
                    <input type="url" id="dev_nahian_social_youtube" name="dev_nahian_social_youtube" class="dev-nahian-input" value="<?php echo esc_attr( $social_yt ); ?>" placeholder="https://youtube.com/@yourbrand">
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts with Direct Global Handlers -->
    <script id="dn-footer-scripts-js">
        function dnAddContactRow() {
            var container = document.getElementById('dn_contact_repeater_list');
            if (!container) return;

            var index = Date.now();
            var row = document.createElement('div');
            row.className = 'dn-repeater-row';
            row.innerHTML = `
                <select name="contact_items[${index}][type]" class="dev-nahian-select">
                    <option value="address"><?php echo esc_js( __( 'Address / Location', 'dev-nahian-car' ) ); ?></option>
                    <option value="phone"><?php echo esc_js( __( 'Phone Number', 'dev-nahian-car' ) ); ?></option>
                    <option value="email"><?php echo esc_js( __( 'Email Address', 'dev-nahian-car' ) ); ?></option>
                    <option value="hours"><?php echo esc_js( __( 'Working Hours', 'dev-nahian-car' ) ); ?></option>
                    <option value="custom" selected><?php echo esc_js( __( 'Custom Text', 'dev-nahian-car' ) ); ?></option>
                </select>
                <input type="text" name="contact_items[${index}][text]" class="dev-nahian-input" placeholder="<?php echo esc_js( __( 'Display Text / Address / Phone', 'dev-nahian-car' ) ); ?>">
                <input type="text" name="contact_items[${index}][link]" class="dev-nahian-input" placeholder="<?php echo esc_js( __( 'Optional Link (tel:, mailto:, https://)', 'dev-nahian-car' ) ); ?>">
                <button type="button" class="dn-btn-repeater-remove" onclick="dnRemoveContactRow(this);" title="<?php echo esc_js( __( 'Remove Row', 'dev-nahian-car' ) ); ?>">&times;</button>
            `;
            container.appendChild(row);
            row.querySelector('input[type="text"]').focus();
        }

        function dnRemoveContactRow(button) {
            var row = button.closest('.dn-repeater-row');
            if (row) {
                row.remove();
            }
        }

        // WordPress Media Uploader for Footer Logo
        jQuery(document).ready(function($) {
            $('#dn_upload_footer_logo_btn').on('click', function(e) {
                e.preventDefault();

                var mediaFrame = wp.media({
                    title: '<?php echo esc_js( __( 'Select or Upload Footer Logo', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use as Footer Logo', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                });

                mediaFrame.on('select', function() {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    $('#dev_nahian_footer_logo').val(attachment.url);
                    $('#dn_footer_logo_preview').attr('src', attachment.url);
                    $('#dn_footer_logo_preview_wrap').removeClass('dn-hidden').show();
                    $('#dn_remove_footer_logo_btn').removeClass('dn-hidden').show();
                });

                mediaFrame.open();
            });

            $('#dn_remove_footer_logo_btn').on('click', function(e) {
                e.preventDefault();
                $('#dev_nahian_footer_logo').val('');
                $('#dn_footer_logo_preview').attr('src', '');
                $('#dn_footer_logo_preview_wrap').hide();
                $(this).hide();
            });
        });
    </script>
    <?php
}

// Hook registration
add_action( 'dev_nahian_render_tab_panel_footer', 'dev_nahian_render_footer_tab_content', 10, 1 );
add_action( 'dev_nahian_render_tab_panels', function( $active_tab ) {
    dev_nahian_render_footer_tab_content( $active_tab );
}, 10, 1 );