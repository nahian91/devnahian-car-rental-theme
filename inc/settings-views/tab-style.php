<?php
/**
 * Settings Tab: Global Design System (Elementor Style)
 * Built with native page-load architecture, professional SaaS UI/UX cards,
 * structured visual grouping, and polished form fields.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Dedicated Direct Save Handler for Global Design System
 */
add_action( 'dev_nahian_save_settings_data', function( $data ) {
    if ( ! isset( $data['dev_nahian_active_tab_tracker'] ) || 'style' !== $data['dev_nahian_active_tab_tracker'] ) {
        return;
    }

    // 1. Global Colors
    update_option( 'dev_nahian_style_primary_color', sanitize_hex_color( $data['dev_nahian_style_primary_color'] ?? '' ) );
    update_option( 'dev_nahian_style_secondary_color', sanitize_hex_color( $data['dev_nahian_style_secondary_color'] ?? '' ) );
    update_option( 'dev_nahian_style_text_dark', sanitize_hex_color( $data['dev_nahian_style_text_dark'] ?? '' ) );
    update_option( 'dev_nahian_style_text_muted', sanitize_hex_color( $data['dev_nahian_style_text_muted'] ?? '' ) );
    update_option( 'dev_nahian_style_accent_color', sanitize_hex_color( $data['dev_nahian_style_accent_color'] ?? '' ) );
    update_option( 'dev_nahian_style_bg_light', sanitize_hex_color( $data['dev_nahian_style_bg_light'] ?? '' ) );
    update_option( 'dev_nahian_style_border_color', sanitize_hex_color( $data['dev_nahian_style_border_color'] ?? '' ) );

    // 2. Global Typography
    $font_heading = sanitize_text_field( $data['dev_nahian_font_heading'] ?? '' );
    if ( 'custom' === $font_heading && ! empty( $data['dev_nahian_font_heading_custom'] ) ) {
        $font_heading = sanitize_text_field( $data['dev_nahian_font_heading_custom'] );
    }
    update_option( 'dev_nahian_font_heading', $font_heading );

    $font_body = sanitize_text_field( $data['dev_nahian_font_body'] ?? '' );
    if ( 'custom' === $font_body && ! empty( $data['dev_nahian_font_body_custom'] ) ) {
        $font_body = sanitize_text_field( $data['dev_nahian_font_body_custom'] );
    }
    update_option( 'dev_nahian_font_body', $font_body );

    $base_font_size = ( isset( $data['dev_nahian_font_size_base'] ) && '' !== $data['dev_nahian_font_size_base'] ) ? absint( $data['dev_nahian_font_size_base'] ) : '';
    update_option( 'dev_nahian_font_size_base', $base_font_size );
    update_option( 'dev_nahian_font_line_height', sanitize_text_field( $data['dev_nahian_font_line_height'] ?? '' ) );
    update_option( 'dev_nahian_font_heading_weight', sanitize_text_field( $data['dev_nahian_font_heading_weight'] ?? '' ) );

    // 3. Layout & Geometry Tokens
    $radius = ( isset( $data['dev_nahian_style_border_radius'] ) && '' !== $data['dev_nahian_style_border_radius'] ) ? absint( $data['dev_nahian_style_border_radius'] ) : '';
    update_option( 'dev_nahian_style_border_radius', $radius );
    update_option( 'dev_nahian_style_shadow_depth', sanitize_key( $data['dev_nahian_style_shadow_depth'] ?? '' ) );

    // 4. Custom CSS
    update_option( 'dev_nahian_style_custom_css', wp_strip_all_tags( $data['dev_nahian_style_custom_css'] ?? '' ) );
});

/**
 * 2. Render Panel UI
 */
