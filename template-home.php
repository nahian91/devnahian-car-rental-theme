<?php
/**
 * Template Name: Homepage
 * Description: Clean, dynamic front-page template with section visibility controls and zero default data.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since 1.0.0
 */

get_header(); 

global $wpdb;

// 1. SECTION VISIBILITY SWITCHES
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

// 2. HERO & DISPATCH
$hero_eyebrow = get_option( 'dev_nahian_home_hero_eyebrow', '' );
$hero_title   = get_option( 'dev_nahian_home_hero_title', '' );
$hero_desc    = get_option( 'dev_nahian_home_hero_desc', '' );
$btn1_text    = get_option( 'dev_nahian_home_hero_btn1_text', '' );
$btn1_url     = get_option( 'dev_nahian_home_hero_btn1_url', '' );
$btn2_text    = get_option( 'dev_nahian_home_hero_btn2_text', '' );
$btn2_url     = get_option( 'dev_nahian_home_hero_btn2_url', '' );
$trust_score  = get_option( 'dev_nahian_home_trust_score', '' );
$trust_text   = get_option( 'dev_nahian_home_trust_text', '' );
$feat_pill_1  = get_option( 'dev_nahian_home_feat_pill_1', '' );
$feat_pill_2  = get_option( 'dev_nahian_home_feat_pill_2', '' );
$feat_pill_3  = get_option( 'dev_nahian_home_feat_pill_3', '' );
$disp_title   = get_option( 'dev_nahian_home_dispatch_title', '' );
$disp_sub     = get_option( 'dev_nahian_home_dispatch_subtitle', '' );
$disp_pickup  = get_option( 'dev_nahian_home_dispatch_pickup', '' );
$disp_return  = get_option( 'dev_nahian_home_dispatch_return', '' );

// 3. ABOUT US
$about_tag    = get_option( 'dev_nahian_home_about_tag', '' );
$about_title  = get_option( 'dev_nahian_home_about_title', '' );
$about_desc   = get_option( 'dev_nahian_home_about_desc', '' );
$about_img1   = get_option( 'dev_nahian_home_about_img1', '' );
$about_img2   = get_option( 'dev_nahian_home_about_img2', '' );
$telem_status = get_option( 'dev_nahian_home_about_telemetry_status', '' );
$about_c1     = get_option( 'dev_nahian_home_about_check_1', '' );
$about_c2     = get_option( 'dev_nahian_home_about_check_2', '' );
$about_c3     = get_option( 'dev_nahian_home_about_check_3', '' );

// 4. SERVICES
$services_tag = get_option( 'dev_nahian_home_services_tag', '' );
$services_h2  = get_option( 'dev_nahian_home_services_title', '' );
$services_sub = get_option( 'dev_nahian_home_services_desc', '' );
$services_data= get_option( 'dev_nahian_services_items_data', array() );

// 5. FLEET SECTION
$fleet_tag    = get_option( 'dev_nahian_home_fleet_tag', '' );
$fleet_h2     = get_option( 'dev_nahian_home_fleet_title', '' );
$fleet_sub    = get_option( 'dev_nahian_home_fleet_desc', '' );

// 6. HOW IT WORKS
$hiw_tag      = get_option( 'dev_nahian_home_hiw_tag', '' );
$hiw_title    = get_option( 'dev_nahian_home_hiw_title', '' );
$hiw_desc     = get_option( 'dev_nahian_home_hiw_desc', '' );
$hiw_s1_t     = get_option( 'dev_nahian_home_hiw_s1_title', '' );
$hiw_s1_d     = get_option( 'dev_nahian_home_hiw_s1_desc', '' );
$hiw_s2_t     = get_option( 'dev_nahian_home_hiw_s2_title', '' );
$hiw_s2_d     = get_option( 'dev_nahian_home_hiw_s2_desc', '' );
$hiw_s3_t     = get_option( 'dev_nahian_home_hiw_s3_title', '' );
$hiw_s3_d     = get_option( 'dev_nahian_home_hiw_s3_desc', '' );

// 7. CTA BANNER
$cta_title    = get_option( 'dev_nahian_home_cta_title', '' );
$cta_desc     = get_option( 'dev_nahian_home_cta_desc', '' );
$cta_btn_text = get_option( 'dev_nahian_home_cta_btn1_text', '' );
$cta_btn_url  = get_option( 'dev_nahian_home_cta_btn1_url', '' );
$cta_phone    = get_option( 'dev_nahian_home_cta_phone', '' );
$clean_cta_phone = preg_replace( '/[^\d+]/', '', $cta_phone );

// 8. PROCESS TIMELINE
$proc_tag     = get_option( 'dev_nahian_home_proc_tag', '' );
$proc_title   = get_option( 'dev_nahian_home_proc_title', '' );
$proc_desc    = get_option( 'dev_nahian_home_proc_desc', '' );
$proc_s1_t    = get_option( 'dev_nahian_home_proc_s1_title', '' );
$proc_s1_d    = get_option( 'dev_nahian_home_proc_s1_desc', '' );
$proc_s2_t    = get_option( 'dev_nahian_home_proc_s2_title', '' );
$proc_s2_d    = get_option( 'dev_nahian_home_proc_s2_desc', '' );
$proc_s3_t    = get_option( 'dev_nahian_home_proc_s3_title', '' );
$proc_s3_d    = get_option( 'dev_nahian_home_proc_s3_desc', '' );
$proc_s4_t    = get_option( 'dev_nahian_home_proc_s4_title', '' );
$proc_s4_d    = get_option( 'dev_nahian_home_proc_s4_desc', '' );

