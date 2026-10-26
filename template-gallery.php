<?php
/**
 * Template Name: Gallery
 * Description: Dynamic showcase gallery pulling directly from Gallery Tab settings with zero default data.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since 1.0.0
 */

get_header(); 

// 1. Fetch Dynamic Data from Gallery Tab (Zero hardcoded text fallbacks)
$badge      = get_option( 'dev_nahian_gallery_badge', '' );
$title      = get_option( 'dev_nahian_gallery_title', '' );
$desc       = get_option( 'dev_nahian_gallery_desc', '' );
$categories = get_option( 'dev_nahian_gallery_categories_data', array() );
$items      = get_option( 'dev_nahian_gallery_items_data', array() );

// Create slug => label lookup map
$cat_map = array();
if ( ! empty( $categories ) && is_array( $categories ) ) {
    foreach ( $categories as $c ) {
        if ( ! empty( $c['slug'] ) ) {
            $cat_map[ $c['slug'] ] = ! empty( $c['label'] ) ? $c['label'] : ucfirst( $c['slug'] );
        }
    }
}
?>

<style id="dev-nahian-gallery-styles">
  :root {
    --dn-gal-primary: var(--dev-nahian-car-primary, #111827);
    --dn-gal-primary-hover: var(--dev-nahian-car-primary-hover, #1f2937);
    --dn-gal-gold: var(--dev-nahian-car-gold, #b88e1e);
    --dn-gal-gold-glow: rgba(184, 142, 30, 0.12);
    --dn-gal-gold-border: rgba(184, 142, 30, 0.3);
    --dn-gal-text-dark: var(--dev-nahian-car-text-dark, #0f172a);
    --dn-gal-text-muted: var(--dev-nahian-car-text-muted, #64748b);
    --dn-gal-border: var(--dev-nahian-car-border, #e2e8f0);
    --dn-gal-bg-light: var(--dev-nahian-car-bg-light, #f8fafc);
    --dn-gal-radius: var(--dev-nahian-car-radius, 12px);
  }

  .dev-nahian-car-gallery-section {
    padding: 64px 20px 88px;
    max-width: 1240px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--dn-gal-text-dark);
  }

  .dev-nahian-car-gallery-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 44px;
  }

  .dev-nahian-car-gallery-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--dn-gal-gold);
    background: var(--dn-gal-gold-glow);
    border: 1px solid var(--dn-gal-gold-border);
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 16px;
  }

  .dev-nahian-car-gallery-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dn-gal-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin: 0 0 14px;
  }

  .dev-nahian-car-gallery-header h1 span {
    color: var(--dn-gal-gold);
  }

  .dev-nahian-car-gallery-header p {
    color: var(--dn-gal-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
  }

  .dev-nahian-car-filter-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 40px;
  }

  .dev-nahian-car-filter-btn {
    background: var(--dn-gal-bg-light);
    border: 1px solid var(--dn-gal-border);
    color: var(--dn-gal-text-muted);
    font-size: 0.85rem;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 999px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-filter-btn:hover {
    background: #ffffff;
    color: var(--dn-gal-text-dark);
    border-color: var(--dn-gal-text-dark);
  }

  .dev-nahian-car-filter-btn.active {
    background: var(--dn-gal-primary);
    color: #ffffff;
    border-color: var(--dn-gal-primary);
    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
  }

  .dev-nahian-car-gallery-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 640px) {
    .dev-nahian-car-gallery-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1024px) {
    .dev-nahian-car-gallery-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-gallery-item {
    position: relative;
    border-radius: var(--dn-gal-radius);
    overflow: hidden;
    background: #0f172a;
    border: 1px solid var(--dn-gal-border);
    height: 310px;
    cursor: pointer;
    transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease;
  }

  .dev-nahian-car-gallery-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.12);
  }

  .dev-nahian-car-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
  }

  .dev-nahian-car-gallery-item:hover img {
    transform: scale(1.06);
  }

  .dev-nahian-car-gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 0%, rgba(15, 23, 42, 0.85) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 22px;
    opacity: 0;
    transition: opacity 0.25s ease;
  }

  .dev-nahian-car-gallery-item:hover .dev-nahian-car-gallery-overlay {
    opacity: 1;
  }

  .dev-nahian-car-gallery-tag {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--dn-gal-gold);
    margin-bottom: 4px;
  }

  .dev-nahian-car-gallery-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.3;
    margin: 0;
  }

  .dev-nahian-car-gallery-zoom-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.18);
  }

  /* Lightbox Modal */
  .dev-nahian-car-lightbox {
    position: fixed;
    inset: 0;
    background: rgba(10, 13, 20, 0.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
    padding: 24px;
  }

  .dev-nahian-car-lightbox.active {
    opacity: 1;
    visibility: visible;
  }

  .dev-nahian-car-lightbox-content {
    position: relative;
    max-width: 960px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .dev-nahian-car-lightbox-img {
    max-height: 80vh;
    width: auto;
    max-width: 100%;
    border-radius: var(--dn-gal-radius);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    display: block;
  }

  .dev-nahian-car-lightbox-caption {
    margin-top: 16px;
    color: #ffffff;
    font-size: 1.1rem;
    font-weight: 600;
    text-align: center;
  }

  .dev-nahian-car-lightbox-close {
    position: absolute;
    top: -46px;
    right: 0;
    background: transparent;
    border: none;
    color: #ffffff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
  }

  .dev-nahian-car-lightbox-close:hover {
    color: var(--dn-gal-gold);
  }
</style>

<section class="dev-nahian-car-gallery-section">
  
  <!-- Header (Outputs only if options are set) -->
  <?php if ( ! empty( $badge ) || ! empty( $title ) || ! empty( $desc ) ) : ?>
    <div class="dev-nahian-car-gallery-header">
      <?php if ( ! empty( $badge ) ) : ?>
        <div class="dev-nahian-car-gallery-badge"><?php echo esc_html( $badge ); ?></div>
      <?php endif; ?>

      <?php if ( ! empty( $title ) ) : ?>
        <h1><?php echo wp_kses( $title, array( 'span' => array() ) ); ?></h1>
      <?php endif; ?>

      <?php if ( ! empty( $desc ) ) : ?>
        <p><?php echo esc_html( $desc ); ?></p>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- Category Filter Bar -->
  <?php if ( ! empty( $categories ) && is_array( $categories ) ) : ?>
    <div class="dev-nahian-car-filter-bar">
      <button class="dev-nahian-car-filter-btn active" data-filter="all"><?php esc_html_e( 'All', 'dev-nahian-car' ); ?></button>
      <?php foreach ( $categories as $cat ) : 
        if ( empty( $cat['slug'] ) || empty( $cat['label'] ) ) continue;
      ?>
        <button class="dev-nahian-car-filter-btn" data-filter="<?php echo esc_attr( $cat['slug'] ); ?>">
          <?php echo esc_html( $cat['label'] ); ?>
        </button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Gallery Photos Grid -->
  <div class="dev-nahian-car-gallery-grid" id="galleryGrid">
    <?php if ( ! empty( $items ) && is_array( $items ) ) : ?>
      <?php foreach ( $items as $photo ) : 
        $cat_key   = $photo['category'] ?? 'all';
        $cat_label = $cat_map[ $cat_key ] ?? '';
        $img_src   = $photo['image'] ?? '';
        $img_title = $photo['title'] ?? '';
        if ( empty( $img_src ) ) continue;
      ?>
        <div class="dev-nahian-car-gallery-item" data-category="<?php echo esc_attr( $cat_key ); ?>" data-src="<?php echo esc_url( $img_src ); ?>" data-title="<?php echo esc_attr( $img_title ); ?>">
          <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $img_title ); ?>" loading="lazy">
          <div class="dev-nahian-car-gallery-zoom-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
          </div>
          <div class="dev-nahian-car-gallery-overlay">
            <?php if ( ! empty( $cat_label ) ) : ?>
              <span class="dev-nahian-car-gallery-tag"><?php echo esc_html( $cat_label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $img_title ) ) : ?>
              <h3 class="dev-nahian-car-gallery-title"><?php echo esc_html( $img_title ); ?></h3>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p style="grid-column: 1 / -1; text-align: center; color: var(--dn-gal-text-muted); padding: 40px;">
        <?php esc_html_e( 'No photos found.', 'dev-nahian-car' ); ?>
      </p>
    <?php endif; ?>
  </div>
