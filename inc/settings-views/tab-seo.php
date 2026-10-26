<?php
/**
 * Settings Tab: SEO & Social Directives
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
 * 1. Dedicated Direct Save Handler for SEO Module
 */
add_action( 'dev_nahian_save_settings_data', function( $data ) {
    if ( ! isset( $data['dev_nahian_active_tab_tracker'] ) || 'seo' !== $data['dev_nahian_active_tab_tracker'] ) {
        return;
    }

    // Core Meta
    update_option( 'dev_nahian_seo_meta_title', sanitize_text_field( $data['dev_nahian_seo_meta_title'] ?? '' ) );
    update_option( 'dev_nahian_seo_meta_desc', sanitize_textarea_field( $data['dev_nahian_seo_meta_desc'] ?? '' ) );
    update_option( 'dev_nahian_seo_keywords', sanitize_textarea_field( $data['dev_nahian_seo_keywords'] ?? '' ) );
    update_option( 'dev_nahian_seo_robots', sanitize_text_field( $data['dev_nahian_seo_robots'] ?? '' ) );
    update_option( 'dev_nahian_seo_canonical_mode', sanitize_key( $data['dev_nahian_seo_canonical_mode'] ?? 'self' ) );

    // Social & Open Graph
    update_option( 'dev_nahian_seo_og_title', sanitize_text_field( $data['dev_nahian_seo_og_title'] ?? '' ) );
    update_option( 'dev_nahian_seo_og_desc', sanitize_textarea_field( $data['dev_nahian_seo_og_desc'] ?? '' ) );
    update_option( 'dev_nahian_seo_og_image', esc_url_raw( trim( $data['dev_nahian_seo_og_image'] ?? '' ) ) );
    update_option( 'dev_nahian_seo_twitter_handle', sanitize_text_field( $data['dev_nahian_seo_twitter_handle'] ?? '' ) );
    update_option( 'dev_nahian_seo_twitter_card', sanitize_text_field( $data['dev_nahian_seo_twitter_card'] ?? 'summary_large_image' ) );

    // Schema.org Structured Data
    update_option( 'dev_nahian_seo_schema_type', sanitize_key( $data['dev_nahian_seo_schema_type'] ?? '' ) );
    update_option( 'dev_nahian_seo_price_range', sanitize_text_field( $data['dev_nahian_seo_price_range'] ?? '' ) );

    // Webmaster Verifications
    update_option( 'dev_nahian_seo_google_verify', sanitize_text_field( $data['dev_nahian_seo_google_verify'] ?? '' ) );
    update_option( 'dev_nahian_seo_bing_verify', sanitize_text_field( $data['dev_nahian_seo_bing_verify'] ?? '' ) );
    update_option( 'dev_nahian_seo_pinterest_verify', sanitize_text_field( $data['dev_nahian_seo_pinterest_verify'] ?? '' ) );

    // Header & Body Scripts
    update_option( 'dev_nahian_seo_header_scripts', wp_unslash( $data['dev_nahian_seo_header_scripts'] ?? '' ) );
    update_option( 'dev_nahian_seo_body_scripts', wp_unslash( $data['dev_nahian_seo_body_scripts'] ?? '' ) );
});

/**
 * 2. Render Panel UI
 */
