<?php
/**
 * The template for displaying all single pages
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

get_header(); 

// Fetch current page data
the_post();
?>

<!-- Internal Single Page CSS Architecture -->
<style id="dev-nahian-page-styles">
  :root {
    --dev-nahian-car-primary: #111827;
    --dev-nahian-car-primary-hover: #1f2937;
    --dev-nahian-car-gold: #b88e1e;
    --dev-nahian-car-gold-hover: #9c7713;
    --dev-nahian-car-gold-glow: rgba(184, 142, 30, 0.12);
    --dev-nahian-car-gold-border: rgba(184, 142, 30, 0.3);
    --dev-nahian-car-text-dark: #0f172a;
    --dev-nahian-car-text-muted: #64748b;
    --dev-nahian-car-border: #e2e8f0;
    --dev-nahian-car-bg-light: #f8fafc;
    --dev-nahian-car-radius: 12px;
    --dev-nahian-car-radius-sm: 8px;
    --dev-nahian-car-radius-md: 16px;
  }

  .dev-nahian-car-page-wrapper {
    padding: 64px 20px 88px;
    max-width: 1040px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  /* Centered Page Header with Pill Badge */
  .dev-nahian-car-page-header {
    text-align: center;
    max-width: 760px;
    margin: 0 auto 48px;
  }

  .dev-nahian-car-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--dev-nahian-car-gold);
    background: var(--dev-nahian-car-gold-glow);
    border: 1px solid var(--dev-nahian-car-gold-border);
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 16px;
  }

  .dev-nahian-car-badge-pulse {
    width: 6px;
    height: 6px;
    background: var(--dev-nahian-car-gold);
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(184, 142, 30, 0.2);
  }

  .dev-nahian-car-page-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.2;
    margin: 0;
  }

  /* Page Main Surface Card */
  .dev-nahian-car-page-main {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: clamp(28px, 4.5vw, 52px);
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-featured-lead-img {
    width: 100%;
    height: clamp(260px, 34vw, 420px);
    object-fit: cover;
    border-radius: var(--dev-nahian-car-radius-sm);
    margin-bottom: 32px;
    border: 1px solid var(--dev-nahian-car-border);
    display: block;
  }

  .dev-nahian-car-page-body {
    font-size: 1.02rem;
    color: #334155;
    line-height: 1.8;
  }

  .dev-nahian-car-page-body p {
    margin-bottom: 22px;
  }

  .dev-nahian-car-page-body h2 {
    font-size: clamp(1.4rem, 2.4vw, 1.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 36px 0 16px;
    letter-spacing: -0.02em;
  }

  .dev-nahian-car-page-body h3 {
    font-size: clamp(1.2rem, 2vw, 1.45rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 28px 0 12px;
  }

  .dev-nahian-car-page-body ul, 
  .dev-nahian-car-page-body ol {
    margin-bottom: 22px;
    padding-left: 24px;
  }

  .dev-nahian-car-page-body li {
    margin-bottom: 8px;
  }

  .dev-nahian-car-page-body a {
    color: var(--dev-nahian-car-gold);
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s ease;
  }

  .dev-nahian-car-page-body a:hover {
    color: var(--dev-nahian-car-gold-hover);
  }

  .dev-nahian-car-page-body blockquote {
    border-left: 3px solid var(--dev-nahian-car-gold);
    padding-left: 18px;
    margin: 24px 0;
    color: var(--dev-nahian-car-text-muted);
    font-style: italic;
  }

  .dev-nahian-car-table-scroll-wrapper {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 24px;
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-page-body table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.92rem;
  }

  .dev-nahian-car-page-body th,
  .dev-nahian-car-page-body td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
    text-align: left;
  }

  .dev-nahian-car-page-body th {
    background: var(--dev-nahian-car-bg-light);
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
  }
</style>

<div class="dev-nahian-car-page-wrapper">
  <!-- Centered Page Header -->
  <div class="dev-nahian-car-page-header">
    <div class="dev-nahian-car-section-badge">
      <span class="dev-nahian-car-badge-pulse"></span>
      Veloce Prestige &bull; Corporate Dossier
    </div>
    <h1><?php the_title(); ?></h1>
  </div>

  <!-- Main Page Card Container -->
  <main class="dev-nahian-car-page-main">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'large', array( 'class' => 'dev-nahian-car-featured-lead-img', 'alt' => get_the_title() ) ); ?>
    <?php endif; ?>

    <div class="dev-nahian-car-page-body" id="pageContentArea">
      <?php the_content(); ?>
    </div>
  </main>
</div>

<!-- Internal Single Page JavaScript Architecture -->
<script id="dev-nahian-page-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const content = document.getElementById('pageContentArea');
      if (!content) return;

      // 1. Wrap dynamic tables for responsive horizontal scrolling
      const tables = content.querySelectorAll('table');
      tables.forEach(function(table) {
        if (!table.parentElement.classList.contains('dev-nahian-car-table-scroll-wrapper')) {
          const wrapper = document.createElement('div');
          wrapper.className = 'dev-nahian-car-table-scroll-wrapper';
          table.parentNode.insertBefore(wrapper, table);
          wrapper.appendChild(table);
        }
      });

      // 2. Open external links securely in new tab
      const links = content.querySelectorAll('a[href^="http"]');
      const currentHost = window.location.hostname;
      links.forEach(function(link) {
        try {
          const linkUrl = new URL(link.href);
          if (linkUrl.hostname !== currentHost) {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
          }
        } catch (e) {
          // Invalid URL format fallback
        }
      });
    });
  })();
</script>

<?php 
get_footer(); 
?>