// 9. FAQ
$faq_tag      = get_option( 'dev_nahian_home_faq_tag', '' );
$faq_title    = get_option( 'dev_nahian_home_faq_title', '' );
$faq_desc     = get_option( 'dev_nahian_home_faq_desc', '' );
$faqs         = get_option( 'dev_nahian_home_faqs_data', array() );

// 10. COUNTERS
$cnt1_val     = get_option( 'dev_nahian_home_cnt1_val', '' );
$cnt1_suf     = get_option( 'dev_nahian_home_cnt1_suf', '' );
$cnt1_lbl     = get_option( 'dev_nahian_home_cnt1_lbl', '' );
$cnt2_val     = get_option( 'dev_nahian_home_cnt2_val', '' );
$cnt2_suf     = get_option( 'dev_nahian_home_cnt2_suf', '' );
$cnt2_lbl     = get_option( 'dev_nahian_home_cnt2_lbl', '' );
$cnt3_val     = get_option( 'dev_nahian_home_cnt3_val', '' );
$cnt3_suf     = get_option( 'dev_nahian_home_cnt3_suf', '' );
$cnt3_lbl     = get_option( 'dev_nahian_home_cnt3_lbl', '' );
$cnt4_val     = get_option( 'dev_nahian_home_cnt4_val', '' );
$cnt4_suf     = get_option( 'dev_nahian_home_cnt4_suf', '' );
$cnt4_lbl     = get_option( 'dev_nahian_home_cnt4_lbl', '' );

// 11. ARTICLES HEADER
$blog_tag     = get_option( 'dev_nahian_home_blog_tag', '' );
$blog_title   = get_option( 'dev_nahian_home_blog_title', '' );
$blog_desc    = get_option( 'dev_nahian_home_blog_desc', '' );

// 12. TESTIMONIALS
$testi_tag    = get_option( 'dev_nahian_home_testi_tag', '' );
$testi_title  = get_option( 'dev_nahian_home_testi_title', '' );
$testi_desc   = get_option( 'dev_nahian_home_testi_desc', '' );
$testimonials = get_option( 'dev_nahian_home_testimonials_data', array() );

// Query Vehicles
$table_cars = $wpdb->prefix . 'dev_nahian_cars';
$cars_exist = $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_cars ) ) === $table_cars;
$vehicles   = array();
if ( $cars_exist ) {
    $vehicles = $wpdb->get_results( "SELECT * FROM {$table_cars} WHERE status = 'ready' ORDER BY id DESC LIMIT 6", ARRAY_A );
}
?>