function dev_nahian_render_style_tab_content( $active_tab = 'style' ) {
    if ( 'style' !== $active_tab ) {
        return;
    }

    // Load Palette Values
    $primary_color   = get_option( 'dev_nahian_style_primary_color', '' );
    $secondary_color = get_option( 'dev_nahian_style_secondary_color', '' );
    $text_dark       = get_option( 'dev_nahian_style_text_dark', '' );
    $text_muted      = get_option( 'dev_nahian_style_text_muted', '' );
    $accent_color    = get_option( 'dev_nahian_style_accent_color', '' );
    $bg_light        = get_option( 'dev_nahian_style_bg_light', '' );
    $border_color    = get_option( 'dev_nahian_style_border_color', '' );

    // Load Typography Values
    $saved_h_font    = get_option( 'dev_nahian_font_heading', '' );
    $saved_b_font    = get_option( 'dev_nahian_font_body', '' );
    $heading_weight  = get_option( 'dev_nahian_font_heading_weight', '' );
    $font_size_base  = get_option( 'dev_nahian_font_size_base', '' );
    $line_height     = get_option( 'dev_nahian_font_line_height', '' );

    // Layout
    $border_radius   = get_option( 'dev_nahian_style_border_radius', '' );
    $shadow_depth    = get_option( 'dev_nahian_style_shadow_depth', '' );
    $custom_css      = get_option( 'dev_nahian_style_custom_css', '' );

    $curated_heading_fonts = array(
        'Montserrat'        => 'Montserrat (Luxury Classic)',
        'Plus Jakarta Sans' => 'Plus Jakarta Sans (Modern Editorial)',
        'Syne'              => 'Syne (Supercar Bold)',
        'Outfit'            => 'Outfit (Clean Geometric)',
        'Cinzel'            => 'Cinzel (Prestige Serif)',
        'Space Grotesk'     => 'Space Grotesk (Tech Monospace)',
        'Playfair Display'  => 'Playfair Display (Bespoke Serif)',
        'custom'            => 'Custom Font Stack...',
    );

    $curated_body_fonts = array(
        'system-ui'         => 'System Default (Fastest, Native OS)',
        'Inter'             => 'Inter (High Readability)',
        'Roboto'            => 'Roboto (Neutral Geometric)',
        'Open Sans'         => 'Open Sans (Balanced Humanist)',
        'custom'            => 'Custom Font Stack...',
    );

    $is_custom_h = ! empty( $saved_h_font ) && ! array_key_exists( $saved_h_font, $curated_heading_fonts );
    $is_custom_b = ! empty( $saved_b_font ) && ! array_key_exists( $saved_b_font, $curated_body_fonts );
    ?>
    <style>
        .dn-style-studio-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dn-style-studio-card:hover {
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
        .dn-global-color-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }
        .dn-color-row-card {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: border-color 0.15s ease;
        }
        .dn-color-row-card:hover {
            border-color: #94a3b8;
        }
        .dn-color-row-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .dn-color-row-info strong {
            font-size: 13px;
            color: #0f172a;
        }
        .dn-color-row-info span {
            font-size: 11px;
            color: #64748b;
        }
        .dn-color-picker-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dn-color-picker-group input[type="text"] {
            width: 86px;
            height: 36px;
            font-family: monospace;
            font-size: 12px;
            text-transform: uppercase;
        }
        .dn-color-picker-group input[type="color"] {
            width: 36px;
            height: 36px;
            padding: 2px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            background: #ffffff;
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

    <div id="tab-panel-style">
        <div class="dn-global-style-studio">

            <!-- CARD 1: GLOBAL SYSTEM COLORS -->
            <div class="dn-style-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-art"></span>
                        <?php esc_html_e( 'Global System Colors', 'dev-nahian-car' ); ?>
                    </h3>
                </div>
                <p class="dev-nahian-hint" style="margin-bottom: 18px;">
                    <?php esc_html_e( 'Changes to these base system colors synchronize across all buttons, typography, cards, and interactive elements.', 'dev-nahian-car' ); ?>
                </p>

                <div class="dn-global-color-grid">
                    <!-- Primary Color -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Primary Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Buttons & Active Elements', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_primary" value="<?php echo esc_attr( ! empty( $primary_color ) ? $primary_color : '#111827' ); ?>" oninput="document.getElementById('dev_nahian_style_primary_color').value = this.value;">
                            <input type="text" id="dev_nahian_style_primary_color" name="dev_nahian_style_primary_color" class="dev-nahian-input" value="<?php echo esc_attr( $primary_color ); ?>" placeholder="#111827" oninput="document.getElementById('dn_cp_primary').value = this.value;">
                        </div>
                    </div>

                    <!-- Secondary Color -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Secondary Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Hover States & Dark Surfaces', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_secondary" value="<?php echo esc_attr( ! empty( $secondary_color ) ? $secondary_color : '#1f2937' ); ?>" oninput="document.getElementById('dev_nahian_style_secondary_color').value = this.value;">
                            <input type="text" id="dev_nahian_style_secondary_color" name="dev_nahian_style_secondary_color" class="dev-nahian-input" value="<?php echo esc_attr( $secondary_color ); ?>" placeholder="#1f2937" oninput="document.getElementById('dn_cp_secondary').value = this.value;">
                        </div>
                    </div>

                    <!-- Accent Color -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Accent Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Badges & High-Contrast Highlights', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_accent" value="<?php echo esc_attr( ! empty( $accent_color ) ? $accent_color : '#b88e1e' ); ?>" oninput="document.getElementById('dev_nahian_style_accent_color').value = this.value;">
                            <input type="text" id="dev_nahian_style_accent_color" name="dev_nahian_style_accent_color" class="dev-nahian-input" value="<?php echo esc_attr( $accent_color ); ?>" placeholder="#B88E1E" oninput="document.getElementById('dn_cp_accent').value = this.value;">
                        </div>
                    </div>

                    <!-- Headings & Dark Text -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Text Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Titles & Headings (H1-H6)', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_dark" value="<?php echo esc_attr( ! empty( $text_dark ) ? $text_dark : '#0f172a' ); ?>" oninput="document.getElementById('dev_nahian_style_text_dark').value = this.value;">
                            <input type="text" id="dev_nahian_style_text_dark" name="dev_nahian_style_text_dark" class="dev-nahian-input" value="<?php echo esc_attr( $text_dark ); ?>" placeholder="#0F172A" oninput="document.getElementById('dn_cp_dark').value = this.value;">
                        </div>
                    </div>

                    <!-- Muted Paragraph Text -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Muted Text Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Paragraphs & Subtitles', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_muted" value="<?php echo esc_attr( ! empty( $text_muted ) ? $text_muted : '#64748b' ); ?>" oninput="document.getElementById('dev_nahian_style_text_muted').value = this.value;">
                            <input type="text" id="dev_nahian_style_text_muted" name="dev_nahian_style_text_muted" class="dev-nahian-input" value="<?php echo esc_attr( $text_muted ); ?>" placeholder="#64748B" oninput="document.getElementById('dn_cp_muted').value = this.value;">
                        </div>
                    </div>

                    <!-- Container Border Color -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Border Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Dividers & Card Outlines', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_border" value="<?php echo esc_attr( ! empty( $border_color ) ? $border_color : '#e2e8f0' ); ?>" oninput="document.getElementById('dev_nahian_style_border_color').value = this.value;">
                            <input type="text" id="dev_nahian_style_border_color" name="dev_nahian_style_border_color" class="dev-nahian-input" value="<?php echo esc_attr( $border_color ); ?>" placeholder="#E2E8F0" oninput="document.getElementById('dn_cp_border').value = this.value;">
                        </div>
                    </div>

                    <!-- Light Surface Background -->
                    <div class="dn-color-row-card">
                        <div class="dn-color-row-info">
                            <strong><?php esc_html_e( 'Background Surface Color', 'dev-nahian-car' ); ?></strong>
                            <span><?php esc_html_e( 'Card & Section Backdrops', 'dev-nahian-car' ); ?></span>
                        </div>
                        <div class="dn-color-picker-group">
                            <input type="color" id="dn_cp_bg" value="<?php echo esc_attr( ! empty( $bg_light ) ? $bg_light : '#f8fafc' ); ?>" oninput="document.getElementById('dev_nahian_style_bg_light').value = this.value;">
                            <input type="text" id="dev_nahian_style_bg_light" name="dev_nahian_style_bg_light" class="dev-nahian-input" value="<?php echo esc_attr( $bg_light ); ?>" placeholder="#F8FAFC" oninput="document.getElementById('dn_cp_bg').value = this.value;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: GLOBAL TYPOGRAPHY STANDARDS -->
            <div class="dn-style-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-editor-textcolor"></span>
                        <?php esc_html_e( 'Global Typography Standards', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_font_heading_select"><?php esc_html_e( 'Headings Font Family', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_font_heading_select" name="dev_nahian_font_heading" class="dev-nahian-select" onchange="dnToggleCustomFont(this, 'dev_nahian_font_heading_custom_wrap')">
                            <option value=""><?php esc_html_e( '-- Select Heading Font --', 'dev-nahian-car' ); ?></option>
                            <?php foreach ( $curated_heading_fonts as $f_val => $f_label ) : ?>
                                <option value="<?php echo esc_attr( $f_val ); ?>" <?php selected( $is_custom_h ? 'custom' : $saved_h_font, $f_val ); ?>>
                                    <?php echo esc_html( $f_label ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="dev_nahian_font_heading_custom_wrap" style="margin-top: 8px; <?php echo $is_custom_h ? '' : 'display: none;'; ?>">
                            <input type="text" name="dev_nahian_font_heading_custom" class="dev-nahian-input" value="<?php echo esc_attr( $saved_h_font ); ?>" placeholder="e.g. 'Cinzel', serif">
                        </div>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_font_body_select"><?php esc_html_e( 'Body Font Family', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_font_body_select" name="dev_nahian_font_body" class="dev-nahian-select" onchange="dnToggleCustomFont(this, 'dev_nahian_font_body_custom_wrap')">
                            <option value=""><?php esc_html_e( '-- Select Body Font --', 'dev-nahian-car' ); ?></option>
                            <?php foreach ( $curated_body_fonts as $b_val => $b_label ) : ?>
                                <option value="<?php echo esc_attr( $b_val ); ?>" <?php selected( $is_custom_b ? 'custom' : $saved_b_font, $b_val ); ?>>
                                    <?php echo esc_html( $b_label ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="dev_nahian_font_body_custom_wrap" style="margin-top: 8px; <?php echo $is_custom_b ? '' : 'display: none;'; ?>">
                            <input type="text" name="dev_nahian_font_body_custom" class="dev-nahian-input" value="<?php echo esc_attr( $saved_b_font ); ?>" placeholder="e.g. 'Inter', sans-serif">
                        </div>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_font_heading_weight"><?php esc_html_e( 'Heading Font Weight', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_font_heading_weight" name="dev_nahian_font_heading_weight" class="dev-nahian-select">
                            <option value=""><?php esc_html_e( '-- Select Font Weight --', 'dev-nahian-car' ); ?></option>
                            <option value="600" <?php selected( $heading_weight, '600' ); ?>>600 - Semi-Bold</option>
                            <option value="700" <?php selected( $heading_weight, '700' ); ?>>700 - Bold</option>
                            <option value="800" <?php selected( $heading_weight, '800' ); ?>>800 - Extra-Bold</option>
                            <option value="900" <?php selected( $heading_weight, '900' ); ?>>900 - Black / Heavy</option>
                        </select>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_font_size_base"><?php esc_html_e( 'Base Font Size (px)', 'dev-nahian-car' ); ?></label>
                        <input type="number" id="dev_nahian_font_size_base" name="dev_nahian_font_size_base" class="dev-nahian-input" value="<?php echo esc_attr( $font_size_base ); ?>" min="12" max="24" placeholder="e.g. 16">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_font_line_height"><?php esc_html_e( 'Line Height', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_font_line_height" name="dev_nahian_font_line_height" class="dev-nahian-input" value="<?php echo esc_attr( $line_height ); ?>" placeholder="e.g. 1.6">
                    </div>
                </div>
            </div>

            <!-- CARD 3: LAYOUT & UI GEOMETRY -->
            <div class="dn-style-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-layout"></span>
                        <?php esc_html_e( 'Layout & UI Geometry', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_style_border_radius"><?php esc_html_e( 'Border Radius (px)', 'dev-nahian-car' ); ?></label>
                        <input type="number" id="dev_nahian_style_border_radius" name="dev_nahian_style_border_radius" class="dev-nahian-input" value="<?php echo esc_attr( $border_radius ); ?>" min="0" max="40" placeholder="e.g. 12">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_style_shadow_depth"><?php esc_html_e( 'Shadow Depth', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_style_shadow_depth" name="dev_nahian_style_shadow_depth" class="dev-nahian-select">
                            <option value=""><?php esc_html_e( '-- Select Shadow Depth --', 'dev-nahian-car' ); ?></option>
                            <option value="flat" <?php selected( $shadow_depth, 'flat' ); ?>><?php esc_html_e( 'Flat (Borders Only)', 'dev-nahian-car' ); ?></option>
                            <option value="subtle" <?php selected( $shadow_depth, 'subtle' ); ?>><?php esc_html_e( 'Subtle (Light Elevation)', 'dev-nahian-car' ); ?></option>
                            <option value="executive" <?php selected( $shadow_depth, 'executive' ); ?>><?php esc_html_e( 'Executive (Deep Diffusion)', 'dev-nahian-car' ); ?></option>
                            <option value="glow" <?php selected( $shadow_depth, 'glow' ); ?>><?php esc_html_e( 'Ambient Glow (Accent Aura)', 'dev-nahian-car' ); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- CARD 4: CUSTOM CSS OVERRIDES -->
            <div class="dn-style-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-editor-code"></span>
                        <?php esc_html_e( 'Custom CSS Overrides', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <div class="dev-nahian-field-box">
                    <label for="dev_nahian_style_custom_css"><?php esc_html_e( 'Raw CSS Injections', 'dev-nahian-car' ); ?></label>
                    <textarea id="dev_nahian_style_custom_css" name="dev_nahian_style_custom_css" class="dev-nahian-textarea" style="height: 140px; font-family: monospace; font-size: 13px;" placeholder=".dev-nahian-car-card { border-radius: 8px; }"><?php echo esc_textarea( $custom_css ); ?></textarea>
                    <p class="dev-nahian-hint"><?php esc_html_e( 'Injected safely into site header with highest selector priority.', 'dev-nahian-car' ); ?></p>
                </div>
            </div>

        </div>
    </div>

    <!-- Live Helper Script for Custom Font Stack -->
    <script id="dn-style-scripts-js">
    function dnToggleCustomFont(selectEl, customWrapId) {
        var wrap = document.getElementById(customWrapId);
        if (wrap) {
            wrap.style.display = (selectEl.value === 'custom') ? 'block' : 'none';
        }
    }
    </script>
    <?php
}

// Single targeted hook registration (prevents duplicate rendering)
add_action( 'dev_nahian_render_tab_panel_style', 'dev_nahian_render_style_tab_content', 10, 1 );
add_action( 'dev_nahian_render_tab_panels', function( $active_tab ) {
    dev_nahian_render_style_tab_content( $active_tab );
}, 10, 1 );

/**
 * 3. Frontend Global Dynamic Style Output (Generates standard CSS custom properties)
 */
function dev_nahian_output_dynamic_styles() {
    $primary   = get_option( 'dev_nahian_style_primary_color', '' );
    $secondary = get_option( 'dev_nahian_style_secondary_color', '' );
    $accent    = get_option( 'dev_nahian_style_accent_color', '' );
    $text_dark = get_option( 'dev_nahian_style_text_dark', '' );
    $text_mute = get_option( 'dev_nahian_style_text_muted', '' );
    $border    = get_option( 'dev_nahian_style_border_color', '' );
    $bg_light  = get_option( 'dev_nahian_style_bg_light', '' );

    $font_head = get_option( 'dev_nahian_font_heading', '' );
    $font_body = get_option( 'dev_nahian_font_body', '' );
    $font_size = get_option( 'dev_nahian_font_size_base', '' );
    $line_h    = get_option( 'dev_nahian_font_line_height', '' );
    $weight    = get_option( 'dev_nahian_font_heading_weight', '' );
    $radius    = get_option( 'dev_nahian_style_border_radius', '' );
    $shadow    = get_option( 'dev_nahian_style_shadow_depth', '' );
    $custom    = get_option( 'dev_nahian_style_custom_css', '' );

    // Elevation calculation
    $elevation = '';
    if ( 'flat' === $shadow ) {
        $elevation = 'none';
    } elseif ( 'subtle' === $shadow ) {
        $elevation = '0 4px 16px rgba(15, 23, 42, 0.05)';
    } elseif ( 'glow' === $shadow && ! empty( $accent ) ) {
        $hex = ltrim( $accent, '#' );
        if ( strlen( $hex ) === 6 ) {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
            $elevation = "0 8px 30px rgba($r, $g, $b, 0.22)";
        }
    } elseif ( 'executive' === $shadow ) {
        $elevation = '0 16px 32px -8px rgba(15, 23, 42, 0.12)';
    }

    // Google Fonts Loader
    $system_stacks = array( 'system-ui', '-apple-system', 'Arial', 'sans-serif', 'serif', '' );
    $clean_head    = trim( explode( ',', (string) $font_head )[0], " '\"" );
    $clean_body    = trim( explode( ',', (string) $font_body )[0], " '\"" );

    $google_fonts_to_load = array();
    if ( ! in_array( $clean_head, $system_stacks, true ) ) {
        $google_fonts_to_load[] = str_replace( ' ', '+', $clean_head ) . ':wght@600;700;800;900';
    }
    if ( ! in_array( $clean_body, $system_stacks, true ) && $clean_body !== $clean_head ) {
        $google_fonts_to_load[] = str_replace( ' ', '+', $clean_body ) . ':wght@400;500;600';
    }
    ?>
    <style id="dev-nahian-global-design-tokens">
        <?php if ( ! empty( $google_fonts_to_load ) ) : ?>
            @import url('https://fonts.googleapis.com/css2?family=<?php echo implode( '&family=', array_unique( $google_fonts_to_load ) ); ?>&display=swap');
        <?php endif; ?>

        :root {
            <?php if ( ! empty( $primary ) ) : ?>--dev-nahian-car-primary: <?php echo esc_attr( $primary ); ?>; --e-global-color-primary: <?php echo esc_attr( $primary ); ?>;<?php endif; ?>
            <?php if ( ! empty( $secondary ) ) : ?>--dev-nahian-car-primary-hover: <?php echo esc_attr( $secondary ); ?>; --e-global-color-secondary: <?php echo esc_attr( $secondary ); ?>;<?php endif; ?>
            <?php if ( ! empty( $accent ) ) : ?>--dev-nahian-car-gold: <?php echo esc_attr( $accent ); ?>; --e-global-color-accent: <?php echo esc_attr( $accent ); ?>;<?php endif; ?>
            <?php if ( ! empty( $text_dark ) ) : ?>--dev-nahian-car-text-dark: <?php echo esc_attr( $text_dark ); ?>; --e-global-color-text: <?php echo esc_attr( $text_dark ); ?>;<?php endif; ?>
            <?php if ( ! empty( $text_mute ) ) : ?>--dev-nahian-car-text-muted: <?php echo esc_attr( $text_mute ); ?>;<?php endif; ?>
            <?php if ( ! empty( $border ) ) : ?>--dev-nahian-car-border: <?php echo esc_attr( $border ); ?>;<?php endif; ?>
            <?php if ( ! empty( $bg_light ) ) : ?>--dev-nahian-car-bg-light: <?php echo esc_attr( $bg_light ); ?>;<?php endif; ?>
            <?php if ( '' !== $radius ) : ?>--dev-nahian-car-radius: <?php echo esc_attr( $radius ); ?>px;<?php endif; ?>
            <?php if ( ! empty( $elevation ) ) : ?>--dev-nahian-car-elevation: <?php echo esc_attr( $elevation ); ?>;<?php endif; ?>
        }

        <?php if ( ! empty( $font_body ) || '' !== $font_size || ! empty( $line_h ) ) : ?>
        body {
            <?php if ( ! empty( $font_body ) ) : ?>font-family: <?php echo esc_attr( strpos( $font_body, ',' ) !== false ? $font_body : "'$font_body', sans-serif" ); ?>;<?php endif; ?>
            <?php if ( '' !== $font_size ) : ?>font-size: <?php echo esc_attr( $font_size ); ?>px;<?php endif; ?>
            <?php if ( ! empty( $line_h ) ) : ?>line-height: <?php echo esc_attr( $line_h ); ?>;<?php endif; ?>
        }
        <?php endif; ?>

        <?php if ( ! empty( $font_head ) || ! empty( $weight ) ) : ?>
        h1, h2, h3, h4, h5, h6,
        .dev-nahian-car-hero h1,
        .dev-nahian-car-gallery-header h1,
        .dev-nahian-car-services-header h1,
        .dev-nahian-car-catalog-header h1,
        .dev-nahian-car-blog-header h1 {
            <?php if ( ! empty( $font_head ) ) : ?>font-family: <?php echo esc_attr( strpos( $font_head, ',' ) !== false ? $font_head : "'$font_head', sans-serif" ); ?>;<?php endif; ?>
            <?php if ( ! empty( $weight ) ) : ?>font-weight: <?php echo esc_attr( $weight ); ?>;<?php endif; ?>
        }
        <?php endif; ?>

        <?php if ( ! empty( $custom ) ) : ?>
            /* Custom CSS Overrides */
            <?php echo $custom; ?>
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'dev_nahian_output_dynamic_styles', 100 );