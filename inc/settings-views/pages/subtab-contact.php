<?php
/**
 * Settings Sub-Tab: Pages > Contact Page Configuration
 * Built with native page-load architecture, professional SaaS UI/UX cards,
 * structured visual grouping, and collapsible accordion cards.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Dedicated Direct Save Handler for Contact Sub-Tab
 */
function dev_nahian_save_subtab_contact_data( $data ) {
    $active_tab    = $data['dev_nahian_active_tab_tracker'] ?? '';
    $active_subtab = $data['dev_nahian_active_subtab_tracker'] ?? '';

    if ( 'pages' !== $active_tab || 'contact' !== $active_subtab ) {
        return;
    }

    // Visibility Switch
    update_option( 'dev_nahian_contact_show_section', isset( $data['dev_nahian_contact_show_section'] ) ? 1 : 0 );

    // 1. Header & Intro
    update_option( 'dev_nahian_contact_badge', sanitize_text_field( $data['dev_nahian_contact_badge'] ?? '' ) );
    update_option( 'dev_nahian_contact_title', wp_kses( $data['dev_nahian_contact_title'] ?? '', array( 'span' => array() ) ) );
    update_option( 'dev_nahian_contact_desc', sanitize_textarea_field( $data['dev_nahian_contact_desc'] ?? '' ) );

    // 2. Direct Channels & Logistics Coordinates
    update_option( 'dev_nahian_contact_phone', sanitize_text_field( $data['dev_nahian_contact_phone'] ?? '' ) );
    update_option( 'dev_nahian_contact_email', sanitize_email( $data['dev_nahian_contact_email'] ?? '' ) );
    update_option( 'dev_nahian_contact_address', sanitize_textarea_field( $data['dev_nahian_contact_address'] ?? '' ) );
    update_option( 'dev_nahian_contact_hours', sanitize_textarea_field( $data['dev_nahian_contact_hours'] ?? '' ) );
    update_option( 'dev_nahian_contact_map_embed', wp_kses( $data['dev_nahian_contact_map_embed'] ?? '', array(
        'iframe' => array(
            'src'             => array(),
            'width'           => array(),
            'height'          => array(),
            'style'           => array(),
            'allowfullscreen' => array(),
            'loading'         => array(),
            'referrerpolicy'  => array(),
        ),
    ) ) );

    // 3. Form Setup
    update_option( 'dev_nahian_contact_form_heading', sanitize_text_field( $data['dev_nahian_contact_form_heading'] ?? '' ) );
    update_option( 'dev_nahian_contact_form_sub', sanitize_textarea_field( $data['dev_nahian_contact_form_sub'] ?? '' ) );
    update_option( 'dev_nahian_contact_recipient', sanitize_email( $data['dev_nahian_contact_recipient'] ?? '' ) );
}
add_action( 'dev_nahian_save_settings_data', 'dev_nahian_save_subtab_contact_data', 10, 1 );

/**
 * 2. Render Sub-Tab Panel
 */
