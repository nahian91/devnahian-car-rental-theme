<?php
/**
 * Settings Sub-Tab: Pages > Services Configuration
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
 * 1. Dedicated Direct Save Handler for Services Sub-Tab
 */
function dev_nahian_save_subtab_services_data( $data ) {
    $active_tab    = $data['dev_nahian_active_tab_tracker'] ?? '';
    $active_subtab = $data['dev_nahian_active_subtab_tracker'] ?? '';

    if ( 'pages' !== $active_tab || 'services' !== $active_subtab ) {
        return;
    }

    // Visibility Switch
    update_option( 'dev_nahian_services_show_section', isset( $data['dev_nahian_services_show_section'] ) ? 1 : 0 );

    // Header section options
    update_option( 'dev_nahian_services_badge', sanitize_text_field( $data['dev_nahian_services_badge'] ?? '' ) );
    update_option( 'dev_nahian_services_title', wp_kses( $data['dev_nahian_services_title'] ?? '', array( 'span' => array() ) ) );
    update_option( 'dev_nahian_services_desc', sanitize_textarea_field( $data['dev_nahian_services_desc'] ?? '' ) );

    // Process Repeatable Service Rows
    $services = array();
    if ( isset( $data['service_title'] ) && is_array( $data['service_title'] ) ) {
        $count = count( $data['service_title'] );
        for ( $i = 0; $i < $count; $i++ ) {
            $title = sanitize_text_field( $data['service_title'][$i] ?? '' );
            $image = esc_url_raw( trim( $data['service_image'][$i] ?? '' ) );

            if ( empty( $title ) && empty( $image ) ) {
                continue;
            }

            // Split multiline checklist into clean lines
            $checklist_raw = sanitize_textarea_field( $data['service_checklist'][$i] ?? '' );
            $checklist     = array_values( array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", '', $checklist_raw ) ) ) ) );

            $services[] = array(
                'category'  => sanitize_text_field( $data['service_category'][$i] ?? '' ),
                'title'     => $title,
                'desc'      => sanitize_textarea_field( $data['service_desc'][$i] ?? '' ),
                'image'     => $image,
                'pill'      => sanitize_text_field( $data['service_pill'][$i] ?? '' ),
                'checklist' => $checklist,
                'btn_text'  => sanitize_text_field( $data['service_btn_text'][$i] ?? '' ),
                'btn_url'   => esc_url_raw( trim( $data['service_btn_url'][$i] ?? '' ) ),
            );
        }
    }
    update_option( 'dev_nahian_services_items_data', $services );
}
add_action( 'dev_nahian_save_settings_data', 'dev_nahian_save_subtab_services_data', 10, 1 );

/**
 * 2. Render Sub-Tab Panel
 */
function dev_nahian_render_subtab_services_panel( $active_subtab ) {
    if ( 'services' !== $active_subtab ) {
        return;
    }

    $show_section   = (int) get_option( 'dev_nahian_services_show_section', 1 );
    $badge_val      = get_option( 'dev_nahian_services_badge', '' );
    $title_val      = get_option( 'dev_nahian_services_title', '' );
    $desc_val       = get_option( 'dev_nahian_services_desc', '' );
    $saved_services = get_option( 'dev_nahian_services_items_data', array() );

    if ( ! is_array( $saved_services ) ) {
        $saved_services = array();
    }
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

    <div id="subtab-panel-services">

        <!-- SECTION 1: HEADER SETTINGS -->
        <div class="dn-accordion-card is-open">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '1. Header Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Configure badge, headline, and subtitle intro.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_services_show_section" value="1" <?php checked( $show_section, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_services_badge"><?php esc_html_e( 'Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_services_badge" name="dev_nahian_services_badge" class="dev-nahian-input" value="<?php echo esc_attr( $badge_val ); ?>" placeholder="e.g. Bespoke Mobility Solutions">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_services_title"><?php esc_html_e( 'Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_services_title" name="dev_nahian_services_title" class="dev-nahian-input" value="<?php echo esc_attr( $title_val ); ?>" placeholder="e.g. World-Class Service. <span>Frictionless.</span>">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_services_desc"><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_services_desc" name="dev_nahian_services_desc" class="dev-nahian-textarea" placeholder="Enter header subtitle..."><?php echo esc_textarea( $desc_val ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: SERVICES LIST REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '2. Services List', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Repeatable service cards with feature images and checklists.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_service_btn" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add Service', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_services_repeater_wrap" style="display: flex; flex-direction: column; gap: 20px;">
                    <?php if ( ! empty( $saved_services ) ) : ?>
                        <?php foreach ( $saved_services as $srv ) : 
                            $checklist_text = ! empty( $srv['checklist'] ) && is_array( $srv['checklist'] ) ? implode( "\n", $srv['checklist'] ) : '';
                            $has_image      = ! empty( $srv['image'] );
                        ?>
                            <div class="dn-service-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; flex-direction: column; gap: 14px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 8px;">
                                    <strong style="color: #0f172a; font-size: 13.5px;"><?php esc_html_e( 'Service Card', 'dev-nahian-car' ); ?></strong>
                                    <button type="button" class="dn-remove-service-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;">
                                        <?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?>
                                    </button>
                                </div>

                                <div class="dev-nahian-grid-2">
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Category Name', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="service_category[]" class="dev-nahian-input" value="<?php echo esc_attr( $srv['category'] ?? '' ); ?>" placeholder="e.g. Category 01">
                                    </div>

                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Badge Tag', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="service_pill[]" class="dev-nahian-input" value="<?php echo esc_attr( $srv['pill'] ?? '' ); ?>" placeholder="e.g. Instant Key">
                                    </div>

                                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                                        <label><?php esc_html_e( 'Service Title', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="service_title[]" class="dev-nahian-input" value="<?php echo esc_attr( $srv['title'] ?? '' ); ?>" placeholder="e.g. Self-Drive Performance Fleet">
                                    </div>

                                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                                        <label><?php esc_html_e( 'Description', 'dev-nahian-car' ); ?></label>
                                        <textarea name="service_desc[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Provide brief service overview..."><?php echo esc_textarea( $srv['desc'] ?? '' ); ?></textarea>
                                    </div>

                                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                                        <label><?php esc_html_e( 'Feature Image', 'dev-nahian-car' ); ?></label>
                                        <div class="dev-nahian-media-upload">
                                            <input type="text" name="service_image[]" class="dev-nahian-input dn-srv-img-url" value="<?php echo esc_attr( $srv['image'] ?? '' ); ?>" placeholder="https://example.com/service.jpg">
                                            <button type="button" class="dev-nahian-media-btn dn-srv-upload-btn"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                                            <button type="button" class="dev-nahian-media-btn dn-srv-remove-img-btn" style="<?php echo $has_image ? '' : 'display:none;'; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                                        </div>
                                        <div class="dn-srv-img-preview-wrap" style="<?php echo $has_image ? '' : 'display:none;'; ?> margin-top: 10px;">
                                            <img src="<?php echo esc_url( $srv['image'] ?? '' ); ?>" alt="Service Preview" class="dn-srv-img-preview" style="height: 60px; width: 90px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: cover;">
                                        </div>
                                    </div>

                                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                                        <label><?php esc_html_e( 'Checklist Items (One item per line)', 'dev-nahian-car' ); ?></label>
                                        <textarea name="service_checklist[]" class="dev-nahian-textarea" style="height: 80px;" placeholder="Feature item 1&#10;Feature item 2"><?php echo esc_textarea( $checklist_text ); ?></textarea>
                                    </div>

                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Button Text', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="service_btn_text[]" class="dev-nahian-input" value="<?php echo esc_attr( $srv['btn_text'] ?? '' ); ?>" placeholder="e.g. Learn More">
                                    </div>

                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Button Link', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="service_btn_url[]" class="dev-nahian-input" value="<?php echo esc_attr( $srv['btn_url'] ?? '' ); ?>" placeholder="https://example.com/contact/">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts for Accordion Toggles, Media Uploader & Repeater Rows -->
    <script id="dn-services-subtab-scripts">
    (function($) {
        'use strict';

        $(document).ready(function() {
            // Accordion Toggle Behavior
            $(document).on('click', '.dn-accordion-header', function(e) {
                if ($(e.target).closest('.dev-nahian-switch').length) {
                    return;
                }
                var $card = $(this).closest('.dn-accordion-card');
                $card.toggleClass('is-open');
            });

            // Add new service row
            $('#dn_add_service_btn').on('click', function(e) {
                e.preventDefault();
                var rowHtml = '\
                <div class="dn-service-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; flex-direction: column; gap: 14px;">\
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 8px;">\
                        <strong style="color: #0f172a; font-size: 13.5px;"><?php echo esc_js( __( 'Service Card', 'dev-nahian-car' ) ); ?></strong>\
                        <button type="button" class="dn-remove-service-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;">\
                            <?php echo esc_js( __( 'Remove', 'dev-nahian-car' ) ); ?>\
                        </button>\
                    </div>\
                    <div class="dev-nahian-grid-2">\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Category Name', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="service_category[]" class="dev-nahian-input" placeholder="e.g. Category 01">\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Badge Tag', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="service_pill[]" class="dev-nahian-input" placeholder="e.g. Instant Key">\
                        </div>\
                        <div class="dev-nahian-field-box dev-nahian-grid-full">\
                            <label><?php echo esc_js( __( 'Service Title', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="service_title[]" class="dev-nahian-input" placeholder="e.g. Self-Drive Performance Fleet">\
                        </div>\
                        <div class="dev-nahian-field-box dev-nahian-grid-full">\
                            <label><?php echo esc_js( __( 'Description', 'dev-nahian-car' ) ); ?></label>\
                            <textarea name="service_desc[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Provide brief service overview..."></textarea>\
                        </div>\
                        <div class="dev-nahian-field-box dev-nahian-grid-full">\
                            <label><?php echo esc_js( __( 'Feature Image', 'dev-nahian-car' ) ); ?></label>\
                            <div class="dev-nahian-media-upload">\
                                <input type="text" name="service_image[]" class="dev-nahian-input dn-srv-img-url" placeholder="https://example.com/service.jpg">\
                                <button type="button" class="dev-nahian-media-btn dn-srv-upload-btn"><?php echo esc_js( __( 'Upload', 'dev-nahian-car' ) ); ?></button>\
                                <button type="button" class="dev-nahian-media-btn dn-srv-remove-img-btn" style="display:none; background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php echo esc_js( __( 'Remove', 'dev-nahian-car' ) ); ?></button>\
                            </div>\
                            <div class="dn-srv-img-preview-wrap" style="display:none; margin-top: 10px;">\
                                <img src="" alt="Service Preview" class="dn-srv-img-preview" style="height: 60px; width: 90px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: cover;">\
                            </div>\
                        </div>\
                        <div class="dev-nahian-field-box dev-nahian-grid-full">\
                            <label><?php echo esc_js( __( 'Checklist Items (One item per line)', 'dev-nahian-car' ) ); ?></label>\
                            <textarea name="service_checklist[]" class="dev-nahian-textarea" style="height: 80px;" placeholder="Feature item 1&#10;Feature item 2"></textarea>\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Button Text', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="service_btn_text[]" class="dev-nahian-input" placeholder="e.g. Learn More">\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Button Link', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="service_btn_url[]" class="dev-nahian-input" placeholder="https://example.com/contact/">\
                        </div>\
                    </div>\
                </div>';
                $('#dn_services_repeater_wrap').append(rowHtml);
            });

            // Remove service row
            $(document).on('click', '.dn-remove-service-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-service-repeater-row').remove();
            });

            // Media picker per row
            $(document).on('click', '.dn-srv-upload-btn', function(e) {
                e.preventDefault();
                var $row = $(this).closest('.dn-service-repeater-row');
                var uploader = wp.media({
                    title: '<?php echo esc_js( __( 'Select Service Image', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use Image', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $row.find('.dn-srv-img-url').val(attachment.url);
                    $row.find('.dn-srv-img-preview').attr('src', attachment.url);
                    $row.find('.dn-srv-img-preview-wrap').show();
                    $row.find('.dn-srv-remove-img-btn').show();
                }).open();
            });

            // Remove Image
            $(document).on('click', '.dn-srv-remove-img-btn', function(e) {
                e.preventDefault();
                var $row = $(this).closest('.dn-service-repeater-row');
                $row.find('.dn-srv-img-url').val('');
                $row.find('.dn-srv-img-preview').attr('src', '');
                $row.find('.dn-srv-img-preview-wrap').hide();
                $(this).hide();
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Single targeted hook registration (prevents duplicate rendering)
add_action( 'dev_nahian_render_subtab_services', function() {
    dev_nahian_render_subtab_services_panel( 'services' );
});