</section>

<!-- Lightbox Modal -->
<div class="dev-nahian-car-lightbox" id="galleryLightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Photo Preview', 'dev-nahian-car' ); ?>">
  <div class="dev-nahian-car-lightbox-content">
    <button class="dev-nahian-car-lightbox-close" id="lightboxClose" aria-label="<?php esc_attr_e( 'Close Preview', 'dev-nahian-car' ); ?>" type="button">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <img src="" alt="" class="dev-nahian-car-lightbox-img" id="lightboxImg">
    <div class="dev-nahian-car-lightbox-caption" id="lightboxCaption"></div>
  </div>
</div>

<script id="dev-nahian-gallery-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      // Category Filtering
      const filterBtns   = document.querySelectorAll('.dev-nahian-car-filter-btn');
      const galleryItems = document.querySelectorAll('.dev-nahian-car-gallery-item');

      filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
          filterBtns.forEach(function(b) { b.classList.remove('active'); });
          btn.classList.add('active');

          const filter = btn.getAttribute('data-filter');
          galleryItems.forEach(function(item) {
            const category = item.getAttribute('data-category');
            if (filter === 'all' || category === filter) {
              item.style.display = 'block';
            } else {
              item.style.display = 'none';
            }
          });
        });
      });

      // Lightbox
      const lightbox        = document.getElementById('galleryLightbox');
      const lightboxImg     = document.getElementById('lightboxImg');
      const lightboxCaption = document.getElementById('lightboxCaption');
      const lightboxClose   = document.getElementById('lightboxClose');

      if (!lightbox || !lightboxImg || !lightboxCaption || !lightboxClose) {
        return;
      }

      function openLightbox(src, title) {
        lightboxImg.src = src;
        lightboxImg.alt = title;
        lightboxCaption.textContent = title;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
      }

      function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
        lightboxImg.src = '';
        lightboxImg.alt = '';
        lightboxCaption.textContent = '';
      }

      galleryItems.forEach(function(item) {
        item.addEventListener('click', function() {
          const fullSrc = item.getAttribute('data-src') || '';
          const title   = item.getAttribute('data-title') || '';
          openLightbox(fullSrc, title);
        });
      });

      lightboxClose.addEventListener('click', closeLightbox);

      lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
          closeLightbox();
        }
      });

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
          closeLightbox();
        }
      });
    });
  })();
</script>

<?php 
get_footer(); 
?>