function dev_nahian_render_subtab_contact_panel( $active_subtab ) {
    if ( 'contact' !== $active_subtab ) {
        return;
    }

    $show_section = (int) get_option( 'dev_nahian_contact_show_section', 1 );
    $badge        = get_option( 'dev_nahian_contact_badge', '' );
    $title        = get_option( 'dev_nahian_contact_title', '' );
    $desc         = get_option( 'dev_nahian_contact_desc', '' );

    $phone        = get_option( 'dev_nahian_contact_phone', '' );
    $email        = get_option( 'dev_nahian_contact_email', '' );
    $address      = get_option( 'dev_nahian_contact_address', '' );
    $hours        = get_option( 'dev_nahian_contact_hours', '' );
    $map_embed    = get_option( 'dev_nahian_contact_map_embed', '' );

    $form_heading = get_option( 'dev_nahian_contact_form_heading', '' );
    $form_sub     = get_option( 'dev_nahian_contact_form_sub', '' );
    $recipient    = get_option( 'dev_nahian_contact_recipient', '' );
    ?>
    <style>
        /* Professional SaaS Accordion UI Framework Styles */
        .dn-accordion-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dn-accordion-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px -2px rgba(15, 23, 42, 0.05);
        }
        .dn-accordion-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1px solid transparent;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease;
        }
        .dn-accordion-card.is-open .dn-accordion-header {
            background: #f1f5f9;
            border-bottom-color: #e2e8f0;
        }
        .dn-accordion-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dn-accordion-title-wrap strong {
            font-size: 14.5px;
            font-weight: 800;
            color: #0f172a;
        }
        .dn-accordion-title-wrap span {
            font-size: 12px;
            color: #64748b;
        }
        .dn-accordion-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .dn-accordion-chevron {
            font-size: 16px;
            font-weight: bold;
            color: #64748b;
            transition: transform 0.25s ease;
        }
        .dn-accordion-card.is-open .dn-accordion-chevron {
            transform: rotate(180deg);
        }
        .dn-accordion-body {
            display: none;
            padding: 24px 28px;
            background: #ffffff;
        }
        .dn-accordion-card.is-open .dn-accordion-body {
            display: block;
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
    </style>

    <div id="subtab-panel-contact">

        <!-- SECTION 1: HEADER SETTINGS -->
        <div class="dn-accordion-card is-open">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '1. Header Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Configure badge, headline, and subtitle intro.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_contact_show_section" value="1" <?php checked( $show_section, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_badge"><?php esc_html_e( 'Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_contact_badge" name="dev_nahian_contact_badge" class="dev-nahian-input" value="<?php echo esc_attr( $badge ); ?>" placeholder="e.g. Concierge & Logistics">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_title"><?php esc_html_e( 'Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_contact_title" name="dev_nahian_contact_title" class="dev-nahian-input" value="<?php echo esc_attr( $title ); ?>" placeholder="e.g. Connect with Our <span>Dispatch</span>">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_contact_desc"><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_contact_desc" name="dev_nahian_contact_desc" class="dev-nahian-textarea" placeholder="Enter header subtitle..."><?php echo esc_textarea( $desc ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: CONTACT DETAILS -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '2. Contact Details', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Direct telephone lines, email addresses, and map embeds.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_phone"><?php esc_html_e( 'Phone Number', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_contact_phone" name="dev_nahian_contact_phone" class="dev-nahian-input" value="<?php echo esc_attr( $phone ); ?>" placeholder="+1 (800) 000-0000">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_email"><?php esc_html_e( 'Email Address', 'dev-nahian-car' ); ?></label>
                        <input type="email" id="dev_nahian_contact_email" name="dev_nahian_contact_email" class="dev-nahian-input" value="<?php echo esc_attr( $email ); ?>" placeholder="concierge@example.com">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_address"><?php esc_html_e( 'Address', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_contact_address" name="dev_nahian_contact_address" class="dev-nahian-textarea" placeholder="Office or hangar address..."><?php echo esc_textarea( $address ); ?></textarea>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_hours"><?php esc_html_e( 'Opening Hours', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_contact_hours" name="dev_nahian_contact_hours" class="dev-nahian-textarea" placeholder="Operating hours details..."><?php echo esc_textarea( $hours ); ?></textarea>
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_contact_map_embed"><?php esc_html_e( 'Map Embed Code', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_contact_map_embed" name="dev_nahian_contact_map_embed" class="dev-nahian-textarea" style="height: 90px; font-family: monospace; font-size: 12px;" placeholder="<iframe src='https://www.google.com/maps/embed?...' ...></iframe>"><?php echo esc_textarea( $map_embed ); ?></textarea>
                        <p class="dev-nahian-hint"><?php esc_html_e( 'Paste your Google Maps iframe code here. Leave blank for fallback location card.', 'dev-nahian-car' ); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: FORM SETTINGS -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '3. Form Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Inquiry form headings and destination recipient emails.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_form_heading"><?php esc_html_e( 'Form Heading', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_contact_form_heading" name="dev_nahian_contact_form_heading" class="dev-nahian-input" value="<?php echo esc_attr( $form_heading ); ?>" placeholder="e.g. Send an Operational Inquiry">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_contact_recipient"><?php esc_html_e( 'Notification Email', 'dev-nahian-car' ); ?></label>
                        <input type="email" id="dev_nahian_contact_recipient" name="dev_nahian_contact_recipient" class="dev-nahian-input" value="<?php echo esc_attr( $recipient ); ?>" placeholder="admin@example.com">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_contact_form_sub"><?php esc_html_e( 'Form Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_contact_form_sub" name="dev_nahian_contact_form_sub" class="dev-nahian-textarea" placeholder="Instructions shown under the form heading..."><?php echo esc_textarea( $form_sub ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Accordion Toggle Script -->
    <script id="dn-contact-subtab-scripts">
    (function($) {
        'use strict';
        $(document).ready(function() {
            $(document).on('click', '.dn-accordion-header', function(e) {
                if ($(e.target).closest('.dev-nahian-switch').length) {
                    return;
                }
                var $card = $(this).closest('.dn-accordion-card');
                $card.toggleClass('is-open');
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Single targeted hook registration (prevents duplicate rendering)
add_action( 'dev_nahian_render_subtab_contact', function() {
    dev_nahian_render_subtab_contact_panel( 'contact' );
});