<style id="dev-nahian-homepage-styles">
  :root {
    --dn-home-primary: var(--dev-nahian-car-primary, #111827);
    --dn-home-primary-hover: var(--dev-nahian-car-primary-hover, #1f2937);
    --dn-home-gold: var(--dev-nahian-car-gold, #b88e1e);
    --dn-home-gold-glow: rgba(184, 142, 30, 0.12);
    --dn-home-gold-border: rgba(184, 142, 30, 0.3);
    --dn-home-dark: var(--dev-nahian-car-text-dark, #0f172a);
    --dn-home-muted: var(--dev-nahian-car-text-muted, #64748b);
    --dn-home-border: var(--dev-nahian-car-border, #e2e8f0);
    --dn-home-bg-light: var(--dev-nahian-car-bg-light, #f8fafc);
    --dn-home-radius: var(--dev-nahian-car-radius, 12px);
  }

  /* Global Section Layouts */
  .dev-nahian-car-section-about,
  .dev-nahian-car-section-services,
  .dev-nahian-car-section-fleet,
  .dev-nahian-car-section-hiw,
  .dev-nahian-car-section-process,
  .dev-nahian-car-section-faq,
  .dev-nahian-car-section-counter,
  .dev-nahian-car-section-articles,
  .dev-nahian-car-section-testimonials {
    padding: 80px 20px;
    max-width: 1240px;
    margin: 0 auto;
  }

  .dev-nahian-car-section-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 48px;
  }

  .dev-nahian-car-section-tag-lead {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--dn-home-gold);
    background: var(--dn-home-gold-glow);
    border: 1px solid var(--dn-home-gold-border);
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 14px;
  }

  .dev-nahian-car-section-header h2 {
    font-size: clamp(2rem, 3.5vw, 2.6rem);
    font-weight: 800;
    color: var(--dn-home-dark);
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0 0 10px;
  }

  .dev-nahian-car-section-header p {
    color: var(--dn-home-muted);
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
  }

  /* 1. Hero Section */
  .dev-nahian-car-hero {
    background: radial-gradient(circle at top right, rgba(184, 142, 30, 0.08) 0%, transparent 60%), #ffffff;
    padding: 80px 20px 100px;
    border-bottom: 1px solid var(--dn-home-border);
  }

  .dev-nahian-car-hero-wrap {
    max-width: 1240px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 48px;
    align-items: center;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-hero-wrap {
      grid-template-columns: 1.1fr 0.9fr;
    }
  }

  .dev-nahian-car-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--dn-home-gold);
    background: var(--dn-home-gold-glow);
    border: 1px solid var(--dn-home-gold-border);
    padding: 5px 14px;
    border-radius: 999px;
    margin-bottom: 18px;
  }

  .dev-nahian-car-hero-eyebrow-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--dn-home-gold);
  }

  .dev-nahian-car-hero h1 {
    font-size: clamp(2.3rem, 4.4vw, 3.4rem);
    font-weight: 900;
    line-height: 1.1;
    letter-spacing: -0.03em;
    color: var(--dn-home-dark);
    margin: 0 0 16px;
  }

  .dev-nahian-car-hero h1 span {
    color: var(--dn-home-gold);
  }

  .dev-nahian-car-hero p {
    font-size: 1.05rem;
    line-height: 1.65;
    color: var(--dn-home-muted);
    margin: 0 0 28px;
  }

  .dev-nahian-car-hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 32px;
  }

  .dev-nahian-car-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    font-size: 0.92rem;
    font-weight: 700;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-sizing: border-box;
  }

  .dev-nahian-car-btn-primary {
    background: var(--dn-home-primary);
    color: #ffffff;
    border: 1px solid var(--dn-home-primary);
  }

  .dev-nahian-car-btn-primary:hover {
    background: var(--dn-home-primary-hover);
  }

  .dev-nahian-car-btn-secondary {
    background: #ffffff;
    color: var(--dn-home-dark);
    border: 1px solid var(--dn-home-border);
  }

  .dev-nahian-car-btn-secondary:hover {
    background: var(--dn-home-bg-light);
  }

  .dev-nahian-car-hero-trust-bar {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
  }

  .dev-nahian-car-trust-text {
    font-size: 0.85rem;
    color: var(--dn-home-dark);
    font-weight: 600;
  }

  .dev-nahian-car-trust-text span {
    color: var(--dn-home-gold);
    font-weight: 800;
  }

  .dev-nahian-car-hero-features {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
  }

  .dev-nahian-car-feature-point {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--dn-home-dark);
  }

  .dev-nahian-car-feature-point svg {
    color: var(--dn-home-gold);
  }

  /* Dispatch Card */
  .dev-nahian-car-hero-dispatch-card {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 12px 36px -6px rgba(15, 23, 42, 0.08);
  }

  .dev-nahian-car-dispatch-header h3 {
    font-size: 1.35rem;
    font-weight: 800;
    margin: 0 0 4px;
    color: var(--dn-home-dark);
  }

  .dev-nahian-car-dispatch-header p {
    font-size: 0.85rem;
    color: var(--dn-home-muted);
    margin: 0 0 20px;
  }

  .dev-nahian-car-dispatch-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  .dev-nahian-car-form-col-full {
    grid-column: span 2;
  }

  .dev-nahian-car-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .dev-nahian-car-form-group label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--dn-home-dark);
  }

  .dev-nahian-car-input-control {
    width: 100%;
    height: 44px;
    border: 1px solid var(--dn-home-border);
    border-radius: 6px;
    padding: 0 12px;
    font-size: 0.86rem;
    color: var(--dn-home-dark);
    background: var(--dn-home-bg-light);
    outline: none;
    box-sizing: border-box;
  }

  .dev-nahian-car-input-control:focus {
    border-color: var(--dn-home-primary);
    background: #ffffff;
  }

  .dev-nahian-car-booking-summary-pill {
    background: var(--dn-home-bg-light);
    border: 1px solid var(--dn-home-border);
    padding: 8px 12px;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--dn-home-muted);
  }

  /* 2. About Section */
  .dev-nahian-car-about-editorial-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 50px;
    align-items: center;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-about-editorial-grid {
      grid-template-columns: 1fr 1fr;
      gap: 60px;
    }
  }

  .dev-nahian-car-about-gallery-stage {
    position: relative;
  }

  .dev-nahian-car-about-img-hero {
    width: 100%;
    height: 380px;
    object-fit: cover;
    border-radius: 16px;
    border: 1px solid var(--dn-home-border);
    display: block;
  }

  .dev-nahian-car-about-img-inset {
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 200px;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
    border: 4px solid #ffffff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }

  .dev-nahian-car-about-badge-telemetry {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(11, 17, 32, 0.85);
    backdrop-filter: blur(8px);
    border-radius: 8px;
    padding: 8px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid rgba(255, 255, 255, 0.12);
  }

  .dev-nahian-car-about-checklist {
    list-style: none;
    padding: 0;
    margin: 20px 0 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .dev-nahian-car-about-checklist li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.92rem;
    font-weight: 600;
    color: var(--dn-home-dark);
  }

  .dev-nahian-car-about-checklist svg {
    color: var(--dn-home-gold);
    flex-shrink: 0;
  }

  /* 3. Services Grid */
  .dev-nahian-car-services-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 768px) {
    .dev-nahian-car-services-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-service-card {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: var(--dn-home-radius);
    padding: 30px 24px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
  }

  .dev-nahian-car-service-card h3 {
    font-size: 1.15rem;
    font-weight: 800;
    margin: 0 0 10px;
    color: var(--dn-home-dark);
  }

  .dev-nahian-car-service-card p {
    font-size: 0.88rem;
    line-height: 1.6;
    color: var(--dn-home-muted);
    margin: 0 0 20px;
    flex-grow: 1;
  }

  .dev-nahian-car-service-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.84rem;
    font-weight: 700;
    color: var(--dn-home-dark);
    text-decoration: none;
  }

  /* 4. Fleet Grid */
  .dev-nahian-car-fleet-grid-clean {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 640px) {
    .dev-nahian-car-fleet-grid-clean {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1024px) {
    .dev-nahian-car-fleet-grid-clean {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-box {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: var(--dn-home-radius);
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
  }

  .dev-nahian-car-thumb {
    height: 200px;
    background: #0b1120;
    overflow: hidden;
  }

  .dev-nahian-car-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .dev-nahian-car-details {
    padding: 18px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }

  .dev-nahian-car-title-row h3 {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--dn-home-dark);
    margin: 0;
  }

  .dev-nahian-car-sub {
    font-size: 0.78rem;
    color: var(--dn-home-muted);
    margin: 4px 0 14px;
  }

  .dev-nahian-car-meta-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid var(--dn-home-border);
  }

  .dev-nahian-car-rate strong {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--dn-home-dark);
  }

  /* 5. How It Works & Process */
  .dev-nahian-car-hiw-stepped-grid,
  .dev-nahian-car-process-timeline-elevated {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 768px) {
    .dev-nahian-car-hiw-stepped-grid {
      grid-template-columns: repeat(3, 1fr);
    }
    .dev-nahian-car-process-timeline-elevated {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .dev-nahian-car-hiw-step-card,
  .dev-nahian-car-process-step-node {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: var(--dn-home-radius);
    padding: 28px 22px;
  }

  .dev-nahian-car-hiw-step-card h3,
  .dev-nahian-car-process-step-node h3 {
    font-size: 1.1rem;
    font-weight: 800;
    margin: 0 0 8px;
    color: var(--dn-home-dark);
  }

  .dev-nahian-car-hiw-step-card p,
  .dev-nahian-car-process-step-node p {
    font-size: 0.86rem;
    line-height: 1.6;
    color: var(--dn-home-muted);
    margin: 0;
  }

  /* 6. CTA Banner */
  .dev-nahian-car-section-cta {
    padding: 40px 20px;
    max-width: 1240px;
    margin: 0 auto;
  }

  .dev-nahian-car-cta-box {
    background: var(--dn-home-dark);
    border-radius: 16px;
    padding: 48px 40px;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    gap: 24px;
    justify-content: space-between;
    align-items: flex-start;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-cta-box {
      flex-direction: row;
      align-items: center;
    }
  }

  .dev-nahian-car-cta-content h2 {
    font-size: clamp(1.6rem, 2.5vw, 2.2rem);
    font-weight: 800;
    margin: 0 0 10px;
    color: #ffffff;
  }

  .dev-nahian-car-cta-content p {
    font-size: 0.95rem;
    color: #94a3b8;
    margin: 0;
    line-height: 1.6;
  }

  .dev-nahian-car-btn-gold {
    background: var(--dn-home-gold);
    color: #ffffff;
    border: 1px solid var(--dn-home-gold);
  }

  /* 7. FAQ Accordion */
  .dev-nahian-car-faq-container {
    max-width: 820px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .dev-nahian-car-faq-item {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: 8px;
    overflow: hidden;
  }

  .dev-nahian-car-faq-question {
    padding: 18px 20px;
    font-size: 0.98rem;
    font-weight: 700;
    color: var(--dn-home-dark);
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    user-select: none;
  }

  .dev-nahian-car-faq-question svg {
    transition: transform 0.25s ease;
  }

  .dev-nahian-car-faq-item.is-open .dev-nahian-car-faq-question svg {
    transform: rotate(180deg);
  }

  .dev-nahian-car-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s cubic-bezier(0, 1, 0, 1);
    background: var(--dn-home-bg-light);
  }

  .dev-nahian-car-faq-answer p {
    padding: 16px 20px;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.65;
    color: var(--dn-home-muted);
    border-top: 1px solid var(--dn-home-border);
  }

  /* 8. Counters */
  .dev-nahian-car-section-counter {
    background: var(--dn-home-dark);
    color: #ffffff;
    padding: 60px 20px;
  }

  .dev-nahian-car-counter-grid {
    max-width: 1240px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    text-align: center;
  }

  @media (min-width: 768px) {
    .dev-nahian-car-counter-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .dev-nahian-car-counter-box h3 {
    font-size: clamp(2.2rem, 3.5vw, 3rem);
    font-weight: 900;
    color: #ffffff;
    margin: 0 0 6px;
  }

  .dev-nahian-car-counter-box p {
    font-size: 0.82rem;
    font-weight: 600;
    color: #94a3b8;
    margin: 0;
  }

  /* 9. Articles Grid */
  .dev-nahian-car-articles-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 768px) {
    .dev-nahian-car-articles-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-article-card {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: var(--dn-home-radius);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .dev-nahian-car-article-thumb-wrap {
    height: 190px;
  }

  .dev-nahian-car-article-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .dev-nahian-car-article-content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }

  .dev-nahian-car-article-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--dn-home-dark);
    margin: 0 0 8px;
  }

  .dev-nahian-car-article-excerpt {
    font-size: 0.85rem;
    color: var(--dn-home-muted);
    line-height: 1.55;
    margin: 0 0 16px;
    flex-grow: 1;
  }

  /* 10. Reviews Grid */
  .dev-nahian-car-testimonials-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 768px) {
    .dev-nahian-car-testimonials-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-review-card {
    background: #ffffff;
    border: 1px solid var(--dn-home-border);
    border-radius: var(--dn-home-radius);
    padding: 28px 24px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-review-stars {
    color: #eab308;
    margin-bottom: 12px;
  }
</style>

<!-- 1. HERO & DISPATCH SECTION -->
<?php if ( $show_hero ) : ?>
  <section class="dev-nahian-car-hero" id="dev-nahian-car-home">
    <div class="dev-nahian-car-hero-wrap">
      <div>
        <?php if ( ! empty( $hero_eyebrow ) ) : ?>
          <div class="dev-nahian-car-hero-eyebrow">
            <span class="dev-nahian-car-hero-eyebrow-dot"></span>
            <?php echo esc_html( $hero_eyebrow ); ?>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $hero_title ) ) : ?>
          <h1><?php echo wp_kses( $hero_title, array( 'span' => array(), 'br' => array() ) ); ?></h1>
        <?php endif; ?>

        <?php if ( ! empty( $hero_desc ) ) : ?>
          <p><?php echo esc_html( $hero_desc ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $btn1_text ) || ! empty( $btn2_text ) ) : ?>
          <div class="dev-nahian-car-hero-actions">
            <?php if ( ! empty( $btn1_text ) ) : ?>
              <a href="<?php echo esc_url( ! empty( $btn1_url ) ? $btn1_url : '#' ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-primary">
                <?php echo esc_html( $btn1_text ); ?>
              </a>
            <?php endif; ?>

            <?php if ( ! empty( $btn2_text ) ) : ?>
              <a href="<?php echo esc_url( ! empty( $btn2_url ) ? $btn2_url : '#' ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary">
                <?php echo esc_html( $btn2_text ); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $trust_score ) || ! empty( $trust_text ) ) : ?>
          <div class="dev-nahian-car-hero-trust-bar">
            <div class="dev-nahian-car-trust-text">
              <?php if ( ! empty( $trust_score ) ) : ?>
                <span>★ <?php echo esc_html( $trust_score ); ?></span>
              <?php endif; ?>
              <?php echo esc_html( $trust_text ); ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $feat_pill_1 ) || ! empty( $feat_pill_2 ) || ! empty( $feat_pill_3 ) ) : ?>
          <div class="dev-nahian-car-hero-features">
            <?php if ( ! empty( $feat_pill_1 ) ) : ?>
              <div class="dev-nahian-car-feature-point">✓ <?php echo esc_html( $feat_pill_1 ); ?></div>
            <?php endif; ?>
            <?php if ( ! empty( $feat_pill_2 ) ) : ?>
              <div class="dev-nahian-car-feature-point">✓ <?php echo esc_html( $feat_pill_2 ); ?></div>
            <?php endif; ?>
            <?php if ( ! empty( $feat_pill_3 ) ) : ?>
              <div class="dev-nahian-car-feature-point">✓ <?php echo esc_html( $feat_pill_3 ); ?></div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Hero Dispatch Form -->
      <div class="dev-nahian-car-hero-dispatch-card">
        <div class="dev-nahian-car-dispatch-header">
          <?php if ( ! empty( $disp_title ) ) : ?>
            <h3><?php echo esc_html( $disp_title ); ?></h3>
          <?php endif; ?>
          <?php if ( ! empty( $disp_sub ) ) : ?>
            <p><?php echo esc_html( $disp_sub ); ?></p>
          <?php endif; ?>
        </div>

        <form class="dev-nahian-car-dispatch-form" action="<?php echo esc_url( home_url( '/cars/' ) ); ?>" method="get">
          <div class="dev-nahian-car-form-group">
            <label for="searchPickUp"><?php esc_html_e( 'Pick Up Location', 'dev-nahian-car' ); ?></label>
            <input type="text" name="pickup_loc" class="dev-nahian-car-input-control" id="searchPickUp" value="<?php echo esc_attr( $disp_pickup ); ?>" placeholder="<?php esc_attr_e( 'City or Airport', 'dev-nahian-car' ); ?>" required>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="searchPickDown"><?php esc_html_e( 'Return Location', 'dev-nahian-car' ); ?></label>
            <input type="text" name="return_loc" class="dev-nahian-car-input-control" id="searchPickDown" value="<?php echo esc_attr( $disp_return ); ?>" placeholder="<?php esc_attr_e( 'City or Airport', 'dev-nahian-car' ); ?>" required>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="searchDateIn"><?php esc_html_e( 'Pick Up Date', 'dev-nahian-car' ); ?></label>
            <input type="date" name="pickup_date" class="dev-nahian-car-input-control" id="searchDateIn" value="<?php echo gmdate( 'Y-m-d' ); ?>" required>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="searchDateOut"><?php esc_html_e( 'Return Date', 'dev-nahian-car' ); ?></label>
            <input type="date" name="return_date" class="dev-nahian-car-input-control" id="searchDateOut" value="<?php echo gmdate( 'Y-m-d', strtotime( '+3 days' ) ); ?>" required>
          </div>

          <div class="dev-nahian-car-form-col-full">
            <div class="dev-nahian-car-booking-summary-pill">
              <span><?php esc_html_e( 'Rental Scope:', 'dev-nahian-car' ); ?></span>
              <span id="dev-nahian-car-liveScopeDays"><?php esc_html_e( '3 Days Selected', 'dev-nahian-car' ); ?></span>
            </div>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-form-col-full" style="margin-top: 4px;">
            <button type="submit" class="dev-nahian-car-btn dev-nahian-car-btn-primary" style="width: 100%; height: 48px;">
              <?php esc_html_e( 'Search Available Cars', 'dev-nahian-car' ); ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- 2. ABOUT US SECTION -->
