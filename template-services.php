<?php
/**
 * Template Name: Services
 * Description: Dynamic services overview template pulling directly from Services Tab settings with zero default data.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since 1.0.0
 */

get_header(); 

// 1. Fetch Dynamic Options from Services Sub-Tab (Zero hardcoded text fallbacks)
$badge    = get_option( 'dev_nahian_services_badge', '' );
$title    = get_option( 'dev_nahian_services_title', '' );
$desc     = get_option( 'dev_nahian_services_desc', '' );
$services = get_option( 'dev_nahian_services_items_data', array() );
?>

<style id="dev-nahian-services-styles">
  :root {
    --dn-srv-primary: var(--dev-nahian-car-primary, #111827);
    --dn-srv-primary-hover: var(--dev-nahian-car-primary-hover, #1f2937);
    --dn-srv-gold: var(--dev-nahian-car-gold, #b88e1e);
    --dn-srv-gold-glow: rgba(184, 142, 30, 0.12);
    --dn-srv-gold-border: rgba(184, 142, 30, 0.3);
    --dn-srv-text-dark: var(--dev-nahian-car-text-dark, #0f172a);
    --dn-srv-text-muted: var(--dev-nahian-car-text-muted, #64748b);
    --dn-srv-border: var(--dev-nahian-car-border, #e2e8f0);
    --dn-srv-radius-lg: var(--dev-nahian-car-radius, 16px);
  }

  .dev-nahian-car-services-page {
    padding: 64px 20px 88px;
    max-width: 1200px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--dn-srv-text-dark);
  }

  /* Header */
  .dev-nahian-car-services-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 64px;
  }

  .dev-nahian-car-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--dn-srv-gold);
    background: var(--dn-srv-gold-glow);
    border: 1px solid var(--dn-srv-gold-border);
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 16px;
  }

  .dev-nahian-car-services-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dn-srv-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin: 0 0 14px;
  }

  .dev-nahian-car-services-header h1 span {
    color: var(--dn-srv-gold);
  }

  .dev-nahian-car-services-header p {
    color: var(--dn-srv-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
  }

  /* Button */
  .dev-nahian-car-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    font-size: 0.92rem;
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    background: var(--dn-srv-primary);
    color: #ffffff;
    border: 1px solid transparent;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-btn-primary:hover {
    background: var(--dn-srv-primary-hover);
    transform: translateY(-1px);
  }

  /* Alternating Rows */
  .dev-nahian-car-service-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 36px;
    align-items: center;
    margin-bottom: 80px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease-out, transform 0.5s ease-out;
  }

  .dev-nahian-car-service-row.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  .dev-nahian-car-service-row:last-child {
    margin-bottom: 0;
  }

  @media (min-width: 900px) {
    .dev-nahian-car-service-row {
      grid-template-columns: 1.05fr 0.95fr;
      gap: 56px;
    }
    .dev-nahian-car-service-row.dev-nahian-car-reverse {
      grid-template-columns: 0.95fr 1.05fr;
    }
    .dev-nahian-car-service-row.dev-nahian-car-reverse .dev-nahian-car-service-img-col {
      order: 2;
    }
  }

  .dev-nahian-car-service-img-wrap {
    position: relative;
    border-radius: var(--dn-srv-radius-lg);
    overflow: hidden;
    border: 1px solid var(--dn-srv-border);
    box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
  }

  .dev-nahian-car-service-img-wrap img {
    width: 100%;
    height: clamp(300px, 34vw, 420px);
    object-fit: cover;
    display: block;
    transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
  }

  .dev-nahian-car-service-img-wrap:hover img {
    transform: scale(1.03);
  }

  .dev-nahian-car-service-img-pill {
    position: absolute;
    bottom: 18px;
    left: 18px;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    padding: 7px 14px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .dev-nahian-car-service-content-col .dev-nahian-car-service-category {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--dn-srv-gold);
    display: block;
    margin-bottom: 8px;
  }

  .dev-nahian-car-service-content-col h2 {
    font-size: clamp(1.6rem, 2.5vw, 2.1rem);
    font-weight: 800;
    color: var(--dn-srv-text-dark);
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0 0 12px;
  }

  .dev-nahian-car-service-content-col p {
    font-size: 0.98rem;
    color: var(--dn-srv-text-muted);
    line-height: 1.65;
    margin: 0 0 20px;
  }

  .dev-nahian-car-service-checklist {
    list-style: none;
    padding: 0;
    margin: 0 0 28px 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .dev-nahian-car-service-checklist li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.92rem;
    font-weight: 600;
    color: var(--dn-srv-text-dark);
  }

  .dev-nahian-car-service-checklist li svg {
    color: #0d9488;
    flex-shrink: 0;
  }
</style>

<section class="dev-nahian-car-services-page">
  
  <!-- Header (Outputs only if options are set) -->
  <?php if ( ! empty( $badge ) || ! empty( $title ) || ! empty( $desc ) ) : ?>
    <div class="dev-nahian-car-services-header">
      <?php if ( ! empty( $badge ) ) : ?>
        <div class="dev-nahian-car-section-badge"><?php echo esc_html( $badge ); ?></div>
      <?php endif; ?>

      <?php if ( ! empty( $title ) ) : ?>
        <h1><?php echo wp_kses( $title, array( 'span' => array() ) ); ?></h1>
      <?php endif; ?>

      <?php if ( ! empty( $desc ) ) : ?>
        <p><?php echo esc_html( $desc ); ?></p>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- Dynamic Service Rows from Settings Tab -->
  <?php if ( ! empty( $services ) && is_array( $services ) ) : ?>
    <?php 
    $index = 0;
    foreach ( $services as $srv ) : 
      $is_reverse = ( $index % 2 !== 0 ) ? 'dev-nahian-car-reverse' : '';
      $row_id     = ! empty( $srv['title'] ) ? sanitize_title( $srv['title'] ) : 'service-' . ( $index + 1 );
    ?>
      <article class="dev-nahian-car-service-row <?php echo esc_attr( $is_reverse ); ?>" id="<?php echo esc_attr( $row_id ); ?>">
        
        <!-- Image Column -->
        <div class="dev-nahian-car-service-img-col">
          <div class="dev-nahian-car-service-img-wrap">
            <?php if ( ! empty( $srv['image'] ) ) : ?>
              <img src="<?php echo esc_url( $srv['image'] ); ?>" alt="<?php echo esc_attr( $srv['title'] ?? '' ); ?>" loading="lazy">
            <?php else : ?>
              <div style="height: 340px; background: #0f172a; display: flex; align-items: center; justify-content: center; color: #64748b;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
              </div>
            <?php endif; ?>

            <?php if ( ! empty( $srv['pill'] ) ) : ?>
              <div class="dev-nahian-car-service-img-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <?php echo esc_html( $srv['pill'] ); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Content Column -->
        <div class="dev-nahian-car-service-content-col">
          <?php if ( ! empty( $srv['category'] ) ) : ?>
            <span class="dev-nahian-car-service-category"><?php echo esc_html( $srv['category'] ); ?></span>
          <?php endif; ?>

          <?php if ( ! empty( $srv['title'] ) ) : ?>
            <h2><?php echo esc_html( $srv['title'] ); ?></h2>
          <?php endif; ?>

          <?php if ( ! empty( $srv['desc'] ) ) : ?>
            <p><?php echo esc_html( $srv['desc'] ); ?></p>
          <?php endif; ?>

          <?php if ( ! empty( $srv['checklist'] ) && is_array( $srv['checklist'] ) ) : ?>
            <ul class="dev-nahian-car-service-checklist">
              <?php foreach ( $srv['checklist'] as $check_item ) : ?>
                <li>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <?php echo esc_html( $check_item ); ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php if ( ! empty( $srv['btn_text'] ) ) : ?>
            <a href="<?php echo esc_url( ! empty( $srv['btn_url'] ) ? $srv['btn_url'] : '#' ); ?>" class="dev-nahian-car-btn-primary">
              <?php echo esc_html( $srv['btn_text'] ); ?>
            </a>
          <?php endif; ?>
        </div>
      </article>
      <?php 
      $index++;
    endforeach; 
    ?>
  <?php else : ?>
    <p style="text-align: center; color: var(--dn-srv-text-muted); padding: 48px;">
      <?php esc_html_e( 'No services found.', 'dev-nahian-car' ); ?>
    </p>
  <?php endif; ?>

</section>

<script id="dev-nahian-services-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const rows = document.querySelectorAll('.dev-nahian-car-service-row');

      if (rows.length > 0 && 'IntersectionObserver' in window) {
        const rowObserver = new IntersectionObserver(function(entries, observer) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              observer.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.15,
          rootMargin: '0px 0px -40px 0px'
        });

        rows.forEach(function(row) {
          rowObserver.observe(row);
        });
      } else {
        rows.forEach(function(row) {
          row.classList.add('is-visible');
        });
      }
    });
  })();
</script>

<?php 
get_footer(); 
?>