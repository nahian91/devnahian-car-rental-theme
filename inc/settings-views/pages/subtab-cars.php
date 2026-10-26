<?php
/**
 * Settings Sub-Tab: Pages > Fleet Cars Catalog Configuration
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
 * 1. Dedicated Direct Save Handler for Cars Sub-Tab
 */
function dev_nahian_save_subtab_cars_data( $data ) {
    $active_tab    = $data['dev_nahian_active_tab_tracker'] ?? '';
    $active_subtab = $data['dev_nahian_active_subtab_tracker'] ?? '';

    if ( 'pages' !== $active_tab || 'cars' !== $active_subtab ) {
        return;
    }

    // Visibility Switch
    update_option( 'dev_nahian_cars_show_section', isset( $data['dev_nahian_cars_show_section'] ) ? 1 : 0 );

    // 1. Header & Intro
    update_option( 'dev_nahian_cars_badge', sanitize_text_field( $data['dev_nahian_cars_badge'] ?? '' ) );
    update_option( 'dev_nahian_cars_title', wp_kses( $data['dev_nahian_cars_title'] ?? '', array( 'span' => array() ) ) );
    update_option( 'dev_nahian_cars_desc', sanitize_textarea_field( $data['dev_nahian_cars_desc'] ?? '' ) );

    // 2. Filter & Catalog Settings
    $cars_per_page = isset( $data['dev_nahian_cars_per_page'] ) && '' !== $data['dev_nahian_cars_per_page'] ? absint( $data['dev_nahian_cars_per_page'] ) : '';
    $price_min     = isset( $data['dev_nahian_cars_price_min'] ) && '' !== $data['dev_nahian_cars_price_min'] ? absint( $data['dev_nahian_cars_price_min'] ) : '';
    $price_max     = isset( $data['dev_nahian_cars_price_max'] ) && '' !== $data['dev_nahian_cars_price_max'] ? absint( $data['dev_nahian_cars_price_max'] ) : '';
    $price_step    = isset( $data['dev_nahian_cars_price_step'] ) && '' !== $data['dev_nahian_cars_price_step'] ? absint( $data['dev_nahian_cars_price_step'] ) : '';

    update_option( 'dev_nahian_cars_per_page', $cars_per_page );
    update_option( 'dev_nahian_cars_price_min', $price_min );
    update_option( 'dev_nahian_cars_price_max', $price_max );
    update_option( 'dev_nahian_cars_price_step', $price_step );
    update_option( 'dev_nahian_cars_default_sort', sanitize_key( $data['dev_nahian_cars_default_sort'] ?? '' ) );
    update_option( 'dev_nahian_cars_booking_url', esc_url_raw( trim( $data['dev_nahian_cars_booking_url'] ?? '' ) ) );
}
add_action( 'dev_nahian_save_settings_data', 'dev_nahian_save_subtab_cars_data', 10, 1 );

/**
 * 2. Render Sub-Tab Panel
 */
