<?php
/**
 * Settings Sub-Tab: Pages > About Page Configuration
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
 * 1. Dedicated Direct Save Handler for About Sub-Tab
 */
function dev_nahian_save_subtab_about_data( $data ) {
    $active_tab    = $data['dev_nahian_active_tab_tracker'] ?? '';
    $active_subtab = $data['dev_nahian_active_subtab_tracker'] ?? '';

    if ( 'pages' !== $active_tab || 'about' !== $active_subtab ) {
        return;
    }

    // 0. Visibility Switch
    update_option( 'dev_nahian_about_show_section', isset( $data['dev_nahian_about_show_section'] ) ? 1 : 0 );

    // 1. Header & Hero Narrative
    update_option( 'dev_nahian_about_badge', sanitize_text_field( $data['dev_nahian_about_badge'] ?? '' ) );
    update_option( 'dev_nahian_about_title', wp_kses( $data['dev_nahian_about_title'] ?? '', array( 'span' => array() ) ) );
    update_option( 'dev_nahian_about_desc', sanitize_textarea_field( $data['dev_nahian_about_desc'] ?? '' ) );

    // 2. Mission & Story Block
    update_option( 'dev_nahian_about_story_heading', sanitize_text_field( $data['dev_nahian_about_story_heading'] ?? '' ) );
    update_option( 'dev_nahian_about_story_text_1', sanitize_textarea_field( $data['dev_nahian_about_story_text_1'] ?? '' ) );
    update_option( 'dev_nahian_about_story_text_2', sanitize_textarea_field( $data['dev_nahian_about_story_text_2'] ?? '' ) );
    update_option( 'dev_nahian_about_story_image', esc_url_raw( trim( $data['dev_nahian_about_story_image'] ?? '' ) ) );
    update_option( 'dev_nahian_about_experience_years', sanitize_text_field( $data['dev_nahian_about_experience_years'] ?? '' ) );

    // 3. Process Repeater 1: Numerical Milestone Stats
    $stats = array();
    if ( isset( $data['about_stat_number'] ) && is_array( $data['about_stat_number'] ) ) {
        $count = count( $data['about_stat_number'] );
        for ( $i = 0; $i < $count; $i++ ) {
            $num   = sanitize_text_field( $data['about_stat_number'][$i] ?? '' );
            $label = sanitize_text_field( $data['about_stat_label'][$i] ?? '' );
            if ( ! empty( $num ) || ! empty( $label ) ) {
                $stats[] = array(
                    'number' => $num,
                    'suffix' => sanitize_text_field( $data['about_stat_suffix'][$i] ?? '' ),
                    'label'  => $label,
                );
            }
        }
    }
    update_option( 'dev_nahian_about_stats_data', $stats );

    // 4. Process Repeater 2: Core Values / Operational Pillars
    $pillars = array();
    if ( isset( $data['about_pillar_title'] ) && is_array( $data['about_pillar_title'] ) ) {
        $p_count = count( $data['about_pillar_title'] );
        for ( $p = 0; $p < $p_count; $p++ ) {
            $p_title = sanitize_text_field( $data['about_pillar_title'][$p] ?? '' );
            if ( ! empty( $p_title ) ) {
                $pillars[] = array(
                    'tag'   => sanitize_text_field( $data['about_pillar_tag'][$p] ?? '' ),
                    'title' => $p_title,
                    'desc'  => sanitize_textarea_field( $data['about_pillar_desc'][$p] ?? '' ),
                );
            }
        }
    }
    update_option( 'dev_nahian_about_pillars_data', $pillars );
}
add_action( 'dev_nahian_save_settings_data', 'dev_nahian_save_subtab_about_data', 10, 1 );

/**
 * 2. Render Sub-Tab Panel
 */
