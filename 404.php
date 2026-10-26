<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

get_header(); 
?>

<!-- Internal 404 Error CSS Architecture -->
<style id="dev-nahian-404-styles">
  :root {
    --dev-nahian-car-primary: #111827;
    --dev-nahian-car-primary-hover: #1f2937;
    --dev-nahian-car-gold: #b88e1e;
    --dev-nahian-car-gold-glow: rgba(184, 142, 30, 0.12);
    --dev-nahian-car-gold-border: rgba(184, 142, 30, 0.3);
    --dev-nahian-car-text-dark: #0f172a;
    --dev-nahian-car-text-muted: #64748b;
    --dev-nahian-car-border: #e2e8f0;
    --dev-nahian-car-bg-light: #f8fafc;
    --dev-nahian-car-radius-sm: 8px;
    --dev-nahian-car-radius-lg: 20px;
    --dev-nahian-car-font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  }

  .dev-nahian-car-error-wrapper {
    padding: 80px 20px 100px;
    max-width: 720px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    text-align: center;
  }

  .dev-nahian-car-error-header {
    margin-bottom: 24px;
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
  }

  .dev-nahian-car-badge-pulse {
    width: 6px;
    height: 6px;
    background: var(--dev-nahian-car-gold);
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(184, 142, 30, 0.2);
    animation: devNahianPulse 2s infinite;
  }

  @keyframes devNahianPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.6; }
  }

  .dev-nahian-car-error-card-shell {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-lg);
    padding: clamp(36px, 5.5vw, 56px) clamp(24px, 4vw, 44px);
    box-shadow: 0 12px 36px -8px rgba(15, 23, 42, 0.08);
  }

  .dev-nahian-car-error-code-label {
    font-size: clamp(4.5rem, 12vw, 7rem);
    font-weight: 900;
    font-family: var(--dev-nahian-car-font-mono);
    line-height: 1;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.04em;
    margin-bottom: 12px;
  }

  .dev-nahian-car-error-code-label span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-error-card-shell h2 {
    font-size: clamp(1.6rem, 3vw, 2.1rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.02em;
    margin: 0 0 12px;
  }

  .dev-nahian-car-error-card-shell p {
    font-size: 0.98rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.6;
    margin: 0 auto 32px;
    max-width: 520px;
  }

  .dev-nahian-car-error-search-form {
    max-width: 440px;
    margin: 0 auto 32px;
    position: relative;
    display: flex;
    align-items: center;
  }

  .dev-nahian-car-error-search-input {
    width: 100%;
    height: 48px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 0 46px 0 16px;
    font-size: 0.9rem;
    color: var(--dev-nahian-car-text-dark);
    background: var(--dev-nahian-car-bg-light);
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-error-search-input:focus {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.08);
  }

  .dev-nahian-car-error-search-btn {
    position: absolute;
    right: 8px;
    background: transparent;
    border: none;
    color: var(--dev-nahian-car-text-muted);
    cursor: pointer;
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
  }

  .dev-nahian-car-error-search-btn:hover {
    color: var(--dev-nahian-car-primary);
  }

  .dev-nahian-car-error-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .dev-nahian-car-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    font-size: 0.9rem;
    font-weight: 700;
    border-radius: var(--dev-nahian-car-radius-sm);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid transparent;
  }

  .dev-nahian-car-btn-primary {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
  }

  .dev-nahian-car-btn-primary:hover {
    background: var(--dev-nahian-car-primary-hover);
    transform: translateY(-1px);
  }

  .dev-nahian-car-btn-secondary {
    background: #ffffff;
    color: var(--dev-nahian-car-text-dark);
    border-color: var(--dev-nahian-car-border);
  }

  .dev-nahian-car-btn-secondary:hover {
    background: var(--dev-nahian-car-bg-light);
    border-color: var(--dev-nahian-car-text-dark);
  }
</style>

<div class="dev-nahian-car-error-wrapper">
  <!-- Header -->
  <div class="dev-nahian-car-error-header">
    <div class="dev-nahian-car-section-badge">
      <span class="dev-nahian-car-badge-pulse"></span>
      Routing System &bull; Telemetry Exception
    </div>
  </div>

  <!-- Card Body -->
  <div class="dev-nahian-car-error-card-shell">
    <div class="dev-nahian-car-error-code-label">4<span>0</span>4</div>
    <h2>Chassis Not Located</h2>
    <p>The route or vehicle dossier you requested has expired, been relocated to another hangar, or is unavailable within our active network.</p>

    <!-- Fallback Search Engine -->
    <form role="search" method="get" class="dev-nahian-car-error-search-form" action="<?php echo esc_url( home_url( '/cars/' ) ); ?>">
      <input type="search" class="dev-nahian-car-error-search-input" placeholder="<?php esc_attr_e( 'Search active vehicles by model or chassis...', 'dev-nahian-car' ); ?>" name="s" id="errorSearchInput">
      <button type="submit" class="dev-nahian-car-error-search-btn" aria-label="<?php esc_attr_e( 'Search', 'dev-nahian-car' ); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </button>
    </form>

    <div class="dev-nahian-car-error-actions">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-primary">Return to Portal</a>
      <a href="<?php echo esc_url( home_url( '/cars/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary">Browse Active Fleet</a>
    </div>
  </div>
</div>

<!-- Internal 404 Error JavaScript Architecture -->
<script id="dev-nahian-404-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('errorSearchInput');
      
      // Auto-focus search input on larger screens for immediate recovery
      if (searchInput && window.innerWidth >= 768) {
        searchInput.focus();
      }
    });
  })();
</script>

<?php 
get_footer(); 
?>