<?php if ( $show_about && ( ! empty( $about_title ) || ! empty( $about_desc ) || ! empty( $about_img1 ) ) ) : ?>
  <section class="dev-nahian-car-section-about" id="dev-nahian-car-about">
    <div class="dev-nahian-car-about-editorial-grid">
      <div class="dev-nahian-car-about-gallery-stage">
        <?php if ( ! empty( $about_img1 ) ) : ?>
          <img class="dev-nahian-car-about-img-hero" src="<?php echo esc_url( $about_img1 ); ?>" alt="<?php echo esc_attr( $about_title ); ?>">
        <?php endif; ?>
        <?php if ( ! empty( $about_img2 ) ) : ?>
          <img class="dev-nahian-car-about-img-inset" src="<?php echo esc_url( $about_img2 ); ?>" alt="<?php echo esc_attr( $about_title ); ?>">
        <?php endif; ?>
        <?php if ( ! empty( $telem_status ) ) : ?>
          <div class="dev-nahian-car-about-badge-telemetry">
            <strong style="font-size: 13px; color: #fff;">✓ <?php echo esc_html( $telem_status ); ?></strong>
          </div>
        <?php endif; ?>
      </div>

      <div>
        <?php if ( ! empty( $about_tag ) ) : ?>
          <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $about_tag ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $about_title ) ) : ?>
          <h2><?php echo esc_html( $about_title ); ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $about_desc ) ) : ?>
          <p style="margin-top: 14px; font-size: 15px; color: var(--dn-home-muted); line-height: 1.7;">
            <?php echo esc_html( $about_desc ); ?>
          </p>
        <?php endif; ?>

        <?php if ( ! empty( $about_c1 ) || ! empty( $about_c2 ) || ! empty( $about_c3 ) ) : ?>
          <ul class="dev-nahian-car-about-checklist">
            <?php if ( ! empty( $about_c1 ) ) : ?><li>✓ <?php echo esc_html( $about_c1 ); ?></li><?php endif; ?>
            <?php if ( ! empty( $about_c2 ) ) : ?><li>✓ <?php echo esc_html( $about_c2 ); ?></li><?php endif; ?>
            <?php if ( ! empty( $about_c3 ) ) : ?><li>✓ <?php echo esc_html( $about_c3 ); ?></li><?php endif; ?>
          </ul>
        <?php endif; ?>

        <div style="margin-top: 30px;">
          <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-primary">
            <?php esc_html_e( 'Read More', 'dev-nahian-car' ); ?>
          </a>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- 3. SERVICES SECTION -->
