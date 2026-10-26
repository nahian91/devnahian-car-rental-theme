<?php
/**
 * Template Name: About
 * Description: Dynamic About Us page template pulling directly from About Tab settings with zero default data.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since 1.0.0
 */

get_header(); 

// 1. Fetch Dynamic Options from About Sub-Tab (Zero hardcoded text fallbacks)
$badge     = get_option( 'dev_nahian_about_badge', '' );
$title     = get_option( 'dev_nahian_about_title', '' );
$desc      = get_option( 'dev_nahian_about_desc', '' );

$story_h2  = get_option( 'dev_nahian_about_story_heading', '' );
$story_p1  = get_option( 'dev_nahian_about_story_text_1', '' );
$story_p2  = get_option( 'dev_nahian_about_story_text_2', '' );
$story_img = get_option( 'dev_nahian_about_story_image', '' );
$exp_years = get_option( 'dev_nahian_about_experience_years', '' );

$stats     = get_option( 'dev_nahian_about_stats_data', array() );
$pillars   = get_option( 'dev_nahian_about_pillars_data', array() );

$has_story = ! empty( $story_h2 ) || ! empty( $story_p1 ) || ! empty( $story_p2 ) || ! empty( $story_img );
?>

<style id="dev-nahian-about-styles">
  :root {
    --dn-abt-primary: var(--dev-nahian-car-primary, #111827);
    --dn-abt-primary-hover: var(--dev-nahian-car-primary-hover, #1f2937);
    --dn-abt-gold: var(--dev-nahian-car-gold, #b88e1e);
    --dn-abt-gold-glow: rgba(184, 142, 30, 0.12);
    --dn-abt-gold-border: rgba(184, 142, 30, 0.3);
    --dn-abt-text-dark: var(--dev-nahian-car-text-dark, #0f172a);
    --dn-abt-text-muted: var(--dev-nahian-car-text-muted, #64748b);
    --dn-abt-border: var(--dev-nahian-car-border, #e2e8f0);
    --dn-abt-radius-lg: var(--dev-nahian-car-radius, 16px);
  }

  .dev-nahian-car-about-page {
    padding: 64px 20px 88px;
    max-width: 1200px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--dn-abt-text-dark);
  }

  /* Header */
  .dev-nahian-car-about-header {
    text-align: center;
    max-width: 720px;
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
    color: var(--dn-abt-gold);
    background: var(--dn-abt-gold-glow);
    border: 1px solid var(--dn-abt-gold-border);
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 16px;
  }

  .dev-nahian-car-about-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.85rem);
    font-weight: 800;
    color: var(--dn-abt-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin: 0 0 14px;
  }

  .dev-nahian-car-about-header h1 span {
    color: var(--dn-abt-gold);
  }

  .dev-nahian-car-about-header p {
    color: var(--dn-abt-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
  }

  /* Story 2-Col */
  .dev-nahian-car-story-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    align-items: center;
    margin-bottom: 72px;
  }

  @media (min-width: 900px) {
    .dev-nahian-car-story-grid {
      grid-template-columns: 1fr 1fr;
      gap: 56px;
    }
  }

  .dev-nahian-car-story-img-wrap {
    position: relative;
    border-radius: var(--dn-abt-radius-lg);
    overflow: hidden;
    border: 1px solid var(--dn-abt-border);
    box-shadow: 0 12px 32px -8px rgba(15, 23, 42, 0.1);
  }

  .dev-nahian-car-story-img-wrap img {
    width: 100%;
    height: clamp(340px, 38vw, 460px);
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
  }

  .dev-nahian-car-story-img-wrap:hover img {
    transform: scale(1.03);
  }

  .dev-nahian-car-exp-badge {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: #ffffff;
    padding: 10px 18px;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .dev-nahian-car-story-content h2 {
    font-size: clamp(1.7rem, 2.6vw, 2.2rem);
    font-weight: 800;
    color: var(--dn-abt-text-dark);
    letter-spacing: -0.02em;
    line-height: 1.25;
    margin: 0 0 18px;
  }

  .dev-nahian-car-story-content p {
    font-size: 1rem;
    color: var(--dn-abt-text-muted);
    line-height: 1.7;
    margin-bottom: 16px;
  }

  /* Metric Stats */
  .dev-nahian-car-stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 72px;
  }

  @media (min-width: 900px) {
    .dev-nahian-car-stats-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .dev-nahian-car-stat-card {
    background: #ffffff;
    border: 1px solid var(--dn-abt-border);
    border-radius: 14px;
    padding: 26px 20px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .dev-nahian-car-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
  }

  .dev-nahian-car-stat-val {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--dn-abt-text-dark);
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -0.03em;
  }

  .dev-nahian-car-stat-val span.dev-nahian-stat-suffix {
    color: var(--dn-abt-gold);
    font-size: 1.8rem;
  }

  .dev-nahian-car-stat-lbl {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--dn-abt-text-muted);
  }

  /* Pillars */
  .dev-nahian-car-pillars-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 768px) {
    .dev-nahian-car-pillars-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-pillar-card {
    background: #f8fafc;
    border: 1px solid var(--dn-abt-border);
    border-radius: 14px;
    padding: 30px 24px;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
  }

  .dev-nahian-car-pillar-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.08);
    background: #ffffff;
  }

  .dev-nahian-car-pillar-tag {
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--dn-abt-gold);
    margin-bottom: 10px;
    display: block;
  }

  .dev-nahian-car-pillar-card h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--dn-abt-text-dark);
    margin: 0 0 10px;
  }

  .dev-nahian-car-pillar-card p {
    font-size: 0.92rem;
    color: var(--dn-abt-text-muted);
    line-height: 1.6;
    margin: 0;
  }
