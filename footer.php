<?php
/**
 * Core Master Footer Template (WordPress)
 *
 * Dynamically populated from Dev Nahian Website Settings with ZERO default menus.
 * Only renders assigned menus from Appearance -> Menus:
 * - footer-1 (Column 2)
 * - footer-2 (Column 3)
 * - footer-3 (Legal Bottom Strip)
 * - Column 4: Powered by the dynamic Contact Repeater with legacy fallback
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

// 1. Fetch Dynamic Settings
// General Tab
$cfg_site_title   = get_option( 'dev_nahian_site_title', get_bloginfo( 'name' ) );
$cfg_site_tagline = get_option( 'dev_nahian_site_tagline', get_bloginfo( 'description' ) );
$cfg_header_logo  = get_option( 'dev_nahian_site_logo', '' );

// Footer Tab
$cfg_footer_logo   = get_option( 'dev_nahian_footer_logo', '' );
$cfg_footer_desc   = get_option( 'dev_nahian_footer_short_desc', '' );
$cfg_footer_col2   = get_option( 'dev_nahian_footer_col2_title', '' );
$cfg_footer_col3   = get_option( 'dev_nahian_footer_col3_title', '' );
$cfg_footer_col4   = get_option( 'dev_nahian_footer_col4_title', '' );
$cfg_copyright     = get_option( 'dev_nahian_footer_copyright', sprintf( '&copy; %s %s. All rights reserved.', gmdate( 'Y' ), esc_html( $cfg_site_title ) ) );
$cfg_contact_items = get_option( 'dev_nahian_footer_contact_items', array() );

// Social Media URLs
$social_fb        = get_option( 'dev_nahian_social_fb', '' );
$social_twitter   = get_option( 'dev_nahian_social_twitter', '' );
$social_instagram = get_option( 'dev_nahian_social_instagram', '' );
$social_tiktok    = get_option( 'dev_nahian_social_tiktok', '' );
$social_linkedin  = get_option( 'dev_nahian_social_linkedin', '' );
$social_youtube   = get_option( 'dev_nahian_social_youtube', '' );

// Legacy Contact Fallbacks
$cfg_phone      = get_option( 'dev_nahian_contact_phone', '' );
$cfg_email      = get_option( 'dev_nahian_contact_email', '' );
$cfg_address    = get_option( 'dev_nahian_contact_address', '' );
$cfg_hours      = get_option( 'dev_nahian_contact_hours', '' );
$clean_phone    = preg_replace( '/[^\d+]/', '', $cfg_phone );
$address_inline = ! empty( $cfg_address ) ? str_replace( array( "\r\n", "\r", "\n" ), ', ', trim( $cfg_address ) ) : '';
$hours_inline   = ! empty( $cfg_hours ) ? str_replace( array( "\r\n", "\r", "\n" ), ' &bull; ', trim( $cfg_hours ) ) : '';

// Logo selection: prioritize Footer Logo, then Header Logo
$display_logo_url = ! empty( $cfg_footer_logo ) ? $cfg_footer_logo : $cfg_header_logo;
?>

  <!-- Internal Footer CSS Architecture -->
  <style id="dev-nahian-footer-styles">
    footer[itemscope][itemtype*="WPFooter"] {
      background-color: #0b1120;
      color: #94a3b8;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding-top: 60px;
      font-size: 0.9rem;
      line-height: 1.6;
    }

    .dev-nahian-car-footer-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr 1fr 1.3fr;
      gap: 40px;
      padding-bottom: 50px;
    }

    .dev-nahian-car-footer-logo {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.25rem;
      color: #ffffff;
      margin-bottom: 16px;
    }

    .dev-nahian-car-footer-logo-img {
      max-height: 38px;
      width: auto;
      display: block;
      margin-bottom: 12px;
    }

    .dev-nahian-car-footer-logo-badge {
      width: 32px;
      height: 32px;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .dev-nahian-car-footer-desc {
      font-size: 0.88rem;
      color: #94a3b8;
      margin-bottom: 20px;
      line-height: 1.65;
    }

    .dev-nahian-car-footer-desc-contact {
      margin-bottom: 14px;
    }

    .dev-nahian-car-social-links {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .dev-nahian-car-social-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border-radius: 6px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #cbd5e1;
      text-decoration: none;
      transition: all 0.25s ease;
    }

    .dev-nahian-car-social-btn:hover {
      background: var(--dev-nahian-car-accent, #b88e1e);
      border-color: var(--dev-nahian-car-accent, #b88e1e);
      color: #ffffff;
      transform: translateY(-2px);
    }

    .dev-nahian-car-footer-col h4 {
      color: #ffffff;
      font-size: 1rem;
      font-weight: 700;
      margin-top: 0;
      margin-bottom: 20px;
      letter-spacing: 0.02em;
      position: relative;
    }

    .dev-nahian-car-footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .dev-nahian-car-footer-links li {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .dev-nahian-car-footer-links a {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.88rem;
      transition: color 0.2s ease, transform 0.2s ease;
    }

    .dev-nahian-car-footer-links a:hover {
      color: var(--dev-nahian-car-accent, #b88e1e);
      transform: translateX(3px);
    }

    .dev-nahian-car-footer-contact-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    .dev-nahian-car-footer-contact-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 0.88rem;
      color: #94a3b8;
    }

    .dev-nahian-car-footer-contact-item svg {
      flex-shrink: 0;
      margin-top: 3px;
      color: var(--dev-nahian-car-accent, #b88e1e);
    }

    .dev-nahian-car-footer-contact-item a {
      color: #94a3b8;
      text-decoration: none;
      transition: color 0.2s ease;
      word-break: break-word;
    }

    .dev-nahian-car-footer-contact-item a:hover {
      color: #ffffff;
    }

    /* Sub-footer Strip */
    .dev-nahian-car-footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      background: rgba(0, 0, 0, 0.2);
      padding: 20px 0;
      font-size: 0.82rem;
      color: #64748b;
    }

    .dev-nahian-car-footer-bottom .dev-nahian-car-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .dev-nahian-car-footer-legal-links {
      display: flex;
      align-items: center;
      gap: 18px;
      flex-wrap: wrap;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .dev-nahian-car-footer-legal-links li {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .dev-nahian-car-footer-legal-links a {
      color: #64748b;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .dev-nahian-car-footer-legal-links a:hover {
      color: #cbd5e1;
    }

    /* Responsive Grid */
    @media (max-width: 991px) {
      .dev-nahian-car-footer-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
      }
    }

    @media (max-width: 575px) {
      .dev-nahian-car-footer-grid {
        grid-template-columns: 1fr;
      }
      .dev-nahian-car-footer-bottom .dev-nahian-car-container {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>

  <!-- =========================================================
        FOOTER SECTION
  ========================================================= -->
  <footer itemscope itemtype="https://schema.org/WPFooter">
    <div class="dev-nahian-car-container dev-nahian-car-footer-grid">

      <!-- Column 1: Brand & Social Profiles -->
      <div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dev-nahian-car-footer-logo" title="<?php echo esc_attr( $cfg_site_title ); ?>">
          <?php if ( ! empty( $display_logo_url ) ) : ?>
            <img src="<?php echo esc_url( $display_logo_url ); ?>" alt="<?php echo esc_attr( $cfg_site_title ); ?>" class="dev-nahian-car-footer-logo-img">
          <?php else : ?>
            <span class="dev-nahian-car-logo-badge dev-nahian-car-footer-logo-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </span>
            <?php echo esc_html( $cfg_site_title ); ?>
          <?php endif; ?>
        </a>

        <?php if ( ! empty( $cfg_footer_desc ) ) : ?>
          <p class="dev-nahian-car-footer-desc">
            <?php echo esc_html( $cfg_footer_desc ); ?>
          </p>
        <?php endif; ?>

        <!-- Social Icons -->
        <?php if ( ! empty( $social_fb ) || ! empty( $social_twitter ) || ! empty( $social_instagram ) || ! empty( $social_tiktok ) || ! empty( $social_linkedin ) || ! empty( $social_youtube ) ) : ?>
          <div class="dev-nahian-car-social-links">
            <?php if ( ! empty( $social_fb ) ) : ?>
              <a href="<?php echo esc_url( $social_fb ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-social-btn" aria-label="<?php esc_attr_e( 'Facebook', 'dev-nahian-car' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
              </a>
            <?php endif; ?>

            <?php if ( ! empty( $social_twitter ) ) : ?>
              <a href="<?php echo esc_url( $social_twitter ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-social-btn" aria-label="<?php esc_attr_e( 'Twitter / X', 'dev-nahian-car' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
              </a>
            <?php endif; ?>

            <?php if ( ! empty( $social_instagram ) ) : ?>
              <a href="<?php echo esc_url( $social_instagram ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-social-btn" aria-label="<?php esc_attr_e( 'Instagram', 'dev-nahian-car' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
              </a>
            <?php endif; ?>

            <?php if ( ! empty( $social_tiktok ) ) : ?>
              <a href="<?php echo esc_url( $social_tiktok ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-social-btn" aria-label="<?php esc_attr_e( 'TikTok', 'dev-nahian-car' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
              </a>
            <?php endif; ?>

            <?php if ( ! empty( $social_linkedin ) ) : ?>
              <a href="<?php echo esc_url( $social_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-social-btn" aria-label="<?php esc_attr_e( 'LinkedIn', 'dev-nahian-car' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
              </a>
            <?php endif; ?>

            <?php if ( ! empty( $social_youtube ) ) : ?>
              <a href="<?php echo esc_url( $social_youtube ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-social-btn" aria-label="<?php esc_attr_e( 'YouTube', 'dev-nahian-car' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Column 2: Footer 1 Menu -->
      <div class="dev-nahian-car-footer-col">
        <?php if ( has_nav_menu( 'footer-1' ) ) : ?>
          <?php if ( ! empty( $cfg_footer_col2 ) ) : ?>
            <h4><?php echo esc_html( $cfg_footer_col2 ); ?></h4>
          <?php endif; ?>
          <?php
          wp_nav_menu( array(
            'theme_location' => 'footer-1',
            'container'      => false,
            'menu_class'     => 'dev-nahian-car-footer-links',
            'fallback_cb'    => false,
            'depth'          => 1,
          ) );
          ?>
        <?php endif; ?>
      </div>

      <!-- Column 3: Footer 2 Menu -->
      <div class="dev-nahian-car-footer-col">
        <?php if ( has_nav_menu( 'footer-2' ) ) : ?>
          <?php if ( ! empty( $cfg_footer_col3 ) ) : ?>
            <h4><?php echo esc_html( $cfg_footer_col3 ); ?></h4>
          <?php endif; ?>
          <?php
          wp_nav_menu( array(
            'theme_location' => 'footer-2',
            'container'      => false,
            'menu_class'     => 'dev-nahian-car-footer-links',
            'fallback_cb'    => false,
            'depth'          => 1,
          ) );
          ?>
        <?php endif; ?>
      </div>

      <!-- Column 4: Contact & Concierge Information (Dynamic Repeater with Legacy Fallback) -->
      <div class="dev-nahian-car-footer-col" itemscope itemtype="https://schema.org/PostalAddress">
        <?php if ( ! empty( $cfg_footer_col4 ) ) : ?>
          <h4><?php echo esc_html( $cfg_footer_col4 ); ?></h4>
        <?php endif; ?>

        <ul class="dev-nahian-car-footer-contact-list">
          <?php 
          // 1. Prioritize Contact Repeater Rows if configured
          if ( ! empty( $cfg_contact_items ) && is_array( $cfg_contact_items ) ) :
            foreach ( $cfg_contact_items as $c_row ) :
              $c_type = sanitize_key( $c_row['type'] ?? 'custom' );
              $c_text = sanitize_text_field( $c_row['text'] ?? '' );
              $c_link = sanitize_text_field( $c_row['link'] ?? '' );

              if ( empty( $c_text ) ) {
                continue;
              }
          ?>
              <li class="dev-nahian-car-footer-contact-item">
                <?php if ( 'address' === $c_type ) : ?>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <?php elseif ( 'phone' === $c_type ) : ?>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <?php elseif ( 'email' === $c_type ) : ?>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <?php elseif ( 'hours' === $c_type ) : ?>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <?php else : ?>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle></svg>
                <?php endif; ?>

                <?php if ( ! empty( $c_link ) ) : ?>
                  <a href="<?php echo esc_url( $c_link ); ?>">
                    <span <?php echo ( 'address' === $c_type ) ? 'itemprop="streetAddress"' : ''; ?>><?php echo esc_html( $c_text ); ?></span>
                  </a>
                <?php else : ?>
                  <span <?php echo ( 'address' === $c_type ) ? 'itemprop="streetAddress"' : ''; ?>><?php echo esc_html( $c_text ); ?></span>
                <?php endif; ?>
              </li>
          <?php 
            endforeach;
          
          // 2. Legacy Individual Fields Fallback (if repeater is empty)
          else : 
          ?>
            <?php if ( ! empty( $address_inline ) ) : ?>
              <li class="dev-nahian-car-footer-contact-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span itemprop="streetAddress"><?php echo esc_html( $address_inline ); ?></span>
              </li>
            <?php endif; ?>

            <?php if ( ! empty( $cfg_phone ) ) : ?>
              <li class="dev-nahian-car-footer-contact-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <a href="tel:<?php echo esc_attr( $clean_phone ); ?>" itemprop="telephone"><?php echo esc_html( $cfg_phone ); ?></a>
              </li>
            <?php endif; ?>

            <?php if ( ! empty( $cfg_email ) ) : ?>
              <li class="dev-nahian-car-footer-contact-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <a href="mailto:<?php echo esc_attr( $cfg_email ); ?>" itemprop="email"><?php echo esc_html( $cfg_email ); ?></a>
              </li>
            <?php endif; ?>

            <?php if ( ! empty( $hours_inline ) ) : ?>
              <li class="dev-nahian-car-footer-contact-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span><?php echo esc_html( $hours_inline ); ?></span>
              </li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>
      </div>

    </div>

    <!-- Bottom Copyright & Footer 3 (Legal Menu) Strip -->
    <div class="dev-nahian-car-footer-bottom">
      <div class="dev-nahian-car-container">
        <div><?php echo wp_kses_post( $cfg_copyright ); ?></div>

        <?php if ( has_nav_menu( 'footer-3' ) ) : ?>
          <nav class="dev-nahian-car-footer-legal-nav" aria-label="<?php esc_attr_e( 'Legal Navigation', 'dev-nahian-car' ); ?>">
            <?php
            wp_nav_menu( array(
              'theme_location' => 'footer-3',
              'container'      => false,
              'menu_class'     => 'dev-nahian-car-footer-legal-links',
              'fallback_cb'    => false,
              'depth'          => 1,
            ) );
            ?>
          </nav>
        <?php endif; ?>
      </div>
    </div>
  </footer>

  <!-- Internal Footer JavaScript Architecture -->
  <script id="dev-nahian-footer-js">
    (function() {
      'use strict';

      document.addEventListener('DOMContentLoaded', function() {
        const localHashLinks = document.querySelectorAll('a[href*="#dev-nahian-car-"]');
        localHashLinks.forEach(function(anchor) {
          anchor.addEventListener('click', function(e) {
            const url = new URL(this.href, window.location.origin);
            if (url.pathname === window.location.pathname && url.hash) {
              const targetElement = document.querySelector(url.hash);
              if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.pushState(null, '', url.hash);
              }
            }
          });
        });
      });
    })();
  </script>

  <!-- WordPress Footer Hook -->
  <?php wp_footer(); ?>
</body>
</html>