<?php if ( $show_services && ( ! empty( $services_h2 ) || ! empty( $services_data ) ) ) : ?>
  <section class="dev-nahian-car-section-services" id="dev-nahian-car-services">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $services_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $services_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $services_h2 ) ) : ?>
        <h2><?php echo esc_html( $services_h2 ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $services_sub ) ) : ?>
        <p><?php echo esc_html( $services_sub ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-services-grid">
      <?php if ( ! empty( $services_data ) && is_array( $services_data ) ) : ?>
        <?php foreach ( array_slice( $services_data, 0, 3 ) as $srv ) : ?>
          <div class="dev-nahian-car-service-card">
            <h3><?php echo esc_html( $srv['title'] ?? '' ); ?></h3>
            <p><?php echo esc_html( $srv['desc'] ?? '' ); ?></p>
            <a href="<?php echo esc_url( ! empty( $srv['btn_url'] ) ? $srv['btn_url'] : home_url( '/services/' ) ); ?>" class="dev-nahian-car-service-link">
              <?php echo esc_html( ! empty( $srv['btn_text'] ) ? $srv['btn_text'] : __( 'Learn More', 'dev-nahian-car' ) ); ?> →
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<!-- 4. FLEET SECTION -->
<?php if ( $show_fleet ) : ?>
  <section class="dev-nahian-car-section-fleet" id="dev-nahian-car-fleets">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $fleet_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $fleet_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $fleet_h2 ) ) : ?>
        <h2><?php echo esc_html( $fleet_h2 ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $fleet_sub ) ) : ?>
        <p><?php echo esc_html( $fleet_sub ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-fleet-grid-clean">
      <?php if ( ! empty( $vehicles ) ) : ?>
        <?php foreach ( $vehicles as $car ) : 
          $c_id       = $car['id'];
          $c_name     = $car['name'];
          $c_price    = (float) ( $car['price'] ?? 0 );
          $c_img      = $car['image'] ?? '';
          $single_url = add_query_arg( array( 'car_id' => $c_id ), home_url( '/single-car/' ) );
          
          // Point the reserve button directly to the single car dossier page
          $res_url    = $single_url; 
        ?>
          <div class="dev-nahian-car-box">
            <?php if ( ! empty( $c_img ) ) : ?>
              <div class="dev-nahian-car-thumb">
                <a href="<?php echo esc_url( $single_url ); ?>">
                  <img src="<?php echo esc_url( $c_img ); ?>" alt="<?php echo esc_attr( $c_name ); ?>">
                </a>
              </div>
            <?php endif; ?>
            <div class="dev-nahian-car-details">
              <div class="dev-nahian-car-title-row">
                <h3>
                  <a href="<?php echo esc_url( $single_url ); ?>" style="color: inherit; text-decoration: none;">
                    <?php echo esc_html( $c_name ); ?>
                  </a>
                </h3>
              </div>
              <p class="dev-nahian-car-sub"><?php echo esc_html( $car['brand'] ?? '' ); ?></p>
              <div class="dev-nahian-car-meta-bottom">
                <div class="dev-nahian-car-rate">
                  <strong>$<?php echo number_format( $c_price, 0 ); ?></strong>
                </div>
                <a href="<?php echo esc_url( $res_url ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary">
                  <?php esc_html_e( 'Reserve', 'dev-nahian-car' ); ?>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<!-- 5. HOW IT WORKS -->
<?php if ( $show_hiw && ( ! empty( $hiw_s1_t ) || ! empty( $hiw_s2_t ) || ! empty( $hiw_s3_t ) ) ) : ?>
  <section class="dev-nahian-car-section-hiw" id="dev-nahian-car-how-it-works">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $hiw_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $hiw_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $hiw_title ) ) : ?>
        <h2><?php echo esc_html( $hiw_title ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $hiw_desc ) ) : ?>
        <p><?php echo esc_html( $hiw_desc ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-hiw-stepped-grid">
      <?php if ( ! empty( $hiw_s1_t ) ) : ?>
        <div class="dev-nahian-car-hiw-step-card">
          <h3><?php echo esc_html( $hiw_s1_t ); ?></h3>
          <p><?php echo esc_html( $hiw_s1_d ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $hiw_s2_t ) ) : ?>
        <div class="dev-nahian-car-hiw-step-card">
          <h3><?php echo esc_html( $hiw_s2_t ); ?></h3>
          <p><?php echo esc_html( $hiw_s2_d ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $hiw_s3_t ) ) : ?>
        <div class="dev-nahian-car-hiw-step-card">
          <h3><?php echo esc_html( $hiw_s3_t ); ?></h3>
          <p><?php echo esc_html( $hiw_s3_d ); ?></p>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<!-- 6. CALL TO ACTION BANNER -->
