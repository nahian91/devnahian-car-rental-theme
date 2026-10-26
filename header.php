<?php
/**
 * Core SEO & Master Header Template (WordPress)
 * 
 * Fully dynamic: Zero dummy/fallback content. Pulls configuration options
 * and WordPress core data natively with strict sanitization and encoding.
 * 
 * Supports dynamic page overrides by defining these variables before inclusion:
 * $page_title, $page_description, $page_keywords, $page_canonical, $og_image, $page_robots
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since 1.0.0
 */

// 1. Fetch Dynamic Settings from Configuration Tabs
// Tab: General
$cfg_logo_url    = get_option( 'dev_nahian_site_logo', '' );
$cfg_site_title  = get_option( 'dev_nahian_site_title', get_bloginfo( 'name' ) );
$cfg_site_desc   = get_option( 'dev_nahian_site_tagline', get_bloginfo( 'description' ) );
$cfg_favicon_url = get_option( 'dev_nahian_site_favicon', '' );

// Tab: Header
$cfg_show_topbar = (int) get_option( 'dev_nahian_header_show_topbar', 1 );

// Tab: Contact
$cfg_phone       = get_option( 'dev_nahian_contact_phone', '' );
$cfg_email       = get_option( 'dev_nahian_contact_email', '' );
$cfg_address     = get_option( 'dev_nahian_contact_address', '' );
$cfg_hours       = get_option( 'dev_nahian_contact_hours', '' );

// Clean phone string for tel: link protocols
$clean_phone = ! empty( $cfg_phone ) ? preg_replace( '/[^\d+]/', '', $cfg_phone ) : '';

// Single-line sanitized address & hours for headers
$address_inline = ! empty( $cfg_address ) ? str_replace( array( "\r\n", "\r", "\n" ), ', ', trim( $cfg_address ) ) : '';
$hours_inline   = ! empty( $cfg_hours ) ? str_replace( array( "\r\n", "\r", "\n" ), ' &bull; ', trim( $cfg_hours ) ) : '';

// Tab: Style (Typography & Palette)
$style_font_heading = get_option( 'dev_nahian_font_heading', 'inherit' );
$style_font_body    = get_option( 'dev_nahian_font_body', 'inherit' );
$style_font_size    = get_option( 'dev_nahian_font_size_base', 16 );
$style_line_height  = get_option( 'dev_nahian_font_line_height', '1.6' );
$style_primary      = get_option( 'dev_nahian_style_primary_color', '#0f172a' );
$style_accent       = get_option( 'dev_nahian_style_accent_color', '#b88e1e' );
$style_custom_css   = get_option( 'dev_nahian_style_custom_css', '' );

// 2. Domain & SEO Fallbacks
$site_name   = $cfg_site_title;
$site_domain = home_url();
$current_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . '://' . ( $_SERVER['HTTP_HOST'] ?? '' ) . ( $_SERVER['REQUEST_URI'] ?? '' );

$seo_title       = isset( $page_title ) ? htmlspecialchars( $page_title, ENT_QUOTES, 'UTF-8' ) . ' | ' . $site_name : wp_get_document_title();
$seo_description = isset( $page_description ) ? htmlspecialchars( $page_description, ENT_QUOTES, 'UTF-8' ) : $cfg_site_desc;
$seo_keywords    = isset( $page_keywords ) ? htmlspecialchars( $page_keywords, ENT_QUOTES, 'UTF-8' ) : '';
$seo_canonical   = isset( $page_canonical ) ? htmlspecialchars( $page_canonical, ENT_QUOTES, 'UTF-8' ) : htmlspecialchars( $current_url, ENT_QUOTES, 'UTF-8' );
$seo_image       = isset( $og_image ) ? htmlspecialchars( $og_image, ENT_QUOTES, 'UTF-8' ) : $cfg_logo_url;
$seo_robots      = isset( $page_robots ) ? htmlspecialchars( $page_robots, ENT_QUOTES, 'UTF-8' ) : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';

/**
 * Custom WordPress Nav Walker for Mobile & Desktop Menus
 */