function dev_nahian_render_subtab_about_panel( $active_subtab ) {
    if ( 'about' !== $active_subtab ) {
        return;
    }

    $show_section      = (int) get_option( 'dev_nahian_about_show_section', 1 );
    $badge_val         = get_option( 'dev_nahian_about_badge', '' );
    $title_val         = get_option( 'dev_nahian_about_title', '' );
    $desc_val          = get_option( 'dev_nahian_about_desc', '' );

    $story_heading     = get_option( 'dev_nahian_about_story_heading', '' );
    $story_text_1      = get_option( 'dev_nahian_about_story_text_1', '' );
    $story_text_2      = get_option( 'dev_nahian_about_story_text_2', '' );
    $story_image       = get_option( 'dev_nahian_about_story_image', '' );
    $experience_years  = get_option( 'dev_nahian_about_experience_years', '' );

    $saved_stats = get_option( 'dev_nahian_about_stats_data', array() );
    if ( ! is_array( $saved_stats ) ) {
        $saved_stats = array();
    }

    $saved_pillars = get_option( 'dev_nahian_about_pillars_data', array() );
    if ( ! is_array( $saved_pillars ) ) {
        $saved_pillars = array();
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

    <div id="subtab-panel-about">

        <!-- SECTION 1: HEADER SETTINGS -->
        <div class="dn-accordion-card is-open">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '1. Header Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Configure badge, headline, and subtitle intro.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_about_show_section" value="1" <?php checked( $show_section, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_about_badge"><?php esc_html_e( 'Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_about_badge" name="dev_nahian_about_badge" class="dev-nahian-input" value="<?php echo esc_attr( $badge_val ); ?>" placeholder="e.g. About Our Fleet">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_about_title"><?php esc_html_e( 'Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_about_title" name="dev_nahian_about_title" class="dev-nahian-input" value="<?php echo esc_attr( $title_val ); ?>" placeholder="e.g. Pioneering Sovereign <span>Mobility</span>">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_about_desc"><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_about_desc" name="dev_nahian_about_desc" class="dev-nahian-textarea" placeholder="Enter header subtitle..."><?php echo esc_textarea( $desc_val ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: BRAND STORY SETTINGS -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '2. Brand Story Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Mission narrative, paragraph copy, and showcase imagery.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_about_story_heading"><?php esc_html_e( 'Story Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_about_story_heading" name="dev_nahian_about_story_heading" class="dev-nahian-input" value="<?php echo esc_attr( $story_heading ); ?>" placeholder="e.g. Precision Ground Logistics for the Private Aviation Sector">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_about_story_text_1"><?php esc_html_e( 'Paragraph 1', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_about_story_text_1" name="dev_nahian_about_story_text_1" class="dev-nahian-textarea" style="height: 100px;" placeholder="First narrative paragraph..."><?php echo esc_textarea( $story_text_1 ); ?></textarea>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_about_story_text_2"><?php esc_html_e( 'Paragraph 2', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_about_story_text_2" name="dev_nahian_about_story_text_2" class="dev-nahian-textarea" style="height: 100px;" placeholder="Second narrative paragraph..."><?php echo esc_textarea( $story_text_2 ); ?></textarea>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_about_story_image"><?php esc_html_e( 'Showcase Image', 'dev-nahian-car' ); ?></label>
                        <div class="dev-nahian-media-upload">
                            <input type="text" id="dev_nahian_about_story_image" name="dev_nahian_about_story_image" class="dev-nahian-input dn-story-img-url" value="<?php echo esc_attr( $story_image ); ?>" placeholder="https://example.com/about.jpg">
                            <button type="button" class="dev-nahian-media-btn dn-story-upload-btn"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                            <button type="button" class="dev-nahian-media-btn dn-story-remove-btn" style="<?php echo empty( $story_image ) ? 'display:none;' : ''; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                        </div>
                        <div class="dn-story-preview-wrap" style="<?php echo empty( $story_image ) ? 'display:none;' : ''; ?> margin-top: 10px;">
                            <img src="<?php echo esc_url( $story_image ); ?>" alt="Story Preview" class="dn-story-preview-img" style="height: 60px; width: 90px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: cover;">
                        </div>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_about_experience_years"><?php esc_html_e( 'Experience Tag', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_about_experience_years" name="dev_nahian_about_experience_years" class="dev-nahian-input" value="<?php echo esc_attr( $experience_years ); ?>" placeholder="e.g. 12+ Years of Excellence">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: MILESTONE STATS REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '3. Milestone Stats', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Numerical metrics and counter highlights.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_about_stat_btn" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add Counter', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_about_stats_repeater_wrap" style="display: flex; flex-direction: column; gap: 10px;">
                    <?php if ( ! empty( $saved_stats ) ) : ?>
                        <?php foreach ( $saved_stats as $st ) : ?>
                            <div class="dn-about-stat-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: grid; grid-template-columns: 100px 70px 1fr 40px; gap: 12px; align-items: center;">
                                <div class="dev-nahian-field-box">
                                    <label><?php esc_html_e( 'Number', 'dev-nahian-car' ); ?></label>
                                    <input type="text" name="about_stat_number[]" class="dev-nahian-input" value="<?php echo esc_attr( $st['number'] ?? '' ); ?>" placeholder="100">
                                </div>
                                <div class="dev-nahian-field-box">
                                    <label><?php esc_html_e( 'Suffix', 'dev-nahian-car' ); ?></label>
                                    <input type="text" name="about_stat_suffix[]" class="dev-nahian-input" value="<?php echo esc_attr( $st['suffix'] ?? '' ); ?>" placeholder="+">
                                </div>
                                <div class="dev-nahian-field-box">
                                    <label><?php esc_html_e( 'Label', 'dev-nahian-car' ); ?></label>
                                    <input type="text" name="about_stat_label[]" class="dev-nahian-input" value="<?php echo esc_attr( $st['label'] ?? '' ); ?>" placeholder="Metric Label">
                                </div>
                                <div style="align-self: flex-end;">
                                    <button type="button" class="dn-remove-stat-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="<?php esc_attr_e( 'Delete', 'dev-nahian-car' ); ?>">&times;</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- SECTION 4: CORE VALUES & PILLARS REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '4. Core Values & Pillars', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Operational principles and pillar cards.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_about_pillar_btn" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add Pillar', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_about_pillars_repeater_wrap" style="display: flex; flex-direction: column; gap: 14px;">
                    <?php if ( ! empty( $saved_pillars ) ) : ?>
                        <?php foreach ( $saved_pillars as $pil ) : ?>
                            <div class="dn-about-pillar-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #0f172a; font-size: 13px;"><?php esc_html_e( 'Pillar Card', 'dev-nahian-car' ); ?></strong>
                                    <button type="button" class="dn-remove-pillar-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                                </div>
                                <div class="dev-nahian-grid-2">
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Pillar Tag', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="about_pillar_tag[]" class="dev-nahian-input" value="<?php echo esc_attr( $pil['tag'] ?? '' ); ?>" placeholder="e.g. Pillar 01">
                                    </div>
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Title', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="about_pillar_title[]" class="dev-nahian-input" value="<?php echo esc_attr( $pil['title'] ?? '' ); ?>" placeholder="Title">
                                    </div>
                                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                                        <label><?php esc_html_e( 'Description', 'dev-nahian-car' ); ?></label>
                                        <textarea name="about_pillar_desc[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Pillar explanation..."><?php echo esc_textarea( $pil['desc'] ?? '' ); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts for Accordion Toggles, Media Uploader & Repeaters -->
    <script id="dn-about-subtab-scripts">
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

            // Story Showcase Media Frame
            $('.dn-story-upload-btn').on('click', function(e) {
                e.preventDefault();
                var wrap = $(this).closest('.dev-nahian-field-box');
                var uploader = wp.media({
                    title: '<?php echo esc_js( __( 'Select Showcase Image', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use Image', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    wrap.find('.dn-story-img-url').val(attachment.url);
                    wrap.find('.dn-story-preview-img').attr('src', attachment.url);
                    wrap.find('.dn-story-preview-wrap').show();
                    wrap.find('.dn-story-remove-btn').show();
                }).open();
            });

            $('.dn-story-remove-btn').on('click', function(e) {
                e.preventDefault();
                var wrap = $(this).closest('.dev-nahian-field-box');
                wrap.find('.dn-story-img-url').val('');
                wrap.find('.dn-story-preview-img').attr('src', '');
                wrap.find('.dn-story-preview-wrap').hide();
                $(this).hide();
            });

            // Add Milestone Stat Row
            $('#dn_add_about_stat_btn').on('click', function(e) {
                e.preventDefault();
                var row = '\
                <div class="dn-about-stat-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: grid; grid-template-columns: 100px 70px 1fr 40px; gap: 12px; align-items: center;">\
                    <div class="dev-nahian-field-box">\
                        <label><?php echo esc_js( __( 'Number', 'dev-nahian-car' ) ); ?></label>\
                        <input type="text" name="about_stat_number[]" class="dev-nahian-input" value="" placeholder="100">\
                    </div>\
                    <div class="dev-nahian-field-box">\
                        <label><?php echo esc_js( __( 'Suffix', 'dev-nahian-car' ) ); ?></label>\
                        <input type="text" name="about_stat_suffix[]" class="dev-nahian-input" value="" placeholder="+">\
                    </div>\
                    <div class="dev-nahian-field-box">\
                        <label><?php echo esc_js( __( 'Label', 'dev-nahian-car' ) ); ?></label>\
                        <input type="text" name="about_stat_label[]" class="dev-nahian-input" value="" placeholder="Metric Label">\
                    </div>\
                    <div style="align-self: flex-end;">\
                        <button type="button" class="dn-remove-stat-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="<?php echo esc_js( __( 'Delete', 'dev-nahian-car' ) ); ?>">&times;</button>\
                    </div>\
                </div>';
                $('#dn_about_stats_repeater_wrap').append(row);
            });

            $(document).on('click', '.dn-remove-stat-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-about-stat-repeater-row').remove();
            });

            // Add Pillar Row
            $('#dn_add_about_pillar_btn').on('click', function(e) {
                e.preventDefault();
                var row = '\
                <div class="dn-about-pillar-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; display: flex; flex-direction: column; gap: 10px;">\
                    <div style="display: flex; justify-content: space-between; align-items: center;">\
                        <strong style="color: #0f172a; font-size: 13px;"><?php echo esc_js( __( 'Pillar Card', 'dev-nahian-car' ) ); ?></strong>\
                        <button type="button" class="dn-remove-pillar-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;"><?php echo esc_js( __( 'Remove', 'dev-nahian-car' ) ); ?></button>\
                    </div>\
                    <div class="dev-nahian-grid-2">\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Pillar Tag', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="about_pillar_tag[]" class="dev-nahian-input" placeholder="e.g. Pillar 01">\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Title', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="about_pillar_title[]" class="dev-nahian-input" placeholder="Title">\
                        </div>\
                        <div class="dev-nahian-field-box dev-nahian-grid-full">\
                            <label><?php echo esc_js( __( 'Description', 'dev-nahian-car' ) ); ?></label>\
                            <textarea name="about_pillar_desc[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Pillar explanation..."></textarea>\
                        </div>\
                    </div>\
                </div>';
                $('#dn_about_pillars_repeater_wrap').append(row);
            });

            $(document).on('click', '.dn-remove-pillar-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-about-pillar-repeater-row').remove();
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Single targeted hook registration (prevents duplicate rendering)
add_action( 'dev_nahian_render_subtab_about', function() {
    dev_nahian_render_subtab_about_panel( 'about' );
});