<?php if ( $show_cta && ( ! empty( $cta_title ) || ! empty( $cta_desc ) ) ) : ?>
  <section class="dev-nahian-car-section-cta">
    <div class="dev-nahian-car-cta-box">
      <div class="dev-nahian-car-cta-content">
        <?php if ( ! empty( $cta_title ) ) : ?>
          <h2><?php echo esc_html( $cta_title ); ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $cta_desc ) ) : ?>
          <p><?php echo esc_html( $cta_desc ); ?></p>
        <?php endif; ?>
      </div>
      <div>
        <?php if ( ! empty( $cta_btn_text ) ) : ?>
          <a href="<?php echo esc_url( ! empty( $cta_btn_url ) ? $cta_btn_url : '#' ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-gold">
            <?php echo esc_html( $cta_btn_text ); ?>
          </a>
        <?php endif; ?>
        <?php if ( ! empty( $cta_phone ) ) : ?>
          <a href="tel:<?php echo esc_attr( $clean_cta_phone ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary" style="margin-left: 8px;">
            <?php echo esc_html( $cta_phone ); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- 7. PROCESS TIMELINE -->
<?php if ( $show_proc && ( ! empty( $proc_s1_t ) || ! empty( $proc_s2_t ) || ! empty( $proc_s3_t ) || ! empty( $proc_s4_t ) ) ) : ?>
  <section class="dev-nahian-car-section-process">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $proc_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $proc_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $proc_title ) ) : ?>
        <h2><?php echo esc_html( $proc_title ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $proc_desc ) ) : ?>
        <p><?php echo esc_html( $proc_desc ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-process-timeline-elevated">
      <?php if ( ! empty( $proc_s1_t ) ) : ?>
        <div class="dev-nahian-car-process-step-node">
          <h3><?php echo esc_html( $proc_s1_t ); ?></h3>
          <p><?php echo esc_html( $proc_s1_d ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $proc_s2_t ) ) : ?>
        <div class="dev-nahian-car-process-step-node">
          <h3><?php echo esc_html( $proc_s2_t ); ?></h3>
          <p><?php echo esc_html( $proc_s2_d ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $proc_s3_t ) ) : ?>
        <div class="dev-nahian-car-process-step-node">
          <h3><?php echo esc_html( $proc_s3_t ); ?></h3>
          <p><?php echo esc_html( $proc_s3_d ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $proc_s4_t ) ) : ?>
        <div class="dev-nahian-car-process-step-node">
          <h3><?php echo esc_html( $proc_s4_t ); ?></h3>
          <p><?php echo esc_html( $proc_s4_d ); ?></p>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<!-- 8. FREQUENTLY ASKED QUESTIONS -->