function dev_nahian_render_seo_tab_content( $active_tab = 'seo' ) {
    if ( 'seo' !== $active_tab ) {
        return;
    }

    $title_val    = get_option( 'dev_nahian_seo_meta_title', '' );
    $desc_val     = get_option( 'dev_nahian_seo_meta_desc', '' );
    $keywords_val = get_option( 'dev_nahian_seo_keywords', '' );
    $robots       = get_option( 'dev_nahian_seo_robots', '' );
    $canonical    = get_option( 'dev_nahian_seo_canonical_mode', 'self' );

    $og_title_val = get_option( 'dev_nahian_seo_og_title', '' );
    $og_desc_val  = get_option( 'dev_nahian_seo_og_desc', '' );
    $og_img_val   = get_option( 'dev_nahian_seo_og_image', '' );
    $tw_handle    = get_option( 'dev_nahian_seo_twitter_handle', '' );
    $card_type    = get_option( 'dev_nahian_seo_twitter_card', 'summary_large_image' );

    $schema_type  = get_option( 'dev_nahian_seo_schema_type', '' );
    $price_range  = get_option( 'dev_nahian_seo_price_range', '' );

    $google_ver   = get_option( 'dev_nahian_seo_google_verify', '' );
    $bing_ver     = get_option( 'dev_nahian_seo_bing_verify', '' );
    $head_scripts = get_option( 'dev_nahian_seo_header_scripts', '' );
    $body_scripts = get_option( 'dev_nahian_seo_body_scripts', '' );

    $site_url_raw = home_url();
    ?>
    <style>
        .dn-seo-studio-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dn-seo-studio-card:hover {
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
        .dn-serp-stage {
            background: #06090e;
            border: 1px solid #334155;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 20px;
        }
        .dn-serp-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 16px 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            font-family: Arial, sans-serif;
            max-width: 100%;
            box-sizing: border-box;
        }
        .dn-serp-cite {
            font-size: 13px;
            color: #202124;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }
        .dn-serp-cite-url {
            color: #4d5156;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dn-serp-title {
            color: #1a0dab;
            font-size: 18px;
            font-weight: 400;
            line-height: 1.3;
            margin: 0 0 4px;
            word-wrap: break-word;
        }
        .dn-serp-snippet {
            color: #4d5156;
            font-size: 13.5px;
            line-height: 1.5;
            margin: 0;
            word-wrap: break-word;
        }
        .dn-count-bar-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
        }
        .dn-counter-badge {
            padding: 2px 7px;
            border-radius: 4px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
        }
        .dn-counter-badge.good { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
        .dn-counter-badge.warn { color: #b45309; background: #fffbeb; border-color: #fde68a; }
        .dn-counter-badge.over { color: #b91c1c; background: #fef2f2; border-color: #fecaca; }
        .dn-social-preview {
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            overflow: hidden;
            max-width: 440px;
        }
        .dn-social-img {
            width: 100%;
            height: 180px;
            background: #1e293b;
            object-fit: cover;
            display: block;
        }
        .dn-social-content {
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            background: #0f172a;
        }
        .dn-social-domain {
            font-size: 10.5px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .dn-social-h {
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }
        .dn-social-p {
            color: #94a3b8;
            font-size: 12px;
            margin: 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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

    <div id="tab-panel-seo">
        <div class="dn-seo-studio">

            <!-- CARD 1: CORE SEARCH ENGINE DIRECTIVES & SERP SIMULATOR -->
            <div class="dn-seo-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-search"></span>
                        <?php esc_html_e( 'Core Search Engine Directives & SERP Preview', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <!-- Real-Time Search Simulator Stage -->
                <div class="dn-serp-stage">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #10b981;">
                            &bull; <?php esc_html_e( 'Live Search Result Simulation', 'dev-nahian-car' ); ?>
                        </span>
                    </div>

                    <div class="dn-serp-card">
                        <div class="dn-serp-cite">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#1a73e8"><circle cx="12" cy="12" r="10"/></svg>
                            <strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
                            <span class="dn-serp-cite-url"><?php echo esc_html( $site_url_raw ); ?></span>
                        </div>
                        <div class="dn-serp-title" id="dnSerpTitlePreview"><?php echo esc_html( ! empty( $title_val ) ? $title_val : get_bloginfo( 'name' ) ); ?></div>
                        <p class="dn-serp-snippet" id="dnSerpDescPreview"><?php echo esc_html( ! empty( $desc_val ) ? $desc_val : get_bloginfo( 'description' ) ); ?></p>
                    </div>
                </div>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_meta_title"><?php esc_html_e( 'Meta Title', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_meta_title" name="dev_nahian_seo_meta_title" class="dev-nahian-input" value="<?php echo esc_attr( $title_val ); ?>" placeholder="e.g. Exotic & Luxury Car Rental">
                        <div class="dn-count-bar-wrap">
                            <span><?php esc_html_e( 'Recommended: 50–60 chars', 'dev-nahian-car' ); ?></span>
                            <span class="dn-counter-badge" id="dnTitleCounter">0 chars</span>
                        </div>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_robots"><?php esc_html_e( 'Robots Indexing Directive', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_seo_robots" name="dev_nahian_seo_robots" class="dev-nahian-select">
                            <option value=""><?php esc_html_e( '-- Select Indexing Directive --', 'dev-nahian-car' ); ?></option>
                            <option value="index, follow" <?php selected( $robots, 'index, follow' ); ?>><?php esc_html_e( 'Index, Follow (Recommended)', 'dev-nahian-car' ); ?></option>
                            <option value="noindex, follow" <?php selected( $robots, 'noindex, follow' ); ?>><?php esc_html_e( 'Noindex, Follow', 'dev-nahian-car' ); ?></option>
                            <option value="noindex, nofollow" <?php selected( $robots, 'noindex, nofollow' ); ?>><?php esc_html_e( 'Noindex, Nofollow (Private / Staging)', 'dev-nahian-car' ); ?></option>
                        </select>
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_seo_meta_desc"><?php esc_html_e( 'Meta Description', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_seo_meta_desc" name="dev_nahian_seo_meta_desc" class="dev-nahian-textarea" style="height: 80px;" placeholder="Enter meta description..."><?php echo esc_textarea( $desc_val ); ?></textarea>
                        <div class="dn-count-bar-wrap">
                            <span><?php esc_html_e( 'Optimal: 140–160 chars', 'dev-nahian-car' ); ?></span>
                            <span class="dn-counter-badge" id="dnDescCounter">0 chars</span>
                        </div>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_keywords"><?php esc_html_e( 'Meta Keywords', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_keywords" name="dev_nahian_seo_keywords" class="dev-nahian-input" value="<?php echo esc_attr( $keywords_val ); ?>" placeholder="e.g. car rental, exotic fleet">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_canonical_mode"><?php esc_html_e( 'Canonical URL Policy', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_seo_canonical_mode" name="dev_nahian_seo_canonical_mode" class="dev-nahian-select">
                            <option value="self" <?php selected( $canonical, 'self' ); ?>><?php esc_html_e( 'Self-Referencing URL', 'dev-nahian-car' ); ?></option>
                            <option value="home" <?php selected( $canonical, 'home' ); ?>><?php esc_html_e( 'Root Domain URL', 'dev-nahian-car' ); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- CARD 2: SOCIAL MEDIA & OPEN GRAPH -->
            <div class="dn-seo-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-share"></span>
                        <?php esc_html_e( 'Social Media & Open Graph Directives', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_og_title"><?php esc_html_e( 'Social Card Title', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_og_title" name="dev_nahian_seo_og_title" class="dev-nahian-input" value="<?php echo esc_attr( $og_title_val ); ?>" placeholder="Leave blank to sync with Meta Title">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_twitter_handle"><?php esc_html_e( 'Twitter / X Handle', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_twitter_handle" name="dev_nahian_seo_twitter_handle" class="dev-nahian-input" value="<?php echo esc_attr( $tw_handle ); ?>" placeholder="@YourBrand">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_seo_og_desc"><?php esc_html_e( 'Social Card Description', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_seo_og_desc" name="dev_nahian_seo_og_desc" class="dev-nahian-textarea" style="height: 60px;" placeholder="Leave blank to sync with Meta Description"><?php echo esc_textarea( $og_desc_val ); ?></textarea>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_og_image"><?php esc_html_e( 'Social Banner Image', 'dev-nahian-car' ); ?></label>
                        <div class="dev-nahian-media-upload">
                            <input type="text" id="dev_nahian_seo_og_image" name="dev_nahian_seo_og_image" class="dev-nahian-input" value="<?php echo esc_attr( $og_img_val ); ?>" placeholder="https://example.com/banner.jpg">
                            <button type="button" class="dev-nahian-media-btn" id="dn_upload_seo_og_btn"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                            <button type="button" class="dev-nahian-media-btn" id="dn_remove_seo_og_btn" style="<?php echo empty( $og_img_val ) ? 'display:none;' : ''; ?> background: #fee2e2; border-color: #fca5a5; color: #b91c1c;"><?php esc_html_e( 'Remove', 'dev-nahian-car' ); ?></button>
                        </div>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_twitter_card"><?php esc_html_e( 'Twitter Card Format', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_seo_twitter_card" name="dev_nahian_seo_twitter_card" class="dev-nahian-select">
                            <option value="summary_large_image" <?php selected( $card_type, 'summary_large_image' ); ?>><?php esc_html_e( 'Large Image (summary_large_image)', 'dev-nahian-car' ); ?></option>
                            <option value="summary" <?php selected( $card_type, 'summary' ); ?>><?php esc_html_e( 'Square Image (summary)', 'dev-nahian-car' ); ?></option>
                        </select>
                    </div>

                    <!-- Live Social Card Feed Simulator -->
                    <div class="dev-nahian-field-box dev-nahian-grid-full" style="margin-top: 10px;">
                        <label><?php esc_html_e( 'Social Feed Preview', 'dev-nahian-car' ); ?></label>
                        <div class="dn-social-preview">
                            <img src="<?php echo esc_url( $og_img_val ); ?>" id="dnSocialImgPreview" class="dn-social-img" alt="Social Preview" style="<?php echo empty( $og_img_val ) ? 'display:none;' : ''; ?>">
                            <div class="dn-social-content">
                                <span class="dn-social-domain"><?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?></span>
                                <h4 class="dn-social-h" id="dnSocialTitlePreview"><?php echo esc_html( ! empty( $og_title_val ) ? $og_title_val : ( ! empty( $title_val ) ? $title_val : get_bloginfo( 'name' ) ) ); ?></h4>
                                <p class="dn-social-p" id="dnSocialDescPreview"><?php echo esc_html( ! empty( $og_desc_val ) ? $og_desc_val : ( ! empty( $desc_val ) ? $desc_val : get_bloginfo( 'description' ) ) ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3: STRUCTURED DATA (SCHEMA.ORG) -->
            <div class="dn-seo-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-code-standards"></span>
                        <?php esc_html_e( 'Structured Data (Schema.org)', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_schema_type"><?php esc_html_e( 'Entity Type', 'dev-nahian-car' ); ?></label>
                        <select id="dev_nahian_seo_schema_type" name="dev_nahian_seo_schema_type" class="dev-nahian-select">
                            <option value=""><?php esc_html_e( '-- Select Schema Type --', 'dev-nahian-car' ); ?></option>
                            <option value="AutoRental" <?php selected( $schema_type, 'AutoRental' ); ?>><?php esc_html_e( 'AutoRental', 'dev-nahian-car' ); ?></option>
                            <option value="LocalBusiness" <?php selected( $schema_type, 'LocalBusiness' ); ?>><?php esc_html_e( 'LocalBusiness', 'dev-nahian-car' ); ?></option>
                            <option value="Corporation" <?php selected( $schema_type, 'Corporation' ); ?>><?php esc_html_e( 'Corporation', 'dev-nahian-car' ); ?></option>
                            <option value="Organization" <?php selected( $schema_type, 'Organization' ); ?>><?php esc_html_e( 'Organization', 'dev-nahian-car' ); ?></option>
                        </select>
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_price_range"><?php esc_html_e( 'Price Range Indicator', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_price_range" name="dev_nahian_seo_price_range" class="dev-nahian-input" value="<?php echo esc_attr( $price_range ); ?>" placeholder="e.g. $$$$">
                    </div>
                </div>
            </div>

            <!-- CARD 4: WEBMASTER TOOLS & SCRIPT INJECTION -->
            <div class="dn-seo-studio-card">
                <div class="dn-studio-card-header">
                    <h3 class="dn-studio-card-title">
                        <span class="dashicons dashicons-admin-network"></span>
                        <?php esc_html_e( 'Webmaster Tools & Script Injection', 'dev-nahian-car' ); ?>
                    </h3>
                </div>

                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_google_verify"><?php esc_html_e( 'Google Verification Code', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_google_verify" name="dev_nahian_seo_google_verify" class="dev-nahian-input" value="<?php echo esc_attr( $google_ver ); ?>" placeholder="google-site-verification token">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_seo_bing_verify"><?php esc_html_e( 'Bing Verification Code', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_seo_bing_verify" name="dev_nahian_seo_bing_verify" class="dev-nahian-input" value="<?php echo esc_attr( $bing_ver ); ?>" placeholder="msvalidate.01 token">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_seo_header_scripts"><?php esc_html_e( 'Header Scripts', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_seo_header_scripts" name="dev_nahian_seo_header_scripts" class="dev-nahian-textarea" style="height: 100px; font-family: monospace; font-size: 12px;" placeholder="<!-- Injected before </head> -->"><?php echo esc_textarea( $head_scripts ); ?></textarea>
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_seo_body_scripts"><?php esc_html_e( 'Body Open Scripts', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_seo_body_scripts" name="dev_nahian_seo_body_scripts" class="dev-nahian-textarea" style="height: 90px; font-family: monospace; font-size: 12px;" placeholder="<!-- Injected after <body> opening tag -->"><?php echo esc_textarea( $body_scripts ); ?></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Live Preview, Counters, & Media Picker Script -->
    <script id="dn-seo-scripts-js">
    (function($) {
        'use strict';

        $(document).ready(function() {
            var titleIn   = $('#dev_nahian_seo_meta_title');
            var descIn    = $('#dev_nahian_seo_meta_desc');
            var ogTitleIn = $('#dev_nahian_seo_og_title');
            var ogDescIn  = $('#dev_nahian_seo_og_desc');
            var ogImgIn   = $('#dev_nahian_seo_og_image');

            var serpTitle = $('#dnSerpTitlePreview');
            var serpDesc  = $('#dnSerpDescPreview');
            var socTitle  = $('#dnSocialTitlePreview');
            var socDesc   = $('#dnSocialDescPreview');
            var socImg    = $('#dnSocialImgPreview');

            var titleCnt  = $('#dnTitleCounter');
            var descCnt   = $('#dnDescCounter');

            function updatePreviews() {
                var title = titleIn.val().trim();
                var desc  = descIn.val().trim();
                var ogTitle = ogTitleIn.val().trim();
                var ogDesc  = ogDescIn.val().trim();
                var ogImg   = ogImgIn.val().trim();

                // SERP
                serpTitle.text(title ? title : '<?php echo esc_js( get_bloginfo( 'name' ) ); ?>');
                serpDesc.text(desc ? desc : '<?php echo esc_js( get_bloginfo( 'description' ) ); ?>');

                // Social
                socTitle.text(ogTitle ? ogTitle : (title ? title : '<?php echo esc_js( get_bloginfo( 'name' ) ); ?>'));
                socDesc.text(ogDesc ? ogDesc : (desc ? desc : '<?php echo esc_js( get_bloginfo( 'description' ) ); ?>'));

                if (ogImg) {
                    socImg.attr('src', ogImg).show();
                } else {
                    socImg.hide();
                }

                // Counters
                var tLen = titleIn.val().length;
                titleCnt.text(tLen + ' chars');
                titleCnt.attr('class', 'dn-counter-badge ' + (tLen >= 50 && tLen <= 65 ? 'good' : (tLen > 65 ? 'over' : 'warn')));

                var dLen = descIn.val().length;
                descCnt.text(dLen + ' chars');
                descCnt.attr('class', 'dn-counter-badge ' + (dLen >= 135 && dLen <= 165 ? 'good' : (dLen > 165 ? 'over' : 'warn')));
            }

            titleIn.on('input', updatePreviews);
            descIn.on('input', updatePreviews);
            ogTitleIn.on('input', updatePreviews);
            ogDescIn.on('input', updatePreviews);
            ogImgIn.on('input change', updatePreviews);

            updatePreviews();

            // WP Media Uploader for OG Image
            $('#dn_upload_seo_og_btn').on('click', function(e) {
                e.preventDefault();

                var mediaFrame = wp.media({
                    title: '<?php echo esc_js( __( 'Select or Upload Social Image', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use as Social Image', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                });

                mediaFrame.on('select', function() {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    ogImgIn.val(attachment.url).trigger('change');
                    $('#dn_remove_seo_og_btn').show();
                });

                mediaFrame.open();
            });

            // Remove OG Image
            $('#dn_remove_seo_og_btn').on('click', function(e) {
                e.preventDefault();
                ogImgIn.val('').trigger('change');
                $(this).hide();
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Single targeted hook registration
add_action( 'dev_nahian_render_tab_panel_seo', 'dev_nahian_render_seo_tab_content', 10, 1 );
add_action( 'dev_nahian_render_tab_panels', function( $active_tab ) {
    dev_nahian_render_seo_tab_content( $active_tab );
}, 10, 1 );

/**
 * 3. Frontend Global Dynamic SEO Head Hook
 */
function dev_nahian_output_dynamic_seo_tags() {
    $meta_title   = get_option( 'dev_nahian_seo_meta_title', '' );
    $meta_desc    = get_option( 'dev_nahian_seo_meta_desc', '' );
    $meta_kw      = get_option( 'dev_nahian_seo_keywords', '' );
    $robots       = get_option( 'dev_nahian_seo_robots', '' );
    $canonical    = get_option( 'dev_nahian_seo_canonical_mode', 'self' );

    $og_title     = get_option( 'dev_nahian_seo_og_title', '' );
    $og_desc      = get_option( 'dev_nahian_seo_og_desc', '' );
    $og_img       = get_option( 'dev_nahian_seo_og_image', '' );
    $tw_handle    = get_option( 'dev_nahian_seo_twitter_handle', '' );
    $tw_card      = get_option( 'dev_nahian_seo_twitter_card', 'summary_large_image' );

    $google_ver   = get_option( 'dev_nahian_seo_google_verify', '' );
    $bing_ver     = get_option( 'dev_nahian_seo_bing_verify', '' );
    $head_scripts = get_option( 'dev_nahian_seo_header_scripts', '' );
    $schema_type  = get_option( 'dev_nahian_seo_schema_type', '' );
    $price_range  = get_option( 'dev_nahian_seo_price_range', '' );

    // Fallbacks
    $final_title = ! empty( $meta_title ) ? $meta_title : wp_get_document_title();
    $final_desc  = ! empty( $meta_desc ) ? $meta_desc : get_bloginfo( 'description' );
    $final_og_t  = ! empty( $og_title ) ? $og_title : $final_title;
    $final_og_d  = ! empty( $og_desc ) ? $og_desc : $final_desc;
    $current_url = 'self' === $canonical ? ( ( is_ssl() ? 'https://' : 'http://' ) . ( $_SERVER['HTTP_HOST'] ?? '' ) . ( $_SERVER['REQUEST_URI'] ?? '' ) ) : home_url();
    ?>
<!-- Dev Nahian SEO Suite -->
<?php if ( ! empty( $robots ) ) : ?>
<meta name="robots" content="<?php echo esc_attr( $robots ); ?>">
<?php endif; ?>
<?php if ( ! empty( $final_desc ) ) : ?>
<meta name="description" content="<?php echo esc_attr( $final_desc ); ?>">
<?php endif; ?>
<?php if ( ! empty( $meta_kw ) ) : ?>
<meta name="keywords" content="<?php echo esc_attr( $meta_kw ); ?>">
<?php endif; ?>
<link rel="canonical" href="<?php echo esc_url( $current_url ); ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo esc_url( $current_url ); ?>">
<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
<meta property="og:title" content="<?php echo esc_attr( $final_og_t ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $final_og_d ); ?>">
<?php if ( ! empty( $og_img ) ) : ?>
<meta property="og:image" content="<?php echo esc_url( $og_img ); ?>">
<?php endif; ?>

<!-- Twitter Cards -->
<?php if ( ! empty( $tw_card ) ) : ?>
<meta name="twitter:card" content="<?php echo esc_attr( $tw_card ); ?>">
<?php endif; ?>
<?php if ( ! empty( $tw_handle ) ) : ?>
<meta name="twitter:site" content="<?php echo esc_attr( $tw_handle ); ?>">
<meta name="twitter:creator" content="<?php echo esc_attr( $tw_handle ); ?>">
<?php endif; ?>
<meta name="twitter:title" content="<?php echo esc_attr( $final_og_t ); ?>">
<meta name="twitter:description" content="<?php echo esc_attr( $final_og_d ); ?>">
<?php if ( ! empty( $og_img ) ) : ?>
<meta name="twitter:image" content="<?php echo esc_url( $og_img ); ?>">
<?php endif; ?>

<!-- Webmaster Verifications -->
<?php if ( ! empty( $google_ver ) ) : ?>
<?php if ( strpos( $google_ver, '<meta' ) !== false ) : ?>
<?php echo $google_ver; ?>
<?php else : ?>
<meta name="google-site-verification" content="<?php echo esc_attr( $google_ver ); ?>">
<?php endif; ?>
<?php endif; ?>
<?php if ( ! empty( $bing_ver ) ) : ?>
<meta name="msvalidate.01" content="<?php echo esc_attr( $bing_ver ); ?>">
<?php endif; ?>

<!-- Schema.org JSON-LD Structured Data -->
<?php if ( ! empty( $schema_type ) ) : ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "<?php echo esc_js( $schema_type ); ?>",
  "name": "<?php echo esc_js( get_bloginfo( 'name' ) ); ?>",
  "url": "<?php echo esc_url( home_url() ); ?>",
  "description": "<?php echo esc_js( $final_desc ); ?>"<?php if ( ! empty( $price_range ) ) : ?>,
  "priceRange": "<?php echo esc_js( $price_range ); ?>"<?php endif; ?><?php if ( ! empty( $og_img ) ) : ?>,
  "image": "<?php echo esc_url( $og_img ); ?>"<?php endif; ?>
}
</script>
<?php endif; ?>

<?php if ( ! empty( $head_scripts ) ) : ?>
<?php echo $head_scripts; ?>
<?php endif; ?>
<!-- End Dev Nahian SEO Suite -->
    <?php
}
add_action( 'wp_head', 'dev_nahian_output_dynamic_seo_tags', 1 );

/**
 * 4. Custom Body Open Scripts
 */
function dev_nahian_output_body_open_scripts() {
    $body_scripts = get_option( 'dev_nahian_seo_body_scripts', '' );
    if ( ! empty( $body_scripts ) ) {
        echo $body_scripts;
    }
}
add_action( 'wp_body_open', 'dev_nahian_output_body_open_scripts', 1 );