if ( ! class_exists( 'Dev_Nahian_Car_Nav_Walker' ) ) {
    class Dev_Nahian_Car_Nav_Walker extends Walker_Nav_Menu {
        function start_lvl( &$output, $depth = 0, $args = null ) {
            $indent     = str_repeat( "\t", $depth );
            $class_name = ( $depth === 0 ) ? 'dev-nahian-car-dropdown-menu' : 'dev-nahian-car-mobile-submenu';
            $output    .= "\n$indent<ul class=\"$class_name\">\n";
        }

        function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $indent  = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            
            if ( $depth === 0 ) {
                $classes[] = 'dev-nahian-car-nav-item';
            } else {
                $classes[] = 'dev-nahian-car-dropdown-item';
            }

            $args        = (object) $args;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $output .= $indent . '<li' . $class_names . '>';

            $atts           = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
            $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

            $atts['class']  = ( $depth === 0 ) ? 'dev-nahian-car-nav-link' : '';

            if ( in_array( 'current-menu-item', (array) $item->classes, true ) || in_array( 'current_page_item', (array) $item->classes, true ) ) {
                $atts['class'] .= ' dev-nahian-car-active';
            }

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

            if ( in_array( 'menu-item-has-children', (array) $item->classes, true ) && $depth === 0 ) {
                $item_output .= ' <svg class="dev-nahian-car-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>';
            }

            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: https://ogp.me/ns#">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  
  <!-- SEO Directives -->
  <title><?php echo wp_kses_post( $seo_title ); ?></title>
  <?php if ( ! empty( $seo_description ) ) : ?>
    <meta name="description" content="<?php echo esc_attr( $seo_description ); ?>">
  <?php endif; ?>
  <?php if ( ! empty( $seo_keywords ) ) : ?>
    <meta name="keywords" content="<?php echo esc_attr( $seo_keywords ); ?>">
  <?php endif; ?>
  <meta name="robots" content="<?php echo esc_attr( $seo_robots ); ?>">
  <link rel="canonical" href="<?php echo esc_url( $seo_canonical ); ?>">

  <!-- Open Graph Protocol -->
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
  <meta property="og:title" content="<?php echo esc_attr( $seo_title ); ?>">
  <?php if ( ! empty( $seo_description ) ) : ?>
    <meta property="og:description" content="<?php echo esc_attr( $seo_description ); ?>">
  <?php endif; ?>
  <meta property="og:url" content="<?php echo esc_url( $seo_canonical ); ?>">
  <?php if ( ! empty( $seo_image ) ) : ?>
    <meta property="og:image" content="<?php echo esc_url( $seo_image ); ?>">
    <meta property="og:image:alt" content="<?php echo esc_attr( $site_name ); ?>">
  <?php endif; ?>

  <!-- Twitter / X Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo esc_attr( $seo_title ); ?>">
  <?php if ( ! empty( $seo_description ) ) : ?>
    <meta name="twitter:description" content="<?php echo esc_attr( $seo_description ); ?>">
  <?php endif; ?>
  <?php if ( ! empty( $seo_image ) ) : ?>
    <meta name="twitter:image" content="<?php echo esc_url( $seo_image ); ?>">
  <?php endif; ?>

  <!-- Favicons -->
  <?php if ( ! empty( $cfg_favicon_url ) ) : ?>
    <link rel="icon" href="<?php echo esc_url( $cfg_favicon_url ); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url( $cfg_favicon_url ); ?>">
  <?php endif; ?>

  <meta name="theme-color" content="<?php echo esc_attr( $style_primary ); ?>">

  <!-- Internal CSS Architecture (Zero Inline Styles) -->
  <style id="dev-nahian-internal-styles">
    :root {
      --dev-nahian-car-font-heading: <?php echo esc_attr( $style_font_heading ); ?>;
      --dev-nahian-car-font-body: <?php echo esc_attr( $style_font_body ); ?>;
      --dev-nahian-car-font-size-base: <?php echo absint( $style_font_size ); ?>px;
      --dev-nahian-car-line-height: <?php echo esc_attr( $style_line_height ); ?>;
      --dev-nahian-car-primary: <?php echo esc_attr( $style_primary ); ?>;
      --dev-nahian-car-accent: <?php echo esc_attr( $style_accent ); ?>;
      --dev-nahian-car-bg-light: #f8fafc;
      --dev-nahian-car-border: #e2e8f0;
      --dev-nahian-car-text-dark: #0f172a;
      --dev-nahian-car-radius-sm: 6px;
    }

    body {
      margin: 0;
      font-family: var(--dev-nahian-car-font-body);
      font-size: var(--dev-nahian-car-font-size-base);
      line-height: var(--dev-nahian-car-line-height);
      color: var(--dev-nahian-car-text-dark);
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: var(--dev-nahian-car-font-heading);
    }

    /* Container Utility */
    .dev-nahian-car-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      box-sizing: border-box;
    }

    /* Topbar Styles */
    .dev-nahian-car-topbar {
      background: #0b1120;
      color: #94a3b8;
      font-size: 0.8rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      padding: 8px 0;
    }
    .dev-nahian-car-topbar-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }
    .dev-nahian-car-topbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
    }
    .dev-nahian-car-topbar-item {
      color: #94a3b8;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s ease;
    }
    .dev-nahian-car-topbar-item-hours {
      color: #64748b;
    }
    .dev-nahian-car-topbar-divider {
      width: 1px;
      height: 14px;
      background: rgba(255, 255, 255, 0.15);
    }

    /* Main Navbar */
    .dev-nahian-car-navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 76px;
    }
    .dev-nahian-car-brand-link {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--dev-nahian-car-text-dark);
    }
    .dev-nahian-car-logo-img {
      max-height: 42px;
      width: auto;
      display: block;
    }
    .dev-nahian-car-logo-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 38px;
      height: 38px;
      border-radius: 8px;
      background: var(--dev-nahian-car-primary);
      color: #ffffff;
      flex-shrink: 0;
    }
    .dev-nahian-car-brand-text {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .dev-nahian-car-brand-title {
      font-size: 1.18rem;
      font-weight: 800;
      line-height: 1.2;
      color: var(--dev-nahian-car-text-dark);
      letter-spacing: -0.01em;
    }
    .dev-nahian-car-brand-tagline {
      font-size: 0.72rem;
      font-weight: 600;
      color: #64748b;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      margin-top: 2px;
    }

    /* Desktop Navigation */
    .dev-nahian-car-nav-menu {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
      gap: 24px;
      align-items: center;
    }
    .dev-nahian-car-nav-item {
      position: relative;
    }
    .dev-nahian-car-nav-link {
      text-decoration: none;
      color: #334155;
      font-weight: 500;
      font-size: 0.92rem;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: color 0.2s ease;
    }
    .dev-nahian-car-dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #ffffff;
      min-width: 200px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--dev-nahian-car-border);
      border-radius: 8px;
      padding: 8px 0;
      list-style: none;
      z-index: 100;
    }
    .dev-nahian-car-nav-item:hover .dev-nahian-car-dropdown-menu {
      display: block;
    }
    .dev-nahian-car-dropdown-item a {
      display: block;
      padding: 8px 16px;
      color: #334155;
      text-decoration: none;
      font-size: 0.88rem;
    }
    .dev-nahian-car-dropdown-item a:hover {
      background: var(--dev-nahian-car-bg-light);
      color: var(--dev-nahian-car-accent);
    }

    /* Buttons & Actions */
    .dev-nahian-car-nav-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .dev-nahian-car-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 9px 18px;
      border-radius: var(--dev-nahian-car-radius-sm);
      text-decoration: none;
      font-size: 0.88rem;
      font-weight: 600;
      transition: all 0.2s ease;
      box-sizing: border-box;
      border: 1px solid transparent;
    }
    .dev-nahian-car-btn-primary {
      background-color: var(--dev-nahian-car-primary);
      border-color: var(--dev-nahian-car-primary);
      color: #ffffff !important;
    }
    .dev-nahian-car-btn-secondary {
      background-color: var(--dev-nahian-car-bg-light);
      border-color: var(--dev-nahian-car-border);
      color: var(--dev-nahian-car-text-dark);
    }
    .dev-nahian-car-btn-secondary:hover {
      background-color: #e2e8f0;
    }

    /* Mobile Drawer */
    .dev-nahian-car-hamburger-btn {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 4px;
    }
    .dev-nahian-car-hamburger-btn span {
      width: 22px;
      height: 2px;
      background: var(--dev-nahian-car-text-dark);
      border-radius: 2px;
      transition: 0.3s;
    }
    .dev-nahian-car-mobile-drawer-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(15, 23, 42, 0.45);
      z-index: 999888;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .dev-nahian-car-mobile-drawer-overlay.is-active {
      opacity: 1;
      visibility: visible;
    }
    .dev-nahian-car-mobile-drawer {
      position: fixed;
      top: 0;
      right: 0;
      width: 320px;
      max-width: 85vw;
      height: 100vh;
      background: #ffffff;
      box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
      z-index: 999999;
      transform: translateX(100%);
      transition: transform 0.3s ease;
      overflow-y: auto;
      padding: 24px 20px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .dev-nahian-car-mobile-drawer.is-active {
      transform: translateX(0);
    }
    .dev-nahian-car-mobile-drawer-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--dev-nahian-car-border);
      padding-bottom: 16px;
    }
    .dev-nahian-car-mobile-nav-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .dev-nahian-car-mobile-nav-list a {
      text-decoration: none;
      color: var(--dev-nahian-car-text-dark);
      font-weight: 500;
      font-size: 0.95rem;
    }
    .dev-nahian-car-mobile-submenu {
      list-style: none;
      padding-left: 14px;
      margin-top: 8px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .dev-nahian-contact-card {
      background: var(--dev-nahian-car-bg-light);
      border: 1px solid var(--dev-nahian-car-border);
      border-radius: 8px;
      padding: 14px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      font-size: 0.82rem;
    }
    .dev-nahian-contact-card-title {
      font-size: 0.72rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: #64748b;
      margin-bottom: 2px;
    }
    .dev-nahian-contact-card a,
    .dev-nahian-contact-card span {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #334155;
      text-decoration: none;
      word-break: break-word;
    }
    .dev-nahian-car-mobile-drawer-actions {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-top: auto;
    }
    .dev-nahian-car-user-pill {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      background: var(--dev-nahian-car-bg-light);
      border: 1px solid var(--dev-nahian-car-border);
      border-radius: var(--dev-nahian-car-radius-sm);
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 8px;
    }
    .dev-nahian-car-user-name {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--dev-nahian-car-text-dark);
    }
    .dev-nahian-car-btn-drawer-account {
      padding: 6px 12px;
      font-size: 0.78rem;
    }
    .dev-nahian-car-btn-full {
      width: 100%;
    }

    /* State & Interactive Hover Targets */
    .dev-nahian-car-topbar-item:hover,
    .dev-nahian-car-nav-link:hover,
    .dev-nahian-car-nav-link.dev-nahian-car-active,
    .dev-nahian-contact-card a:hover {
      color: var(--dev-nahian-car-accent) !important;
    }

    /* Responsive Breakpoints */
    @media (max-width: 991px) {
      .dev-nahian-car-hide-mobile,
      nav[aria-label="Primary Navigation"] {
        display: none !important;
      }
      .dev-nahian-car-hamburger-btn {
        display: flex !important;
      }
    }

    <?php if ( ! empty( $style_custom_css ) ) : ?>
      /* Custom Dashboard Overrides */
      <?php echo wp_strip_all_tags( $style_custom_css ); ?>
    <?php endif; ?>
  </style>

  <?php wp_head(); ?>

  <?php if ( ! empty( $cfg_phone ) && ! empty( $address_inline ) ) : ?>
  <!-- JSON-LD AutoRental Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "AutoRental",
    "name": <?php echo wp_json_encode( $site_name ); ?>,
    "url": <?php echo wp_json_encode( $site_domain ); ?>,
    <?php if ( ! empty( $cfg_logo_url ) ) : ?>
    "logo": <?php echo wp_json_encode( $cfg_logo_url ); ?>,
    <?php endif; ?>
    <?php if ( ! empty( $seo_image ) ) : ?>
    "image": <?php echo wp_json_encode( $seo_image ); ?>,
    <?php endif; ?>
    <?php if ( ! empty( $seo_description ) ) : ?>
    "description": <?php echo wp_json_encode( $seo_description ); ?>,
    <?php endif; ?>
    "telephone": <?php echo wp_json_encode( $cfg_phone ); ?>,
    <?php if ( ! empty( $cfg_email ) ) : ?>
    "email": <?php echo wp_json_encode( $cfg_email ); ?>,
    <?php endif; ?>
    "priceRange": "$$$$",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": <?php echo wp_json_encode( $address_inline ); ?>
    }
  }
  </script>
  <?php endif; ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- =========================================================
        1. TOP UTILITY STRIP
  ========================================================= -->
  <?php if ( $cfg_show_topbar === 1 && ( ! empty( $cfg_phone ) || ! empty( $cfg_email ) || ! empty( $hours_inline ) || ! empty( $address_inline ) ) ) : ?>
  <div class="dev-nahian-car-topbar">
    <div class="dev-nahian-car-container dev-nahian-car-topbar-inner">
      <div class="dev-nahian-car-topbar-left">
        
        <!-- Phone -->
        <?php if ( ! empty( $cfg_phone ) ) : ?>
          <a href="tel:<?php echo esc_attr( $clean_phone ); ?>" class="dev-nahian-car-topbar-item" aria-label="<?php esc_attr_e( 'Phone Concierge', 'dev-nahian-car' ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <?php echo esc_html( $cfg_phone ); ?>
          </a>
        <?php endif; ?>

        <?php if ( ! empty( $cfg_phone ) && ! empty( $cfg_email ) ) : ?>
          <div class="dev-nahian-car-topbar-divider"></div>
        <?php endif; ?>

        <!-- Email -->
        <?php if ( ! empty( $cfg_email ) ) : ?>
          <a href="mailto:<?php echo esc_attr( $cfg_email ); ?>" class="dev-nahian-car-topbar-item" aria-label="<?php esc_attr_e( 'Email Concierge', 'dev-nahian-car' ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <?php echo esc_html( $cfg_email ); ?>
          </a>
        <?php endif; ?>

        <!-- Operating Hours Badge -->
        <?php if ( ! empty( $hours_inline ) ) : ?>
          <?php if ( ! empty( $cfg_phone ) || ! empty( $cfg_email ) ) : ?>
            <div class="dev-nahian-car-topbar-divider dev-nahian-car-hide-mobile"></div>
          <?php endif; ?>
          <span class="dev-nahian-car-topbar-item dev-nahian-car-topbar-item-hours dev-nahian-car-hide-mobile">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <?php echo esc_html( $hours_inline ); ?>
          </span>
        <?php endif; ?>

      </div>

      <!-- Address Coordinates -->
      <div class="dev-nahian-car-topbar-right">
        <?php if ( ! empty( $address_inline ) ) : ?>
          <span class="dev-nahian-car-topbar-item dev-nahian-car-hide-mobile">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <?php echo esc_html( $address_inline ); ?>
          </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- =========================================================
        2. PRIMARY NAVBAR (DESKTOP)
  ========================================================= -->
  <header>
    <div class="dev-nahian-car-container dev-nahian-car-navbar">
      
      <!-- Brand Lockup: Logo (or Fallback Icon Badge) + Title & Tagline -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dev-nahian-car-brand-link" title="<?php echo esc_attr( $site_name ); ?>">
        <?php if ( ! empty( $cfg_logo_url ) ) : ?>
          <img src="<?php echo esc_url( $cfg_logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" class="dev-nahian-car-logo-img">
        <?php else : ?>
          <span class="dev-nahian-car-logo-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
          </span>
        <?php endif; ?>

        <div class="dev-nahian-car-brand-text">
          <span class="dev-nahian-car-brand-title"><?php echo esc_html( $site_name ); ?></span>
          <?php if ( ! empty( $cfg_site_desc ) ) : ?>
            <span class="dev-nahian-car-brand-tagline"><?php echo esc_html( $cfg_site_desc ); ?></span>
          <?php endif; ?>
        </div>
      </a>

      <!-- Primary Desktop Menu -->
      <nav aria-label="<?php esc_attr_e( 'Primary Navigation', 'dev-nahian-car' ); ?>">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'dev-nahian-car-nav-menu',
            'fallback_cb'    => false,
            'depth'          => 2,
            'walker'         => new Dev_Nahian_Car_Nav_Walker(),
        ) );
        ?>
      </nav>

      <!-- Nav Action Items -->
      <div class="dev-nahian-car-nav-actions">
        <?php if ( is_user_logged_in() ) : ?>
          <a href="<?php echo esc_url( home_url( '/account/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <?php esc_html_e( 'Dashboard', 'dev-nahian-car' ); ?>
          </a>
        <?php else : ?>
          <a href="<?php echo esc_url( home_url( '/account/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
            <?php esc_html_e( 'Sign In', 'dev-nahian-car' ); ?>
          </a>
        <?php endif; ?>

        <!-- Mobile Hamburger Button -->
        <button class="dev-nahian-car-hamburger-btn" id="dev-nahian-car-mobileMenuBtn" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'dev-nahian-car' ); ?>" aria-expanded="false" type="button">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- =========================================================
        3. OFFCANVAS DRAWER (MOBILE)
  ========================================================= -->
  <div class="dev-nahian-car-mobile-drawer-overlay" id="dev-nahian-car-drawerOverlay"></div>

  <aside class="dev-nahian-car-mobile-drawer" id="dev-nahian-car-mobileDrawer" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'dev-nahian-car' ); ?>">
    <div class="dev-nahian-car-mobile-drawer-header">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dev-nahian-car-brand-link" title="<?php echo esc_attr( $site_name ); ?>">
        <?php if ( ! empty( $cfg_logo_url ) ) : ?>
          <img src="<?php echo esc_url( $cfg_logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" class="dev-nahian-car-logo-img">
        <?php else : ?>
          <span class="dev-nahian-car-logo-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
          </span>
        <?php endif; ?>

        <div class="dev-nahian-car-brand-text">
          <span class="dev-nahian-car-brand-title"><?php echo esc_html( $site_name ); ?></span>
          <?php if ( ! empty( $cfg_site_desc ) ) : ?>
            <span class="dev-nahian-car-brand-tagline"><?php echo esc_html( $cfg_site_desc ); ?></span>
          <?php endif; ?>
        </div>
      </a>
    </div>

    <!-- Dynamic Mobile Menu -->
    <?php
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'dev-nahian-car-mobile-nav-list',
        'fallback_cb'    => false,
        'depth'          => 2,
        'walker'         => new Dev_Nahian_Car_Nav_Walker(),
    ) );
    ?>

    <!-- Dedicated Mobile Drawer Contact Info Widget (Rendered only if contact data exists) -->
    <?php if ( ! empty( $cfg_phone ) || ! empty( $cfg_email ) || ! empty( $address_inline ) || ! empty( $hours_inline ) ) : ?>
    <div class="dev-nahian-contact-card">
      <div class="dev-nahian-contact-card-title"><?php esc_html_e( 'Concierge & Dispatch', 'dev-nahian-car' ); ?></div>
      
      <?php if ( ! empty( $cfg_phone ) ) : ?>
        <a href="tel:<?php echo esc_attr( $clean_phone ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          <?php echo esc_html( $cfg_phone ); ?>
        </a>
      <?php endif; ?>

      <?php if ( ! empty( $cfg_email ) ) : ?>
        <a href="mailto:<?php echo esc_attr( $cfg_email ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?php echo esc_html( $cfg_email ); ?>
        </a>
      <?php endif; ?>

      <?php if ( ! empty( $address_inline ) ) : ?>
        <span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          <?php echo esc_html( $address_inline ); ?>
        </span>
      <?php endif; ?>

      <?php if ( ! empty( $hours_inline ) ) : ?>
        <span class="dev-nahian-car-topbar-item-hours">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          <?php echo esc_html( $hours_inline ); ?>
        </span>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Drawer Account & Booking Actions -->
    <div class="dev-nahian-car-mobile-drawer-actions">
      <?php if ( is_user_logged_in() ) : 
          $current_user = wp_get_current_user();
          $username     = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
      ?>
          <div class="dev-nahian-car-user-pill">
              <span class="dev-nahian-car-user-name">
                  <?php echo esc_html( $username ); ?>
              </span>
              <a href="<?php echo esc_url( home_url( '/account/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary dev-nahian-car-btn-drawer-account dev-nahian-car-close-drawer"><?php esc_html_e( 'Account', 'dev-nahian-car' ); ?></a>
          </div>
          <a href="<?php echo esc_url( home_url( '/cart/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary dev-nahian-car-btn-full dev-nahian-car-close-drawer"><?php esc_html_e( 'View Cart', 'dev-nahian-car' ); ?></a>
          <a href="<?php echo esc_url( home_url( '/cars/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-primary dev-nahian-car-btn-full dev-nahian-car-close-drawer"><?php esc_html_e( 'Reserve Fleet', 'dev-nahian-car' ); ?></a>
      <?php else : ?>
          <a href="<?php echo esc_url( home_url( '/account/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-primary dev-nahian-car-btn-full dev-nahian-car-close-drawer"><?php esc_html_e( 'Sign In', 'dev-nahian-car' ); ?></a>
          <a href="<?php echo esc_url( home_url( '/cart/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary dev-nahian-car-btn-full dev-nahian-car-close-drawer"><?php esc_html_e( 'View Cart', 'dev-nahian-car' ); ?></a>
          <a href="<?php echo esc_url( home_url( '/cars/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary dev-nahian-car-btn-full dev-nahian-car-close-drawer"><?php esc_html_e( 'Reserve Fleet', 'dev-nahian-car' ); ?></a>
      <?php endif; ?>
    </div>
  </aside>

  <!-- Internal JavaScript Architecture -->
  <script id="dev-nahian-internal-js">
    (function() {
      'use strict';

      // Use Event Delegation on the document body for 100% reliable triggering
      document.addEventListener('click', function(e) {
        const menuBtn = e.target.closest('#dev-nahian-car-mobileMenuBtn');
        const overlay = e.target.closest('#dev-nahian-car-drawerOverlay');
        const closeLink = e.target.closest('.dev-nahian-car-close-drawer');
        const drawer = document.getElementById('dev-nahian-car-mobileDrawer');

        if (!drawer) return;

        // 1. Toggle Hamburger Button
        if (menuBtn) {
          e.preventDefault();
          e.stopPropagation();
          const isOpen = drawer.classList.toggle('is-active');
          if (overlay) overlay.classList.toggle('is-active', isOpen);
          menuBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
          document.body.style.overflow = isOpen ? 'hidden' : '';
          return;
        }

        // 2. Close via Overlay Click
        if (overlay && drawer.classList.contains('is-active')) {
          drawer.classList.remove('is-active');
          overlay.classList.remove('is-active');
          const btn = document.getElementById('dev-nahian-car-mobileMenuBtn');
          if (btn) btn.setAttribute('aria-expanded', 'false');
          document.body.style.overflow = '';
          return;
        }

        // 3. Close via Drawer Link Click
        if (closeLink && drawer.classList.contains('is-active')) {
          drawer.classList.remove('is-active');
          if (overlay) overlay.classList.remove('is-active');
          const btn = document.getElementById('dev-nahian-car-mobileMenuBtn');
          if (btn) btn.setAttribute('aria-expanded', 'false');
          document.body.style.overflow = '';
        }
      });

      // Close on ESC key press
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          const drawer = document.getElementById('dev-nahian-car-mobileDrawer');
          const overlay = document.getElementById('dev-nahian-car-drawerOverlay');
          const menuBtn = document.getElementById('dev-nahian-car-mobileMenuBtn');

          if (drawer && drawer.classList.contains('is-active')) {
            drawer.classList.remove('is-active');
            if (overlay) overlay.classList.remove('is-active');
            if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
          }
        }
      });
    })();
  </script>