<?php if ( $show_faq && ! empty( $faqs ) ) : ?>
  <section class="dev-nahian-car-section-faq">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $faq_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $faq_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $faq_title ) ) : ?>
        <h2><?php echo esc_html( $faq_title ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $faq_desc ) ) : ?>
        <p><?php echo esc_html( $faq_desc ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-faq-container">
      <?php foreach ( $faqs as $fq ) : ?>
        <?php if ( ! empty( $fq['question'] ) ) : ?>
          <div class="dev-nahian-car-faq-item">
            <div class="dev-nahian-car-faq-question" role="button" tabindex="0">
              <?php echo esc_html( $fq['question'] ); ?>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="dev-nahian-car-faq-answer">
              <p><?php echo esc_html( $fq['answer'] ?? '' ); ?></p>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<!-- 9. STAT COUNTERS -->
<?php if ( $show_counters && ( ! empty( $cnt1_val ) || ! empty( $cnt2_val ) || ! empty( $cnt3_val ) || ! empty( $cnt4_val ) ) ) : ?>
  <section class="dev-nahian-car-section-counter">
    <div class="dev-nahian-car-counter-grid">
      <?php if ( ! empty( $cnt1_val ) ) : ?>
        <div class="dev-nahian-car-counter-box">
          <h3><span class="dev-nahian-car-counter-val" data-dev-nahian-target="<?php echo esc_attr( $cnt1_val ); ?>">0</span><span><?php echo esc_html( $cnt1_suf ); ?></span></h3>
          <p><?php echo esc_html( $cnt1_lbl ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $cnt2_val ) ) : ?>
        <div class="dev-nahian-car-counter-box">
          <h3><span class="dev-nahian-car-counter-val" data-dev-nahian-target="<?php echo esc_attr( $cnt2_val ); ?>">0</span><span><?php echo esc_html( $cnt2_suf ); ?></span></h3>
          <p><?php echo esc_html( $cnt2_lbl ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $cnt3_val ) ) : ?>
        <div class="dev-nahian-car-counter-box">
          <h3><span class="dev-nahian-car-counter-val" data-dev-nahian-target="<?php echo esc_attr( $cnt3_val ); ?>">0</span><span><?php echo esc_html( $cnt3_suf ); ?></span></h3>
          <p><?php echo esc_html( $cnt3_lbl ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $cnt4_val ) ) : ?>
        <div class="dev-nahian-car-counter-box">
          <h3><span class="dev-nahian-car-counter-val" data-dev-nahian-target="<?php echo esc_attr( $cnt4_val ); ?>">0</span><span><?php echo esc_html( $cnt4_suf ); ?></span></h3>
          <p><?php echo esc_html( $cnt4_lbl ); ?></p>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<!-- 10. ARTICLES -->
