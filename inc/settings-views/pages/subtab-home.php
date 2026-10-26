<?php
/**
 * Settings Sub-Tab: Pages > Home Page Configuration (with Interactive Accordions & Visibility Switches)
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
 * 1. Dedicated Direct Save Handler for All Homepage Sections & Visibility Switches
 */
function dev_nahian_save_subtab_home_data( $data ) {
    $active_tab    = $data['dev_nahian_active_tab_tracker'] ?? '';
    $active_subtab = $data['dev_nahian_active_subtab_tracker'] ?? '';

    if ( 'pages' !== $active_tab || 'home' !== $active_subtab ) {
        return;
    }

    // SECTION 1: HERO & DISPATCH
    update_option( 'dev_nahian_home_show_hero', isset( $data['dev_nahian_home_show_hero'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_hero_eyebrow', sanitize_text_field( $data['dev_nahian_home_hero_eyebrow'] ?? '' ) );
    update_option( 'dev_nahian_home_hero_title', wp_kses( $data['dev_nahian_home_hero_title'] ?? '', array( 'span' => array(), 'br' => array() ) ) );
    update_option( 'dev_nahian_home_hero_desc', sanitize_textarea_field( $data['dev_nahian_home_hero_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_hero_btn1_text', sanitize_text_field( $data['dev_nahian_home_hero_btn1_text'] ?? '' ) );
    update_option( 'dev_nahian_home_hero_btn1_url', esc_url_raw( trim( $data['dev_nahian_home_hero_btn1_url'] ?? '' ) ) );
    update_option( 'dev_nahian_home_hero_btn2_text', sanitize_text_field( $data['dev_nahian_home_hero_btn2_text'] ?? '' ) );
    update_option( 'dev_nahian_home_hero_btn2_url', esc_url_raw( trim( $data['dev_nahian_home_hero_btn2_url'] ?? '' ) ) );
    update_option( 'dev_nahian_home_trust_score', sanitize_text_field( $data['dev_nahian_home_trust_score'] ?? '' ) );
    update_option( 'dev_nahian_home_trust_text', sanitize_text_field( $data['dev_nahian_home_trust_text'] ?? '' ) );
    update_option( 'dev_nahian_home_feat_pill_1', sanitize_text_field( $data['dev_nahian_home_feat_pill_1'] ?? '' ) );
    update_option( 'dev_nahian_home_feat_pill_2', sanitize_text_field( $data['dev_nahian_home_feat_pill_2'] ?? '' ) );
    update_option( 'dev_nahian_home_feat_pill_3', sanitize_text_field( $data['dev_nahian_home_feat_pill_3'] ?? '' ) );
    update_option( 'dev_nahian_home_dispatch_title', sanitize_text_field( $data['dev_nahian_home_dispatch_title'] ?? '' ) );
    update_option( 'dev_nahian_home_dispatch_subtitle', sanitize_textarea_field( $data['dev_nahian_home_dispatch_subtitle'] ?? '' ) );
    update_option( 'dev_nahian_home_dispatch_pickup', sanitize_text_field( $data['dev_nahian_home_dispatch_pickup'] ?? '' ) );
    update_option( 'dev_nahian_home_dispatch_return', sanitize_text_field( $data['dev_nahian_home_dispatch_return'] ?? '' ) );

    // SECTION 2: ABOUT US
    update_option( 'dev_nahian_home_show_about', isset( $data['dev_nahian_home_show_about'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_about_tag', sanitize_text_field( $data['dev_nahian_home_about_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_about_title', sanitize_text_field( $data['dev_nahian_home_about_title'] ?? '' ) );
    update_option( 'dev_nahian_home_about_desc', sanitize_textarea_field( $data['dev_nahian_home_about_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_about_img1', esc_url_raw( trim( $data['dev_nahian_home_about_img1'] ?? '' ) ) );
    update_option( 'dev_nahian_home_about_img2', esc_url_raw( trim( $data['dev_nahian_home_about_img2'] ?? '' ) ) );
    update_option( 'dev_nahian_home_about_telemetry_status', sanitize_text_field( $data['dev_nahian_home_about_telemetry_status'] ?? '' ) );
    update_option( 'dev_nahian_home_about_check_1', sanitize_text_field( $data['dev_nahian_home_about_check_1'] ?? '' ) );
    update_option( 'dev_nahian_home_about_check_2', sanitize_text_field( $data['dev_nahian_home_about_check_2'] ?? '' ) );
    update_option( 'dev_nahian_home_about_check_3', sanitize_text_field( $data['dev_nahian_home_about_check_3'] ?? '' ) );

    // SECTION 3: SERVICES
    update_option( 'dev_nahian_home_show_services', isset( $data['dev_nahian_home_show_services'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_services_tag', sanitize_text_field( $data['dev_nahian_home_services_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_services_title', sanitize_text_field( $data['dev_nahian_home_services_title'] ?? '' ) );
    update_option( 'dev_nahian_home_services_desc', sanitize_textarea_field( $data['dev_nahian_home_services_desc'] ?? '' ) );

    // SECTION 4: FLEET SECTION
    update_option( 'dev_nahian_home_show_fleet', isset( $data['dev_nahian_home_show_fleet'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_fleet_tag', sanitize_text_field( $data['dev_nahian_home_fleet_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_fleet_title', sanitize_text_field( $data['dev_nahian_home_fleet_title'] ?? '' ) );
    update_option( 'dev_nahian_home_fleet_desc', sanitize_textarea_field( $data['dev_nahian_home_fleet_desc'] ?? '' ) );

    // SECTION 5: HOW IT WORKS
    update_option( 'dev_nahian_home_show_hiw', isset( $data['dev_nahian_home_show_hiw'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_hiw_tag', sanitize_text_field( $data['dev_nahian_home_hiw_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_title', sanitize_text_field( $data['dev_nahian_home_hiw_title'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_desc', sanitize_textarea_field( $data['dev_nahian_home_hiw_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_s1_title', sanitize_text_field( $data['dev_nahian_home_hiw_s1_title'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_s1_desc', sanitize_textarea_field( $data['dev_nahian_home_hiw_s1_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_s2_title', sanitize_text_field( $data['dev_nahian_home_hiw_s2_title'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_s2_desc', sanitize_textarea_field( $data['dev_nahian_home_hiw_s2_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_s3_title', sanitize_text_field( $data['dev_nahian_home_hiw_s3_title'] ?? '' ) );
    update_option( 'dev_nahian_home_hiw_s3_desc', sanitize_textarea_field( $data['dev_nahian_home_hiw_s3_desc'] ?? '' ) );

    // SECTION 6: CTA BANNER
    update_option( 'dev_nahian_home_show_cta', isset( $data['dev_nahian_home_show_cta'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_cta_title', sanitize_text_field( $data['dev_nahian_home_cta_title'] ?? '' ) );
    update_option( 'dev_nahian_home_cta_desc', sanitize_textarea_field( $data['dev_nahian_home_cta_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_cta_btn1_text', sanitize_text_field( $data['dev_nahian_home_cta_btn1_text'] ?? '' ) );
    update_option( 'dev_nahian_home_cta_btn1_url', esc_url_raw( trim( $data['dev_nahian_home_cta_btn1_url'] ?? '' ) ) );
    update_option( 'dev_nahian_home_cta_phone', sanitize_text_field( $data['dev_nahian_home_cta_phone'] ?? '' ) );

    // SECTION 7: PROCESS TIMELINE
    update_option( 'dev_nahian_home_show_proc', isset( $data['dev_nahian_home_show_proc'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_proc_tag', sanitize_text_field( $data['dev_nahian_home_proc_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_title', sanitize_text_field( $data['dev_nahian_home_proc_title'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_desc', sanitize_textarea_field( $data['dev_nahian_home_proc_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s1_title', sanitize_text_field( $data['dev_nahian_home_proc_s1_title'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s1_desc', sanitize_textarea_field( $data['dev_nahian_home_proc_s1_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s2_title', sanitize_text_field( $data['dev_nahian_home_proc_s2_title'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s2_desc', sanitize_textarea_field( $data['dev_nahian_home_proc_s2_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s3_title', sanitize_text_field( $data['dev_nahian_home_proc_s3_title'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s3_desc', sanitize_textarea_field( $data['dev_nahian_home_proc_s3_desc'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s4_title', sanitize_text_field( $data['dev_nahian_home_proc_s4_title'] ?? '' ) );
    update_option( 'dev_nahian_home_proc_s4_desc', sanitize_textarea_field( $data['dev_nahian_home_proc_s4_desc'] ?? '' ) );

    // SECTION 8: FAQ REPEATER
    update_option( 'dev_nahian_home_show_faq', isset( $data['dev_nahian_home_show_faq'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_faq_tag', sanitize_text_field( $data['dev_nahian_home_faq_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_faq_title', sanitize_text_field( $data['dev_nahian_home_faq_title'] ?? '' ) );
    update_option( 'dev_nahian_home_faq_desc', sanitize_textarea_field( $data['dev_nahian_home_faq_desc'] ?? '' ) );
    $faqs = array();
    if ( isset( $data['faq_question'] ) && is_array( $data['faq_question'] ) ) {
        $count = count( $data['faq_question'] );
        for ( $i = 0; $i < $count; $i++ ) {
            $q = sanitize_text_field( $data['faq_question'][$i] ?? '' );
            $a = sanitize_textarea_field( $data['faq_answer'][$i] ?? '' );
            if ( ! empty( $q ) || ! empty( $a ) ) {
                $faqs[] = array( 'question' => $q, 'answer' => $a );
            }
        }
    }
    update_option( 'dev_nahian_home_faqs_data', $faqs );

    // SECTION 9: COUNTERS
    update_option( 'dev_nahian_home_show_counters', isset( $data['dev_nahian_home_show_counters'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_cnt1_val', sanitize_text_field( $data['dev_nahian_home_cnt1_val'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt1_suf', sanitize_text_field( $data['dev_nahian_home_cnt1_suf'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt1_lbl', sanitize_text_field( $data['dev_nahian_home_cnt1_lbl'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt2_val', sanitize_text_field( $data['dev_nahian_home_cnt2_val'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt2_suf', sanitize_text_field( $data['dev_nahian_home_cnt2_suf'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt2_lbl', sanitize_text_field( $data['dev_nahian_home_cnt2_lbl'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt3_val', sanitize_text_field( $data['dev_nahian_home_cnt3_val'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt3_suf', sanitize_text_field( $data['dev_nahian_home_cnt3_suf'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt3_lbl', sanitize_text_field( $data['dev_nahian_home_cnt3_lbl'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt4_val', sanitize_text_field( $data['dev_nahian_home_cnt4_val'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt4_suf', sanitize_text_field( $data['dev_nahian_home_cnt4_suf'] ?? '' ) );
    update_option( 'dev_nahian_home_cnt4_lbl', sanitize_text_field( $data['dev_nahian_home_cnt4_lbl'] ?? '' ) );

    // SECTION 10: ARTICLES HEADER
    update_option( 'dev_nahian_home_show_blog', isset( $data['dev_nahian_home_show_blog'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_blog_tag', sanitize_text_field( $data['dev_nahian_home_blog_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_blog_title', sanitize_text_field( $data['dev_nahian_home_blog_title'] ?? '' ) );
    update_option( 'dev_nahian_home_blog_desc', sanitize_textarea_field( $data['dev_nahian_home_blog_desc'] ?? '' ) );

    // SECTION 11: TESTIMONIALS REPEATER
    update_option( 'dev_nahian_home_show_testimonials', isset( $data['dev_nahian_home_show_testimonials'] ) ? 1 : 0 );
    update_option( 'dev_nahian_home_testi_tag', sanitize_text_field( $data['dev_nahian_home_testi_tag'] ?? '' ) );
    update_option( 'dev_nahian_home_testi_title', sanitize_text_field( $data['dev_nahian_home_testi_title'] ?? '' ) );
    update_option( 'dev_nahian_home_testi_desc', sanitize_textarea_field( $data['dev_nahian_home_testi_desc'] ?? '' ) );
    $testimonials = array();
    if ( isset( $data['testi_name'] ) && is_array( $data['testi_name'] ) ) {
        $count = count( $data['testi_name'] );
        for ( $i = 0; $i < $count; $i++ ) {
            $name = sanitize_text_field( $data['testi_name'][$i] ?? '' );
            $text = sanitize_textarea_field( $data['testi_text'][$i] ?? '' );
            if ( ! empty( $name ) || ! empty( $text ) ) {
                $testimonials[] = array(
                    'name'   => $name,
                    'role'   => sanitize_text_field( $data['testi_role'][$i] ?? '' ),
                    'text'   => $text,
                    'stars'  => min( 5, max( 1, absint( $data['testi_stars'][$i] ?? 5 ) ) ),
                    'avatar' => esc_url_raw( trim( $data['testi_avatar'][$i] ?? '' ) ),
                );
            }
        }
    }
    update_option( 'dev_nahian_home_testimonials_data', $testimonials );
}
add_action( 'dev_nahian_save_settings_data', 'dev_nahian_save_subtab_home_data', 10, 1 );

/**
 * 2. Render Sub-Tab Panel (With Accordion Wrappers)
 */
function dev_nahian_render_subtab_home_panel( $active_subtab ) {
    if ( 'home' !== $active_subtab ) {
        return;
    }

    // Load Visibility Switches
    $show_hero         = (int) get_option( 'dev_nahian_home_show_hero', 1 );
    $show_about        = (int) get_option( 'dev_nahian_home_show_about', 1 );
    $show_services     = (int) get_option( 'dev_nahian_home_show_services', 1 );
    $show_fleet        = (int) get_option( 'dev_nahian_home_show_fleet', 1 );
    $show_hiw          = (int) get_option( 'dev_nahian_home_show_hiw', 1 );
    $show_cta          = (int) get_option( 'dev_nahian_home_show_cta', 1 );
    $show_proc         = (int) get_option( 'dev_nahian_home_show_proc', 1 );
    $show_faq          = (int) get_option( 'dev_nahian_home_show_faq', 1 );
    $show_counters     = (int) get_option( 'dev_nahian_home_show_counters', 1 );
    $show_blog         = (int) get_option( 'dev_nahian_home_show_blog', 1 );
    $show_testimonials = (int) get_option( 'dev_nahian_home_show_testimonials', 1 );

    $saved_faqs   = get_option( 'dev_nahian_home_faqs_data', array() );
    if ( ! is_array( $saved_faqs ) ) { $saved_faqs = array(); }

    $saved_testis = get_option( 'dev_nahian_home_testimonials_data', array() );
    if ( ! is_array( $saved_testis ) ) { $saved_testis = array(); }

    $about_img1   = get_option( 'dev_nahian_home_about_img1', '' );
    $about_img2   = get_option( 'dev_nahian_home_about_img2', '' );
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

    <div id="subtab-panel-home">
        
        <!-- SECTION 1: HERO & DISPATCH -->
        <div class="dn-accordion-card is-open">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '1. Hero & Dispatch Module', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Top hero intro and dispatch booking strip settings.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_hero" value="1" <?php checked( $show_hero, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Hero Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_hero_eyebrow" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hero_eyebrow', '' ) ); ?>" placeholder="e.g. Bespoke Mobility & Prestige Fleet">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Hero Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_hero_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hero_title', '' ) ); ?>" placeholder="e.g. Drive extraordinary.<br>Every mile, <span>frictionless.</span>">
                    </div>
                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label><?php esc_html_e( 'Hero Description', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_hero_desc" class="dev-nahian-textarea" placeholder="Enter hero narrative description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_hero_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Button 1 Text / Link', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_hero_btn1_text" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hero_btn1_text', '' ) ); ?>" placeholder="Button Text">
                            <input type="text" name="dev_nahian_home_hero_btn1_url" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hero_btn1_url', '' ) ); ?>" placeholder="Link URL">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Button 2 Text / Link', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_hero_btn2_text" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hero_btn2_text', '' ) ); ?>" placeholder="Button Text">
                            <input type="text" name="dev_nahian_home_hero_btn2_url" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hero_btn2_url', '' ) ); ?>" placeholder="Link URL">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Trust Score & Label', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_trust_score" style="width: 100px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_trust_score', '' ) ); ?>" placeholder="4.96/5.0">
                            <input type="text" name="dev_nahian_home_trust_text" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_trust_text', '' ) ); ?>" placeholder="e.g. Rating across 48,000+ Journeys">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Trust Badges (3 Items)', 'dev-nahian-car' ); ?></label>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px;">
                            <input type="text" name="dev_nahian_home_feat_pill_1" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_feat_pill_1', '' ) ); ?>" placeholder="Badge 1">
                            <input type="text" name="dev_nahian_home_feat_pill_2" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_feat_pill_2', '' ) ); ?>" placeholder="Badge 2">
                            <input type="text" name="dev_nahian_home_feat_pill_3" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_feat_pill_3', '' ) ); ?>" placeholder="Badge 3">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Dispatch Box Title & Subtitle', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_dispatch_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_dispatch_title', '' ) ); ?>" placeholder="e.g. Dispatch Your Chassis">
                        <input type="text" name="dev_nahian_home_dispatch_subtitle" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_dispatch_subtitle', '' ) ); ?>" placeholder="Enter dispatch subtitle...">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Dispatch Default Locations', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_dispatch_pickup" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_dispatch_pickup', '' ) ); ?>" placeholder="Pickup Location">
                        <input type="text" name="dev_nahian_home_dispatch_return" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_dispatch_return', '' ) ); ?>" placeholder="Return Location">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: ABOUT US -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '2. About Us Section', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Editorial about narrative and image showcase.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_about" value="1" <?php checked( $show_about, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_about_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_about_tag', '' ) ); ?>" placeholder="e.g. The Veloce Standard">
                        <input type="text" name="dev_nahian_home_about_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_about_title', '' ) ); ?>" placeholder="e.g. Precision-Engineered Luxury Mobility">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Primary Image', 'dev-nahian-car' ); ?></label>
                        <div class="dev-nahian-media-upload">
                            <input type="text" id="dev_nahian_home_about_img1" name="dev_nahian_home_about_img1" class="dev-nahian-input" value="<?php echo esc_attr( $about_img1 ); ?>" placeholder="https://example.com/image1.jpg">
                            <button type="button" class="dev-nahian-media-btn dn-media-btn" data-target="#dev_nahian_home_about_img1" data-preview="#dn_about_img1_preview" data-wrap="#dn_about_img1_wrap"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                            <button type="button" class="dev-nahian-media-btn dn-remove-btn" data-target="#dev_nahian_home_about_img1" data-preview="#dn_about_img1_preview" data-wrap="#dn_about_img1_wrap" style="<?php echo empty( $about_img1 ) ? 'display:none;' : ''; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                        </div>
                        <div id="dn_about_img1_wrap" style="<?php echo empty( $about_img1 ) ? 'display:none;' : ''; ?> margin-top: 8px;">
                            <img id="dn_about_img1_preview" src="<?php echo esc_url( $about_img1 ); ?>" alt="Preview" style="height: 50px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: cover;">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label><?php esc_html_e( 'About Story Description', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_about_desc" class="dev-nahian-textarea" placeholder="Enter story paragraph..."><?php echo esc_textarea( get_option( 'dev_nahian_home_about_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Secondary Inset Image', 'dev-nahian-car' ); ?></label>
                        <div class="dev-nahian-media-upload">
                            <input type="text" id="dev_nahian_home_about_img2" name="dev_nahian_home_about_img2" class="dev-nahian-input" value="<?php echo esc_attr( $about_img2 ); ?>" placeholder="https://example.com/image2.jpg">
                            <button type="button" class="dev-nahian-media-btn dn-media-btn" data-target="#dev_nahian_home_about_img2" data-preview="#dn_about_img2_preview" data-wrap="#dn_about_img2_wrap"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                            <button type="button" class="dev-nahian-media-btn dn-remove-btn" data-target="#dev_nahian_home_about_img2" data-preview="#dn_about_img2_preview" data-wrap="#dn_about_img2_wrap" style="<?php echo empty( $about_img2 ) ? 'display:none;' : ''; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                        </div>
                        <div id="dn_about_img2_wrap" style="<?php echo empty( $about_img2 ) ? 'display:none;' : ''; ?> margin-top: 8px;">
                            <img id="dn_about_img2_preview" src="<?php echo esc_url( $about_img2 ); ?>" alt="Preview" style="height: 50px; border-radius: 6px; border: 1px solid #cbd5e1; object-fit: cover;">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Telemetry Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_about_telemetry_status" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_about_telemetry_status', '' ) ); ?>" placeholder="e.g. 100% Factory Calibrated">
                    </div>
                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label><?php esc_html_e( 'Checklist Bullet Points (3 Items)', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <input type="text" name="dev_nahian_home_about_check_1" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_about_check_1', '' ) ); ?>" placeholder="Bullet Item 1">
                            <input type="text" name="dev_nahian_home_about_check_2" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_about_check_2', '' ) ); ?>" placeholder="Bullet Item 2">
                            <input type="text" name="dev_nahian_home_about_check_3" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_about_check_3', '' ) ); ?>" placeholder="Bullet Item 3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: SERVICES -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '3. Services Header Section', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Services intro block on the homepage.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_services" value="1" <?php checked( $show_services, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_services_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_services_tag', '' ) ); ?>" placeholder="e.g. Tailored Mobility">
                        <input type="text" name="dev_nahian_home_services_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_services_title', '' ) ); ?>" placeholder="e.g. Our Dedicated Services">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_services_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter services subtitle..."><?php echo esc_textarea( get_option( 'dev_nahian_home_services_desc', '' ) ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: FLEET SECTION -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '4. Modern Fleet Header Section', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Fleet showcase grid header settings.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_fleet" value="1" <?php checked( $show_fleet, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_fleet_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_fleet_tag', '' ) ); ?>" placeholder="e.g. The Private Stable">
                        <input type="text" name="dev_nahian_home_fleet_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_fleet_title', '' ) ); ?>" placeholder="e.g. Our Modern Fleet">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_fleet_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter fleet subtitle..."><?php echo esc_textarea( get_option( 'dev_nahian_home_fleet_desc', '' ) ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 5: HOW IT WORKS -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '5. How It Works (3 Steps)', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( '3-step rental journey cards setup.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_hiw" value="1" <?php checked( $show_hiw, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_hiw_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hiw_tag', '' ) ); ?>" placeholder="e.g. Simplicity First">
                        <input type="text" name="dev_nahian_home_hiw_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hiw_title', '' ) ); ?>" placeholder="e.g. How It Works">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_hiw_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter section description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_hiw_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Step 1 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_hiw_s1_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hiw_s1_title', '' ) ); ?>" placeholder="Step 1 Title">
                        <textarea name="dev_nahian_home_hiw_s1_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Step 1 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_hiw_s1_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Step 2 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_hiw_s2_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hiw_s2_title', '' ) ); ?>" placeholder="Step 2 Title">
                        <textarea name="dev_nahian_home_hiw_s2_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Step 2 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_hiw_s2_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label><?php esc_html_e( 'Step 3 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_hiw_s3_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_hiw_s3_title', '' ) ); ?>" placeholder="Step 3 Title">
                        <textarea name="dev_nahian_home_hiw_s3_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Step 3 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_hiw_s3_desc', '' ) ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 6: CALL TO ACTION BANNER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '6. Call To Action Banner', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Conversion banner with phone line & reservation buttons.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_cta" value="1" <?php checked( $show_cta, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label><?php esc_html_e( 'Headline & Subtitle', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_cta_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cta_title', '' ) ); ?>" placeholder="e.g. Ready to Experience Frictionless Travel?">
                        <textarea name="dev_nahian_home_cta_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Enter CTA description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_cta_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Action Button Text & URL', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_cta_btn1_text" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cta_btn1_text', '' ) ); ?>" placeholder="Button Label">
                        <input type="text" name="dev_nahian_home_cta_btn1_url" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cta_btn1_url', '' ) ); ?>" placeholder="Target URL">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Direct Phone Number', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_cta_phone" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cta_phone', '' ) ); ?>" placeholder="+1 (800) 000-0000">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 7: PROCESS TIMELINE -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '7. Complete 4-Step Process Timeline', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( '4-phase sequential timeline block setup.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_proc" value="1" <?php checked( $show_proc, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_proc_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_proc_tag', '' ) ); ?>" placeholder="e.g. Effortless Execution">
                        <input type="text" name="dev_nahian_home_proc_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_proc_title', '' ) ); ?>" placeholder="e.g. Complete 4-Step Process">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_proc_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter section description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_proc_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Stage 1 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_proc_s1_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_proc_s1_title', '' ) ); ?>" placeholder="Stage 1 Title">
                        <textarea name="dev_nahian_home_proc_s1_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Stage 1 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_proc_s1_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Stage 2 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_proc_s2_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_proc_s2_title', '' ) ); ?>" placeholder="Stage 2 Title">
                        <textarea name="dev_nahian_home_proc_s2_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Stage 2 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_proc_s2_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Stage 3 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_proc_s3_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_proc_s3_title', '' ) ); ?>" placeholder="Stage 3 Title">
                        <textarea name="dev_nahian_home_proc_s3_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Stage 3 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_proc_s3_desc', '' ) ); ?></textarea>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Stage 4 Title & Description', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_proc_s4_title" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_proc_s4_title', '' ) ); ?>" placeholder="Stage 4 Title">
                        <textarea name="dev_nahian_home_proc_s4_desc" style="margin-top: 6px;" class="dev-nahian-textarea" placeholder="Stage 4 Description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_proc_s4_desc', '' ) ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 8: FAQ REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '8. Frequently Asked Questions (FAQ)', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Expandable accordion question & answer list.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_faq" value="1" <?php checked( $show_faq, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2" style="margin-bottom: 15px;">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_faq_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_faq_tag', '' ) ); ?>" placeholder="e.g. Common Inquiries">
                        <input type="text" name="dev_nahian_home_faq_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_faq_title', '' ) ); ?>" placeholder="e.g. Frequently Asked Questions">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_faq_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter FAQ description..."><?php echo esc_textarea( get_option( 'dev_nahian_home_faq_desc', '' ) ); ?></textarea>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_faq_btn" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add FAQ Item', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_faq_repeater_wrap" style="display: flex; flex-direction: column; gap: 12px;">
                    <?php if ( ! empty( $saved_faqs ) ) : ?>
                        <?php foreach ( $saved_faqs as $fq ) : ?>
                            <div class="dn-faq-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #0f172a; font-size: 13px;"><?php esc_html_e( 'Question & Answer', 'dev-nahian-car' ); ?></strong>
                                    <button type="button" class="dn-remove-faq-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                                </div>
                                <input type="text" name="faq_question[]" class="dev-nahian-input" value="<?php echo esc_attr( $fq['question'] ?? '' ); ?>" placeholder="Question">
                                <textarea name="faq_answer[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Answer text..."><?php echo esc_textarea( $fq['answer'] ?? '' ); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- SECTION 9: COUNTERS -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '9. Milestone Stat Counters (4 Nodes)', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Animated statistics counter strip settings.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_counters" value="1" <?php checked( $show_counters, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Counter 1 (Value | Suffix | Label)', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_cnt1_val" style="width: 80px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt1_val', '' ) ); ?>" placeholder="150">
                            <input type="text" name="dev_nahian_home_cnt1_suf" style="width: 60px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt1_suf', '' ) ); ?>" placeholder="+">
                            <input type="text" name="dev_nahian_home_cnt1_lbl" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt1_lbl', '' ) ); ?>" placeholder="Fleet Vehicles">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Counter 2 (Value | Suffix | Label)', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_cnt2_val" style="width: 80px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt2_val', '' ) ); ?>" placeholder="48">
                            <input type="text" name="dev_nahian_home_cnt2_suf" style="width: 60px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt2_suf', '' ) ); ?>" placeholder="k">
                            <input type="text" name="dev_nahian_home_cnt2_lbl" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt2_lbl', '' ) ); ?>" placeholder="Expeditions">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Counter 3 (Value | Suffix | Label)', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_cnt3_val" style="width: 80px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt3_val', '' ) ); ?>" placeholder="24">
                            <input type="text" name="dev_nahian_home_cnt3_suf" style="width: 60px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt3_suf', '' ) ); ?>" placeholder="/7">
                            <input type="text" name="dev_nahian_home_cnt3_lbl" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt3_lbl', '' ) ); ?>" placeholder="Concierge Hub">
                        </div>
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Counter 4 (Value | Suffix | Label)', 'dev-nahian-car' ); ?></label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="dev_nahian_home_cnt4_val" style="width: 80px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt4_val', '' ) ); ?>" placeholder="99">
                            <input type="text" name="dev_nahian_home_cnt4_suf" style="width: 60px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt4_suf', '' ) ); ?>" placeholder="%">
                            <input type="text" name="dev_nahian_home_cnt4_lbl" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_cnt4_lbl', '' ) ); ?>" placeholder="Positive Ratings">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 10: ARTICLES HEADER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '10. Latest Articles Section', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Blog journal preview header and grid settings.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_blog" value="1" <?php checked( $show_blog, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_blog_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_blog_tag', '' ) ); ?>" placeholder="e.g. Editorial Dispatch">
                        <input type="text" name="dev_nahian_home_blog_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_blog_title', '' ) ); ?>" placeholder="e.g. The Veloce Journal">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_blog_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter articles subtitle..."><?php echo esc_textarea( get_option( 'dev_nahian_home_blog_desc', '' ) ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 11: TESTIMONIALS REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '11. Driver Testimonials Section', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Client reviews carousel settings.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_home_show_testimonials" value="1" <?php checked( $show_testimonials, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2" style="margin-bottom: 15px;">
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Badge Text & Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" name="dev_nahian_home_testi_tag" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_testi_tag', '' ) ); ?>" placeholder="e.g. Verified Drivers">
                        <input type="text" name="dev_nahian_home_testi_title" style="margin-top: 6px;" class="dev-nahian-input" value="<?php echo esc_attr( get_option( 'dev_nahian_home_testi_title', '' ) ); ?>" placeholder="e.g. What Drivers Say">
                    </div>
                    <div class="dev-nahian-field-box">
                        <label><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea name="dev_nahian_home_testi_desc" class="dev-nahian-textarea" style="height: 84px;" placeholder="Enter testimonials subtitle..."><?php echo esc_textarea( get_option( 'dev_nahian_home_testi_desc', '' ) ); ?></textarea>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_testi_btn" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add Review Card', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_testi_repeater_wrap" style="display: flex; flex-direction: column; gap: 14px;">
                    <?php if ( ! empty( $saved_testis ) ) : ?>
                        <?php foreach ( $saved_testis as $t ) : 
                            $has_avatar = ! empty( $t['avatar'] );
                        ?>
                            <div class="dn-testi-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #0f172a; font-size: 13px;"><?php esc_html_e( 'Review Card', 'dev-nahian-car' ); ?></strong>
                                    <button type="button" class="dn-remove-testi-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                                </div>
                                <div class="dev-nahian-grid-2">
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Reviewer Name', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="testi_name[]" class="dev-nahian-input" value="<?php echo esc_attr( $t['name'] ?? '' ); ?>" placeholder="e.g. Sarah Jenkins">
                                    </div>
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Role / Company', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="testi_role[]" class="dev-nahian-input" value="<?php echo esc_attr( $t['role'] ?? '' ); ?>" placeholder="e.g. Executive Partner">
                                    </div>
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Rating Stars (1 to 5)', 'dev-nahian-car' ); ?></label>
                                        <input type="number" name="testi_stars[]" class="dev-nahian-input" min="1" max="5" value="<?php echo esc_attr( $t['stars'] ?? 5 ); ?>">
                                    </div>
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Avatar Photo', 'dev-nahian-car' ); ?></label>
                                        <div class="dev-nahian-media-upload">
                                            <input type="text" name="testi_avatar[]" class="dev-nahian-input dn-testi-img-url" value="<?php echo esc_attr( $t['avatar'] ?? '' ); ?>" placeholder="https://example.com/avatar.jpg">
                                            <button type="button" class="dev-nahian-media-btn dn-testi-upload-btn"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                                            <button type="button" class="dev-nahian-media-btn dn-testi-remove-btn" style="<?php echo $has_avatar ? '' : 'display:none;'; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                                        </div>
                                        <div class="dn-testi-preview-wrap" style="<?php echo $has_avatar ? '' : 'display:none;'; ?> margin-top: 8px;">
                                            <img src="<?php echo esc_url( $t['avatar'] ?? '' ); ?>" alt="Avatar" class="dn-testi-preview-img" style="height: 44px; width: 44px; border-radius: 50%; border: 1px solid #cbd5e1; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                                        <label><?php esc_html_e( 'Review Quote', 'dev-nahian-car' ); ?></label>
                                        <textarea name="testi_text[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Reviewer comments..."><?php echo esc_textarea( $t['text'] ?? '' ); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts for Accordion Toggles, Repeaters and Media Uploaders -->
    <script id="dn-home-scripts-js">
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

            // Media uploader handler
            $(document).on('click', '.dn-media-btn', function(e) {
                e.preventDefault();
                var targetInput   = $(this).data('target');
                var targetPreview = $(this).data('preview');
                var targetWrap    = $(this).data('wrap');
                var removeBtn     = $(this).siblings('.dn-remove-btn');

                var frame = wp.media({
                    title: '<?php echo esc_js( __( 'Select or Upload Media Asset', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use this Asset', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $(targetInput).val(attachment.url);
                    $(targetPreview).attr('src', attachment.url);
                    $(targetWrap).show();
                    removeBtn.show();
                }).open();
            });

            $(document).on('click', '.dn-remove-btn', function(e) {
                e.preventDefault();
                var targetInput   = $(this).data('target');
                var targetPreview = $(this).data('preview');
                var targetWrap    = $(this).data('wrap');

                $(targetInput).val('');
                $(targetPreview).attr('src', '');
                $(targetWrap).hide();
                $(this).hide();
            });

            // FAQ Repeater
            $('#dn_add_faq_btn').on('click', function(e) {
                e.preventDefault();
                var rowHtml = '\
                <div class="dn-faq-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; display: flex; flex-direction: column; gap: 8px;">\
                    <div style="display: flex; justify-content: space-between; align-items: center;">\
                        <strong style="color: #0f172a; font-size: 13px;"><?php echo esc_js( __( 'Question & Answer', 'dev-nahian-car' ) ); ?></strong>\
                        <button type="button" class="dn-remove-faq-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;"><?php echo esc_js( __( 'Remove', 'dev-nahian-car' ) ); ?></button>\
                    </div>\
                    <input type="text" name="faq_question[]" class="dev-nahian-input" placeholder="Question">\
                    <textarea name="faq_answer[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Answer text..."></textarea>\
                </div>';
                $('#dn_faq_repeater_wrap').append(rowHtml);
            });

            $(document).on('click', '.dn-remove-faq-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-faq-repeater-row').remove();
            });

            // Testimonials Repeater
            $('#dn_add_testi_btn').on('click', function(e) {
                e.preventDefault();
                var rowHtml = '\
                <div class="dn-testi-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; display: flex; flex-direction: column; gap: 12px;">\
                    <div style="display: flex; justify-content: space-between; align-items: center;">\
                        <strong style="color: #0f172a; font-size: 13px;"><?php echo esc_js( __( 'Review Card', 'dev-nahian-car' ) ); ?></strong>\
                        <button type="button" class="dn-remove-testi-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer;"><?php echo esc_js( __( 'Remove', 'dev-nahian-car' ) ); ?></button>\
                    </div>\
                    <div class="dev-nahian-grid-2">\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Reviewer Name', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="testi_name[]" class="dev-nahian-input" placeholder="e.g. Sarah Jenkins">\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Role / Company', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="testi_role[]" class="dev-nahian-input" placeholder="e.g. Executive Partner">\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Rating Stars (1 to 5)', 'dev-nahian-car' ) ); ?></label>\
                            <input type="number" name="testi_stars[]" class="dev-nahian-input" min="1" max="5" value="5">\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Avatar Photo', 'dev-nahian-car' ) ); ?></label>\
                            <div class="dev-nahian-media-upload">\
                                <input type="text" name="testi_avatar[]" class="dev-nahian-input dn-testi-img-url" placeholder="https://example.com/avatar.jpg">\
                                <button type="button" class="dev-nahian-media-btn dn-testi-upload-btn"><?php echo esc_js( __( 'Upload', 'dev-nahian-car' ) ); ?></button>\
                                <button type="button" class="dev-nahian-media-btn dn-testi-remove-btn" style="display:none; background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php echo esc_js( __( 'Remove', 'dev-nahian-car' ) ); ?></button>\
                            </div>\
                            <div class="dn-testi-preview-wrap" style="display:none; margin-top: 8px;">\
                                <img src="" alt="Avatar" class="dn-testi-preview-img" style="height: 44px; width: 44px; border-radius: 50%; border: 1px solid #cbd5e1; object-fit: cover;">\
                            </div>\
                        </div>\
                        <div class="dev-nahian-field-box dev-nahian-grid-full">\
                            <label><?php echo esc_js( __( 'Review Quote', 'dev-nahian-car' ) ); ?></label>\
                            <textarea name="testi_text[]" class="dev-nahian-textarea" style="height: 60px;" placeholder="Reviewer comments..."></textarea>\
                        </div>\
                    </div>\
                </div>';
                $('#dn_testi_repeater_wrap').append(rowHtml);
            });

            $(document).on('click', '.dn-remove-testi-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-testi-repeater-row').remove();
            });

            // Testimonial Avatar Upload
            $(document).on('click', '.dn-testi-upload-btn', function(e) {
                e.preventDefault();
                var $row = $(this).closest('.dn-testi-repeater-row');
                var uploader = wp.media({
                    title: '<?php echo esc_js( __( 'Select Reviewer Avatar', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use Photo', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $row.find('.dn-testi-img-url').val(attachment.url);
                    $row.find('.dn-testi-preview-img').attr('src', attachment.url);
                    $row.find('.dn-testi-preview-wrap').show();
                    $row.find('.dn-testi-remove-btn').show();
                }).open();
            });

            $(document).on('click', '.dn-testi-remove-btn', function(e) {
                e.preventDefault();
                var $row = $(this).closest('.dn-testi-repeater-row');
                $row.find('.dn-testi-img-url').val('');
                $row.find('.dn-testi-preview-img').attr('src', '');
                $row.find('.dn-testi-preview-wrap').hide();
                $(this).hide();
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Single targeted hook registration (prevents duplicate rendering)
add_action( 'dev_nahian_render_subtab_home', function() {
    dev_nahian_render_subtab_home_panel( 'home' );
});