</style>

<section class="dev-nahian-car-about-page">
  
  <!-- Header (Rendered only if values exist) -->
  <?php if ( ! empty( $badge ) || ! empty( $title ) || ! empty( $desc ) ) : ?>
    <div class="dev-nahian-car-about-header">
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

  <!-- Brand Story Section -->
  <?php if ( $has_story ) : ?>
    <div class="dev-nahian-car-story-grid">
      
      <!-- Image Column -->
      <div class="dev-nahian-car-story-img-col">
        <div class="dev-nahian-car-story-img-wrap">
          <?php if ( ! empty( $story_img ) ) : ?>
            <img src="<?php echo esc_url( $story_img ); ?>" alt="<?php echo esc_attr( $story_h2 ); ?>" loading="lazy">
          <?php else : ?>
            <div style="height: 380px; background: #0f172a; display: flex; align-items: center; justify-content: center; color: #64748b;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            </div>
          <?php endif; ?>

          <?php if ( ! empty( $exp_years ) ) : ?>
            <div class="dev-nahian-car-exp-badge">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
              <?php echo esc_html( $exp_years ); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Story Narrative Column -->
      <div class="dev-nahian-car-story-content">
        <?php if ( ! empty( $story_h2 ) ) : ?>
          <h2><?php echo esc_html( $story_h2 ); ?></h2>
        <?php endif; ?>

        <?php if ( ! empty( $story_p1 ) ) : ?>
          <p><?php echo esc_html( $story_p1 ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $story_p2 ) ) : ?>
          <p><?php echo esc_html( $story_p2 ); ?></p>
        <?php endif; ?>
      </div>

    </div>
  <?php endif; ?>

  <!-- Milestone Metric Counters -->
  <?php if ( ! empty( $stats ) && is_array( $stats ) ) : ?>
    <div class="dev-nahian-car-stats-grid">
      <?php foreach ( $stats as $st ) : 
        $raw_num = preg_replace( '/[^\d.]/', '', (string) ( $st['number'] ?? '' ) );
        if ( empty( $st['number'] ) && empty( $st['label'] ) ) continue;
      ?>
        <div class="dev-nahian-car-stat-card">
          <div class="dev-nahian-car-stat-val">
            <span class="dev-nahian-counter-num" data-target="<?php echo esc_attr( $raw_num ?: '0' ); ?>">
              <?php echo esc_html( $st['number'] ?? '' ); ?>
            </span>
            <?php if ( ! empty( $st['suffix'] ) ) : ?>
              <span class="dev-nahian-stat-suffix"><?php echo esc_html( $st['suffix'] ); ?></span>
            <?php endif; ?>
          </div>
          <?php if ( ! empty( $st['label'] ) ) : ?>
            <div class="dev-nahian-car-stat-lbl"><?php echo esc_html( $st['label'] ); ?></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Core Values & Operational Pillars -->
  <?php if ( ! empty( $pillars ) && is_array( $pillars ) ) : ?>
    <div class="dev-nahian-car-pillars-grid">
      <?php foreach ( $pillars as $pil ) : 
        if ( empty( $pil['title'] ) && empty( $pil['desc'] ) ) continue;
      ?>
        <div class="dev-nahian-car-pillar-card">
          <?php if ( ! empty( $pil['tag'] ) ) : ?>
            <span class="dev-nahian-car-pillar-tag"><?php echo esc_html( $pil['tag'] ); ?></span>
          <?php endif; ?>
          <?php if ( ! empty( $pil['title'] ) ) : ?>
            <h3><?php echo esc_html( $pil['title'] ); ?></h3>
          <?php endif; ?>
          <?php if ( ! empty( $pil['desc'] ) ) : ?>
            <p><?php echo esc_html( $pil['desc'] ); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</section>

<script id="dev-nahian-about-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const counters = document.querySelectorAll('.dev-nahian-counter-num');
      if (counters.length > 0 && 'IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver(function(entries, observer) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              const el = entry.target;
              const target = parseFloat(el.getAttribute('data-target')) || 0;
              const duration = 1600;
              const frameDuration = 1000 / 60;
              const totalFrames = Math.round(duration / frameDuration);
              let frame = 0;

              const counterInterval = setInterval(function() {
                frame++;
                const progress = frame / totalFrames;
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const currentVal = Math.round(target * easeOut);

                el.textContent = currentVal.toLocaleString();

                if (frame >= totalFrames) {
                  el.textContent = target.toLocaleString();
                  clearInterval(counterInterval);
                }
              }, frameDuration);

              observer.unobserve(el);
            }
          });
        }, { threshold: 0.35 });

        counters.forEach(function(counter) {
          counterObserver.observe(counter);
        });
      }
    });
  })();
</script>

<?php 
get_footer(); 
?>