<?php if ( $show_blog ) : ?>
  <section class="dev-nahian-car-section-articles">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $blog_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $blog_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $blog_title ) ) : ?>
        <h2><?php echo esc_html( $blog_title ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $blog_desc ) ) : ?>
        <p><?php echo esc_html( $blog_desc ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-articles-grid">
      <?php
      $recent_posts = get_posts( array(
          'numberposts' => 3,
          'post_status' => 'publish',
      ) );

      if ( ! empty( $recent_posts ) ) :
          foreach ( $recent_posts as $p_item ) :
              $p_thumb = get_the_post_thumbnail_url( $p_item->ID, 'medium_large' );
              ?>
              <article class="dev-nahian-car-article-card">
                <?php if ( ! empty( $p_thumb ) ) : ?>
                  <div class="dev-nahian-car-article-thumb-wrap">
                    <img src="<?php echo esc_url( $p_thumb ); ?>" alt="<?php echo esc_attr( $p_item->post_title ); ?>">
                  </div>
                <?php endif; ?>
                <div class="dev-nahian-car-article-content">
                  <h3 class="dev-nahian-car-article-title"><?php echo esc_html( $p_item->post_title ); ?></h3>
                  <p class="dev-nahian-car-article-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $p_item->ID ), 16 ) ); ?></p>
                  <a href="<?php echo esc_url( get_permalink( $p_item->ID ) ); ?>" class="dev-nahian-car-service-link">
                    <?php esc_html_e( 'Read Article', 'dev-nahian-car' ); ?> →
                  </a>
                </div>
              </article>
              <?php
          endforeach;
      endif;
      ?>
    </div>
  </section>
<?php endif; ?>

<!-- 11. TESTIMONIALS -->
<?php if ( $show_testimonials && ! empty( $testimonials ) ) : ?>
  <section class="dev-nahian-car-section-testimonials">
    <div class="dev-nahian-car-section-header">
      <?php if ( ! empty( $testi_tag ) ) : ?>
        <span class="dev-nahian-car-section-tag-lead"><?php echo esc_html( $testi_tag ); ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $testi_title ) ) : ?>
        <h2><?php echo esc_html( $testi_title ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $testi_desc ) ) : ?>
        <p><?php echo esc_html( $testi_desc ); ?></p>
      <?php endif; ?>
    </div>

    <div class="dev-nahian-car-testimonials-grid">
      <?php foreach ( $testimonials as $item ) : 
        $t_name   = $item['name'] ?? '';
        $t_role   = $item['role'] ?? '';
        $t_text   = $item['text'] ?? '';
        $t_stars  = min( 5, max( 1, absint( $item['stars'] ?? 5 ) ) );
        if ( empty( $t_name ) && empty( $t_text ) ) continue;
      ?>
        <div class="dev-nahian-car-review-card">
          <div class="dev-nahian-car-review-stars">
            <?php echo esc_html( str_repeat( '★', $t_stars ) ); ?>
          </div>
          <p style="font-size: 0.95rem; line-height: 1.6; color: var(--dn-home-dark); margin: 0 0 16px;">
            "<?php echo esc_html( $t_text ); ?>"
          </p>
          <strong><?php echo esc_html( $t_name ); ?></strong>
          <?php if ( ! empty( $t_role ) ) : ?>
            <span style="font-size: 0.78rem; color: var(--dn-home-muted); display: block;"><?php echo esc_html( $t_role ); ?></span>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<!-- Script for Accordions & Date Calculations -->
<script id="dev-nahian-homepage-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      // 1. Live Hero Journey Date Scope Calculation
      const dateIn  = document.getElementById('searchDateIn');
      const dateOut = document.getElementById('searchDateOut');
      const scopeEl = document.getElementById('dev-nahian-car-liveScopeDays');

      function calculateScope() {
        if (!dateIn || !dateOut || !scopeEl) return;
        const d1 = new Date(dateIn.value);
        const d2 = new Date(dateOut.value);

        if (d2 >= d1) {
          const diffTime = Math.abs(d2 - d1);
          const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
          scopeEl.textContent = diffDays + (diffDays === 1 ? ' Day Selected' : ' Days Selected');
        } else {
          scopeEl.textContent = 'Invalid Return Date';
        }
      }

      if (dateIn && dateOut) {
        dateIn.addEventListener('change', calculateScope);
        dateOut.addEventListener('change', calculateScope);
      }

      // 2. Counter Animation
      const counterEls = document.querySelectorAll('.dev-nahian-car-counter-val');
      if (counterEls.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function(entries, obs) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              const el = entry.target;
              const target = parseInt(el.getAttribute('data-dev-nahian-target'), 10) || 0;
              const duration = 1400;
              const stepTime = 20;
              const totalSteps = duration / stepTime;
              const increment = target / totalSteps;
              let current = 0;

              const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                  el.textContent = target;
                  clearInterval(timer);
                } else {
                  el.textContent = Math.floor(current);
                }
              }, stepTime);

              obs.unobserve(el);
            }
          });
        }, { threshold: 0.3 });

        counterEls.forEach(function(el) { observer.observe(el); });
      }

      // 3. FAQ Accordion Mechanics
      const faqItems = document.querySelectorAll('.dev-nahian-car-faq-item');
      faqItems.forEach(function(item) {
        const question = item.querySelector('.dev-nahian-car-faq-question');
        const answer   = item.querySelector('.dev-nahian-car-faq-answer');

        if (question && answer) {
          question.addEventListener('click', function() {
            const isOpen = item.classList.contains('is-open');

            faqItems.forEach(function(sib) {
              sib.classList.remove('is-open');
              const sibAnswer = sib.querySelector('.dev-nahian-car-faq-answer');
              if (sibAnswer) sibAnswer.style.maxHeight = null;
            });

            if (!isOpen) {
              item.classList.add('is-open');
              answer.style.maxHeight = answer.scrollHeight + 'px';
            }
          });
        }
      });
    });
  })();
</script>

<?php 
get_footer(); 
?>