function dev_nahian_render_subtab_cars_panel( $active_subtab ) {
    if ( 'cars' !== $active_subtab ) {
        return;
    }

    $show_section = (int) get_option( 'dev_nahian_cars_show_section', 1 );
    $badge_val    = get_option( 'dev_nahian_cars_badge', '' );
    $title_val    = get_option( 'dev_nahian_cars_title', '' );
    $desc_val     = get_option( 'dev_nahian_cars_desc', '' );

    $price_min    = get_option( 'dev_nahian_cars_price_min', '' );
    $price_max    = get_option( 'dev_nahian_cars_price_max', '' );
    $price_step   = get_option( 'dev_nahian_cars_price_step', '' );
    $per_page_val = get_option( 'dev_nahian_cars_per_page', '' );
    $current_sort = get_option( 'dev_nahian_cars_default_sort', '' );
    $booking_url  = get_option( 'dev_nahian_cars_booking_url', '' );
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

    <div id="subtab-panel-cars">

        <!-- SECTION 1: HEADER SETTINGS -->
        <div class="dn-accordion-card is-open">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '1. Header Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Configure badge, headline, and subtitle intro.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_cars_show_section" value="1" <?php checked( $show_section, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_badge"><?php esc_html_e( 'Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_cars_badge" name="dev_nahian_cars_badge" class="dev-nahian-input" value="<?php echo esc_attr( $badge_val ); ?>" placeholder="e.g. The Fleet Catalog">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_title"><?php esc_html_e( 'Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_cars_title" name="dev_nahian_cars_title" class="dev-nahian-input" value="<?php echo esc_attr( $title_val ); ?>" placeholder="e.g. All Prestige <span>Vehicles</span>">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_cars_desc"><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_cars_desc" name="dev_nahian_cars_desc" class="dev-nahian-textarea" placeholder="Enter header subtitle..."><?php echo esc_textarea( $desc_val ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: FILTER & CATALOG SETTINGS -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '2. Filter & Catalog Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Price thresholds, sorting rules, and pagination limits.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_price_min"><?php esc_html_e( 'Minimum Price ($)', 'dev-nahian-car' ); ?></label>
                        <input type="number" id="dev_nahian_cars_price_min" name="dev_nahian_cars_price_min" class="dev-nahian-input" value="<?php echo esc_attr( $price_min ); ?>" min="0" placeholder="e.g. 100">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_price_max"><?php esc_html_e( 'Maximum Price ($)', 'dev-nahian-car' ); ?></label>
                        <input type="number" id="dev_nahian_cars_price_max" name="dev_nahian_cars_price_max" class="dev-nahian-input" value="<?php echo esc_attr( $price_max ); ?>" min="1" placeholder="e.g. 2500">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_price_step"><?php esc_html_e( 'Price Step ($)', 'dev-nahian-car' ); ?></label>
                        <input type="number" id="dev_nahian_cars_price_step" name="dev_nahian_cars_price_step" class="dev-nahian-input" value="<?php echo esc_attr( $price_step ); ?>" min="1" placeholder="e.g. 25">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_per_page"><?php esc_html_e( 'Cars Per Page', 'dev-nahian-car' ); ?></label>
                        <input type="number" id="dev_nahian_cars_per_page" name="dev_nahian_cars_per_page" class="dev-nahian-input" value="<?php echo esc_attr( $per_page_val ); ?>" min="1" max="96" placeholder="e.g. 12">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_default_sort"><?php esc_html_e( 'Default Sort', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_cars_default_sort" name="dev_nahian_cars_default_sort" class="dev-nahian-select">
                            <option value=""><?php esc_html_e( '-- Select Default Order --', 'dev-nahian-car' ); ?></option>
                            <option value="featured" <?php selected( $current_sort, 'featured' ); ?>><?php esc_html_e( 'Featured Collection', 'dev-nahian-car' ); ?></option>
                            <option value="price-asc" <?php selected( $current_sort, 'price-asc' ); ?>><?php esc_html_e( 'Price: Low to High', 'dev-nahian-car' ); ?></option>
                            <option value="price-desc" <?php selected( $current_sort, 'price-desc' ); ?>><?php esc_html_e( 'Price: High to Low', 'dev-nahian-car' ); ?></option>
                            <option value="power-desc" <?php selected( $current_sort, 'power-desc' ); ?>><?php esc_html_e( 'Horsepower: Highest First', 'dev-nahian-car' ); ?></option>
                        </select>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_cars_booking_url"><?php esc_html_e( 'Booking Page URL', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_cars_booking_url" name="dev_nahian_cars_booking_url" class="dev-nahian-input" value="<?php echo esc_attr( $booking_url ); ?>" placeholder="https://example.com/booking/">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Accordion Toggle Script -->
    <script id="dn-cars-subtab-scripts">
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
add_action( 'dev_nahian_render_subtab_cars', function() {
    dev_nahian_render_subtab_cars_panel( 'cars' );
});