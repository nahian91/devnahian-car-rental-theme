<?php
/**
 * Template Name: Thank You
 * The template for displaying the Booking Confirmation / Thank You page
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

get_header(); 
?>

<!-- Internal Confirmation CSS Architecture -->
<style id="dev-nahian-thanks-styles">
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
    --dev-nahian-car-accent-green: #0d9488;
    --dev-nahian-car-accent-green-bg: #f0fdfa;
    --dev-nahian-car-radius: 12px;
    --dev-nahian-car-radius-sm: 8px;
    --dev-nahian-car-radius-lg: 20px;
  }

  .dev-nahian-car-thanks-section {
    padding: 64px 20px 96px;
    max-width: 680px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  .dev-nahian-car-thanks-card {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-lg);
    padding: clamp(32px, 5vw, 48px);
    box-shadow: 0 10px 32px -6px rgba(15, 23, 42, 0.06);
    text-align: center;
  }

  /* Success Icon */
  .dev-nahian-car-success-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--dev-nahian-car-accent-green-bg);
    border: 1px solid rgba(13, 148, 136, 0.3);
    color: var(--dev-nahian-car-accent-green);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  .dev-nahian-car-success-icon:hover {
    transform: scale(1.08);
  }

  .dev-nahian-car-thanks-card h1 {
    font-size: clamp(1.8rem, 3.2vw, 2.3rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.02em;
    margin: 0 0 8px;
  }

  .dev-nahian-car-thanks-card h1 span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-thanks-subtitle {
    font-size: 0.95rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.6;
    margin: 0 auto 28px;
    max-width: 480px;
  }

  /* Booking Reference Banner */
  .dev-nahian-car-reference-box {
    background: var(--dev-nahian-car-bg-light);
    border: 1px dashed var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    gap: 12px;
  }

  .dev-nahian-car-reference-box span {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--dev-nahian-car-text-muted);
    letter-spacing: 0.05em;
  }

  .dev-nahian-car-ref-copy-wrapper {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .dev-nahian-car-reference-box strong {
    font-family: ui-monospace, monospace;
    font-size: 1rem;
    font-weight: 800;
    color: var(--dev-nahian-car-primary);
    letter-spacing: 0.05em;
  }

  .dev-nahian-car-copy-btn {
    background: transparent;
    border: none;
    color: var(--dev-nahian-car-text-muted);
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s, background 0.2s;
  }

  .dev-nahian-car-copy-btn:hover {
    color: var(--dev-nahian-car-primary);
    background: #e2e8f0;
  }

  /* Order Summary Table */
  .dev-nahian-car-summary-table {
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    overflow: hidden;
    margin-bottom: 28px;
    text-align: left;
  }

  .dev-nahian-car-summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 18px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
    font-size: 0.88rem;
  }

  .dev-nahian-car-summary-row:last-child {
    border-bottom: none;
  }

  .dev-nahian-car-summary-row.dev-nahian-car-total-row {
    background: var(--dev-nahian-car-bg-light);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    font-size: 0.95rem;
  }

  .dev-nahian-car-summary-row span {
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-summary-row strong {
    color: var(--dev-nahian-car-text-dark);
    font-weight: 700;
    text-align: right;
  }

  /* Next Steps */
  .dev-nahian-car-next-steps-box {
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 16px 20px;
    margin-bottom: 32px;
    text-align: left;
  }

  .dev-nahian-car-next-steps-box h4 {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 6px;
  }

  .dev-nahian-car-next-steps-box p {
    font-size: 0.85rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.55;
    margin: 0;
  }

  /* Actions */
  .dev-nahian-car-btn-group {
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

<section class="dev-nahian-car-thanks-section">
  <div class="dev-nahian-car-thanks-card">
    
    <!-- Success Badge -->
    <div class="dev-nahian-car-success-icon" aria-hidden="true">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </div>

    <h1>Thank You for Your <span>Reservation!</span></h1>
    <p class="dev-nahian-car-thanks-subtitle">
      Your vehicle has been successfully allocated. A booking confirmation and receipt have been dispatched to your email.
    </p>

    <!-- Reference -->
    <div class="dev-nahian-car-reference-box">
      <span>Booking Reference</span>
      <div class="dev-nahian-car-ref-copy-wrapper">
        <strong id="bookingReferenceCode">#VEL-992-GT3G</strong>
        <button type="button" class="dev-nahian-car-copy-btn" id="btnCopyBookingRef" title="Copy Reference Code" aria-label="Copy booking reference code">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Rental Overview -->
    <div class="dev-nahian-car-summary-table">
      <div class="dev-nahian-car-summary-row">
        <span>Allocated Vehicle</span>
        <strong>Veloce GT3 Coupé</strong>
      </div>
      <div class="dev-nahian-car-summary-row">
        <span>Handover Station</span>
        <strong>JFK Airport &bull; Bay 12</strong>
      </div>
      <div class="dev-nahian-car-summary-row">
        <span>Rental Dates</span>
        <strong>Oct 12 &ndash; Oct 15 (3 Days)</strong>
      </div>
      <div class="dev-nahian-car-summary-row">
        <span>Driver Name</span>
        <strong>Alexander Vance</strong>
      </div>
      <div class="dev-nahian-car-summary-row dev-nahian-car-total-row">
        <span>Total Paid</span>
        <strong style="color: var(--dev-nahian-car-primary);">$567.00</strong>
      </div>
    </div>

    <!-- Next Steps -->
    <div class="dev-nahian-car-next-steps-box">
      <h4>What Happens Next?</h4>
      <p>
        Your digital NFC smartphone pass will be issued 2 hours prior to flight touchdown. Simply walk straight to your bay, tap your phone to unlock, and proceed without counter lines.
      </p>
    </div>

    <!-- Actions -->
    <div class="dev-nahian-car-btn-group">
      <a href="<?php echo esc_url( home_url( '/account/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-primary">Go to Dashboard</a>
      <a href="<?php echo esc_url( home_url( '/cars/' ) ); ?>" class="dev-nahian-car-btn dev-nahian-car-btn-secondary">Browse Other Cars</a>
    </div>

  </div>
</section>

<!-- Internal Confirmation JavaScript Architecture -->
<script id="dev-nahian-thanks-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('btnCopyBookingRef');
      const refCode = document.getElementById('bookingReferenceCode');

      if (copyBtn && refCode) {
        copyBtn.addEventListener('click', function() {
          const textToCopy = refCode.textContent.trim().replace(/^#/, '');

          if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(function() {
              copyBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--dev-nahian-car-accent-green)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>';
              setTimeout(function() {
                copyBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>';
              }, 2000);
            });
          }
        });
      }
    });
  })();
</script>

<?php 
get_footer(); 
?>