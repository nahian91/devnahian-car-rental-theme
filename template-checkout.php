<?php
/**
 * Template Name: Checkout
 * Description: Secure airside dispatch authorization and checkout template with digital NFC pass issuance.
 */

get_header(); 
?>

<!-- Internal Checkout CSS Architecture -->
<style id="dev-nahian-checkout-styles">
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
    --dev-nahian-car-accent-green: #0d9488;
    --dev-nahian-car-accent-green-bg: #f0fdfa;
    --dev-nahian-car-radius: 12px;
    --dev-nahian-car-radius-sm: 8px;
    --dev-nahian-car-radius-lg: 20px;
    --dev-nahian-car-font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  }

  .dev-nahian-car-checkout-wrapper {
    padding: 64px 20px 88px;
    max-width: 1260px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  /* Centered Header with Pill Badge & Milestone Steps */
  .dev-nahian-car-checkout-header {
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

  .dev-nahian-car-checkout-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 10px;
  }

  .dev-nahian-car-checkout-header h1 span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-checkout-header p {
    color: var(--dev-nahian-car-text-muted);
    font-size: 1.05rem;
    line-height: 1.5;
    margin: 0 0 24px;
  }

  /* 3-Step Milestone Tracker */
  .dev-nahian-car-steps-tracker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .dev-nahian-car-step-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.76rem;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 999px;
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-step-pill.completed {
    color: var(--dev-nahian-car-accent-green);
    background: var(--dev-nahian-car-accent-green-bg);
    border-color: rgba(13, 148, 136, 0.25);
  }

  .dev-nahian-car-step-pill.active {
    color: var(--dev-nahian-car-primary);
    background: #ffffff;
    border-color: var(--dev-nahian-car-primary);
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
  }

  .dev-nahian-car-step-divider {
    width: 14px;
    height: 1px;
    background: var(--dev-nahian-car-border);
  }

  /* Two-Column Split Layout */
  .dev-nahian-car-checkout-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 36px;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-checkout-layout {
      grid-template-columns: 1.25fr 0.75fr;
      gap: 40px;
      align-items: start;
    }
  }

  /* Form Modules */
  .dev-nahian-car-form-module-card {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: clamp(20px, 3.5vw, 32px);
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
  }

  .dev-nahian-car-module-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.01em;
    display: flex;
    align-items: center;
    margin: 0 0 4px;
  }

  .dev-nahian-car-module-badge-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--dev-nahian-car-primary);
    color: var(--dev-nahian-car-gold);
    font-size: 0.72rem;
    font-weight: 800;
    margin-right: 8px;
    flex-shrink: 0;
  }

  .dev-nahian-car-module-subtitle {
    font-size: 0.85rem;
    color: var(--dev-nahian-car-text-muted);
    margin: 0 0 20px;
    padding-left: 32px;
  }

  .dev-nahian-car-form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 600px) {
    .dev-nahian-car-form-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    .dev-nahian-car-col-span-full {
      grid-column: span 2;
    }
  }

  .dev-nahian-car-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .dev-nahian-car-form-group label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--dev-nahian-car-text-dark);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .dev-nahian-car-input-shell {
    position: relative;
    display: flex;
    align-items: center;
  }

  .dev-nahian-car-input-shell svg {
    position: absolute;
    left: 14px;
    color: var(--dev-nahian-car-text-muted);
    pointer-events: none;
    transition: color 0.2s;
  }

  .dev-nahian-car-input-control {
    width: 100%;
    height: 46px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding-left: 42px;
    padding-right: 14px;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--dev-nahian-car-text-dark);
    background: var(--dev-nahian-car-bg-light);
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s, background-color 0.2s;
  }

  .dev-nahian-car-input-control:focus {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
  }

  .dev-nahian-car-input-control:focus + svg {
    color: var(--dev-nahian-car-primary);
  }

  /* Payment Selectable Cards */
  .dev-nahian-car-payment-method-selector {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 20px;
  }

  @media (max-width: 600px) {
    .dev-nahian-car-payment-method-selector {
      grid-template-columns: 1fr;
    }
  }

  .dev-nahian-car-payment-option-label {
    position: relative;
    background: var(--dev-nahian-car-bg-light);
    border: 2px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 16px 14px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    text-align: center;
    transition: all 0.2s ease;
    user-select: none;
  }

  .dev-nahian-car-payment-option-label input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .dev-nahian-car-payment-option-label svg {
    color: var(--dev-nahian-car-text-muted);
    transition: color 0.2s;
  }

  .dev-nahian-car-payment-option-label span {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-payment-option-label:hover {
    background: #ffffff;
    border-color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-payment-option-label.active {
    background: #ffffff;
    border-color: var(--dev-nahian-car-primary);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
  }

  .dev-nahian-car-payment-option-label.active svg {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-security-notice-pill {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--dev-nahian-car-bg-light);
    border: 1px dashed var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 12px 16px;
    margin-top: 16px;
    font-size: 0.8rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.4;
  }

  .dev-nahian-car-security-notice-pill svg {
    color: var(--dev-nahian-car-accent-green);
    flex-shrink: 0;
  }

  .dev-nahian-car-btn-authorize {
    width: 100%;
    height: 50px;
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border: none;
    border-radius: var(--dev-nahian-car-radius-sm);
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background 0.2s;
  }

  .dev-nahian-car-btn-authorize:hover {
    background: var(--dev-nahian-car-primary-hover);
  }

  .dev-nahian-car-checkout-success-banner {
    display: none;
    padding: 18px;
    border-radius: var(--dev-nahian-car-radius-sm);
    background: var(--dev-nahian-car-accent-green-bg);
    border: 1px solid rgba(13, 148, 136, 0.35);
    color: var(--dev-nahian-car-accent-green);
    font-size: 0.9rem;
    font-weight: 700;
    line-height: 1.5;
    text-align: center;
    margin-top: 16px;
  }

  .dev-nahian-car-checkout-success-banner.show {
    display: block;
  }

  /* RIGHT COLUMN: BOARDING PASS MANIFEST */
  .dev-nahian-car-itinerary-card {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: clamp(20px, 3.5vw, 28px);
    box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
    position: sticky;
    top: 96px;
  }

  .dev-nahian-car-itinerary-header {
    padding-bottom: 14px;
    margin-bottom: 16px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .dev-nahian-car-itinerary-header h3 {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0;
    letter-spacing: -0.01em;
  }

  .dev-nahian-car-manifest-badge {
    font-family: var(--dev-nahian-car-font-mono);
    font-size: 0.72rem;
    font-weight: 700;
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    padding: 3px 8px;
    border-radius: 4px;
    color: var(--dev-nahian-car-text-dark);
  }

  /* Vehicle Mini Summary */
  .dev-nahian-car-vehicle-mini-summary {
    display: flex;
    gap: 14px;
    padding-bottom: 16px;
    border-bottom: 1px dashed var(--dev-nahian-car-border);
    margin-bottom: 16px;
  }

  .dev-nahian-car-mini-thumb-wrap {
    width: 90px;
    height: 64px;
    border-radius: 6px;
    overflow: hidden;
    background: #0f172a;
    flex-shrink: 0;
    border: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-mini-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .dev-nahian-car-mini-info h4 {
    font-size: 1rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0;
  }

  .dev-nahian-car-mini-info span {
    display: block;
    font-size: 0.78rem;
    color: var(--dev-nahian-car-text-muted);
    margin-top: 2px;
  }

  .dev-nahian-car-mini-vin {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--dev-nahian-car-accent-green);
    margin-top: 4px;
  }

  /* Route Block */
  .dev-nahian-car-flight-route-block {
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 12px 16px;
    margin-bottom: 16px;
  }

  .dev-nahian-car-route-node-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .dev-nahian-car-route-node strong {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    display: block;
    line-height: 1;
  }

  .dev-nahian-car-route-node span {
    font-size: 0.68rem;
    color: var(--dev-nahian-car-text-muted);
    text-transform: uppercase;
    font-weight: 700;
    margin-top: 3px;
    display: block;
  }

  .dev-nahian-car-route-plane-indicator {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--dev-nahian-car-gold);
    opacity: 0.85;
  }

  .dev-nahian-car-route-plane-line {
    width: 36px;
    height: 1px;
    background: repeating-linear-gradient(to right, var(--dev-nahian-car-gold) 0, var(--dev-nahian-car-gold) 4px, transparent 4px, transparent 8px);
  }

  /* Itinerary Details List */
  .dev-nahian-car-itinerary-details-list {
    list-style: none;
    padding: 0;
    margin: 0 0 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding-bottom: 16px;
    border-bottom: 1px dashed var(--dev-nahian-car-border);
  }

  .dev-nahian-car-itinerary-detail-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
  }

  .dev-nahian-car-itinerary-detail-row .dev-nahian-car-row-label {
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-itinerary-detail-row .dev-nahian-car-row-val {
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
    text-align: right;
  }

  /* Billing Breakdown */
  .dev-nahian-car-billing-breakdown {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 18px;
  }

  .dev-nahian-car-bill-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-bill-row.total-row {
    border-top: 1px solid var(--dev-nahian-car-border);
    padding-top: 12px;
    margin-top: 4px;
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-bill-total-fig {
    font-size: 1.5rem;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1;
  }

  .dev-nahian-car-terms-note {
    font-size: 0.74rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.5;
    border-top: 1px solid var(--dev-nahian-car-border);
    padding-top: 12px;
  }
</style>

<div class="dev-nahian-car-checkout-wrapper">
  <!-- Header -->
  <div class="dev-nahian-car-checkout-header">
    <div class="dev-nahian-car-section-badge">
      <span class="dev-nahian-car-badge-pulse"></span>
      Security Protocol &bull; Token Issuance
    </div>
    <h1>Airside Dispatch <span>Authorization</span></h1>
    <p>Verify driver credentials, specify hangar access details, and lock your vehicle token.</p>

    <div class="dev-nahian-car-steps-tracker">
      <div class="dev-nahian-car-step-pill completed">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
        01 Chassis
      </div>
      <div class="dev-nahian-car-step-divider"></div>
      <div class="dev-nahian-car-step-pill active">02 Dispatch Credentials</div>
      <div class="dev-nahian-car-step-divider"></div>
      <div class="dev-nahian-car-step-pill">03 NFC Key</div>
    </div>
  </div>

  <!-- Two-Column Checkout Layout -->
  <div class="dev-nahian-car-checkout-layout">

    <!-- LEFT COLUMN: Forms -->
    <div class="dev-nahian-car-checkout-forms">
      <form id="checkoutAuthorizationForm">

        <!-- Module 1: Primary Driver & Credentials -->
        <div class="dev-nahian-car-form-module-card">
          <h2 class="dev-nahian-car-module-title">
            <span class="dev-nahian-car-module-badge-num">1</span>
            Primary Driver &amp; Credentials
          </h2>
          <p class="dev-nahian-car-module-subtitle">Driver must be 21+ with a valid license held for at least one year.</p>

          <div class="dev-nahian-car-form-grid">
            <div class="dev-nahian-car-form-group">
              <label for="driverFirstName">First Name</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="driverFirstName" value="Alexander" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="driverLastName">Last Name</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="driverLastName" value="Vance" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="driverEmail">Email Address (Key Pass Delivery)</label>
              <div class="dev-nahian-car-input-shell">
                <input type="email" class="dev-nahian-car-input-control" id="driverEmail" value="vance@familyoffice.com" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="driverPhone">Mobile Phone (SMS Protocol)</label>
              <div class="dev-nahian-car-input-shell">
                <input type="tel" class="dev-nahian-car-input-control" id="driverPhone" value="+1 (555) 382-9901" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="driverLicenseNumber">Driver's License Number</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="driverLicenseNumber" placeholder="DL-XXXX-XXXX-XX" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="driverLicenseCountry">Country / Jurisdiction</label>
              <div class="dev-nahian-car-input-shell">
                <select class="dev-nahian-car-input-control" id="driverLicenseCountry">
                  <option>United States (All 50 States)</option>
                  <option>United Kingdom (DVLA)</option>
                  <option>European Union</option>
                  <option>Switzerland</option>
                  <option>Canada</option>
                  <option>United Arab Emirates</option>
                </select>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1 4-10z"></path></svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Module 2: Airside & FBO Staging Parameters -->
        <div class="dev-nahian-car-form-module-card">
          <h2 class="dev-nahian-car-module-title">
            <span class="dev-nahian-car-module-badge-num">2</span>
            FBO Airside Staging Parameters
          </h2>
          <p class="dev-nahian-car-module-subtitle">Provide flight details for ramp delivery or select private terminal valet.</p>

          <div class="dev-nahian-car-form-grid">
            <div class="dev-nahian-car-form-group">
              <label for="fboLocation">Pick-Up Terminal / Hangar</label>
              <div class="dev-nahian-car-input-shell">
                <select class="dev-nahian-car-input-control" id="fboLocation">
                  <option>JFK Signature Aviation FBO (Bay 04)</option>
                  <option>Manhattan Midtown Executive Pad (Lexington)</option>
                  <option>Silicon Valley Atlantic Aviation (SJC)</option>
                  <option>Miami Opa-Locka Executive Hub (OPF)</option>
                </select>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="flightTailNumber">Flight Tail / Number (Optional)</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="flightTailNumber" placeholder="e.g. N782VX or BA178">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
              <label for="customDeliveryNotes">Handover Logistics &amp; Coordinator Notes</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="customDeliveryNotes" placeholder="e.g. Pre-cool cabin to 68°F; luggage transfer required.">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Module 3: Payment Method -->
        <div class="dev-nahian-car-form-module-card">
          <h2 class="dev-nahian-car-module-title">
            <span class="dev-nahian-car-module-badge-num">3</span>
            Select Payment Method
          </h2>
          <p class="dev-nahian-car-module-subtitle">Zero deposit hold for pre-verified members. Choose your preferred billing rail.</p>

          <div class="dev-nahian-car-payment-method-selector">
            <label class="dev-nahian-car-payment-option-label active">
              <input type="radio" name="paymentOption" value="card" checked>
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
              <span>Credit / Debit Card</span>
            </label>

            <label class="dev-nahian-car-payment-option-label">
              <input type="radio" name="paymentOption" value="wallet">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20.94c1.5 0 2.75 1.06 4 1.06 1.22 0 2.38-1.06 3.88-1.06 1.44 0 2.5 1.06 3.62 1.06-2.5-3-2.5-6.5 0-9.5-1.5 0-3 1-4.5 1-1.5 0-2.5-1-4-1-2.22 0-4.5 2-4.5 6 0 4.5 2.5 8.5 5.5 8.5z"></path></svg>
              <span>Apple / Google Pay</span>
            </label>

            <label class="dev-nahian-car-payment-option-label">
              <input type="radio" name="paymentOption" value="corporate">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
              <span>Corporate Account</span>
            </label>
          </div>

          <!-- Card Input Fields -->
          <div class="dev-nahian-car-form-grid" id="cardInputsContainer">
            <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
              <label for="cardNumber">Card Number</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="cardNumber" placeholder="4532 8821 9902 8821" maxlength="19" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="cardExpiry">Expiration (MM/YY)</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="cardExpiry" placeholder="08/28" maxlength="5" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
            </div>

            <div class="dev-nahian-car-form-group">
              <label for="cardCvc">CVC / Security Code</label>
              <div class="dev-nahian-car-input-shell">
                <input type="text" class="dev-nahian-car-input-control" id="cardCvc" placeholder="CVC" maxlength="4" required>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              </div>
            </div>
          </div>

          <!-- Non-Card Notice -->
          <div id="altPaymentNotice" style="display: none; padding: 14px 16px; background: var(--dev-nahian-car-bg-light); border: 1px solid var(--dev-nahian-car-border); border-radius: var(--dev-nahian-car-radius-sm); font-size: 0.85rem; color: var(--dev-nahian-car-text-muted); line-height: 1.5;">
            Device or enterprise credentials will be authenticated instantly when you authorize dispatch below.
          </div>

          <div class="dev-nahian-car-security-notice-pill">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Payments encrypted via bank-grade PCI-DSS Level 1 protocol. Instant cancellation free within 24 hours.</span>
          </div>
        </div>

        <button type="submit" class="dev-nahian-car-btn-authorize" id="checkoutSubmitBtn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          Authorize Reservation &amp; Issue NFC Pass ($567.00)
        </button>
      </form>

      <!-- Inline Confirmation -->
      <div class="dev-nahian-car-checkout-success-banner" id="checkoutSuccess" role="alert" aria-live="polite">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin: 0 auto 6px; display: block;"><polyline points="20 6 9 17 4 12"></polyline></svg>
        <div style="font-size: 1.05rem;">Reservation #VEL-992-AUTH Confirmed</div>
        <div style="font-size: 0.8rem; font-weight: 500; color: #1e293b; margin-top: 4px;">
          Digital NFC Smartphone Pass has been transmitted to your email and Apple/Google Wallet. Your chassis is pre-allocated and verified.
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN: BOARDING PASS MANIFEST -->
    <div class="dev-nahian-car-checkout-summary">
      <aside class="dev-nahian-car-itinerary-card" aria-label="Dispatch Summary">
        <div class="dev-nahian-car-itinerary-header">
          <h3>Dispatch Manifest</h3>
          <span class="dev-nahian-car-manifest-badge">PASS #992-GT3</span>
        </div>

        <!-- Vehicle Summary -->
        <div class="dev-nahian-car-vehicle-mini-summary">
          <div class="dev-nahian-car-mini-thumb-wrap">
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=300&q=80" alt="Veloce GT3 Coupé">
          </div>
          <div class="dev-nahian-car-mini-info">
            <h4>Veloce GT3 Coupé</h4>
            <span>Twin-Turbo Flat-6 &bull; PDK Dual-Clutch</span>
            <div class="dev-nahian-car-mini-vin">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              VIN #VEL-992-GT3G Guaranteed
            </div>
          </div>
        </div>

        <!-- Route Block -->
        <div class="dev-nahian-car-flight-route-block">
          <div class="dev-nahian-car-route-node-row">
            <div class="dev-nahian-car-route-node">
              <strong>JFK</strong>
              <span>Departure Bay</span>
            </div>
            <div class="dev-nahian-car-route-plane-indicator">
              <div class="dev-nahian-car-route-plane-line"></div>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3.5c-.5-.5-2.5 0-4 1.5L13.5 8.5 5.3 6.7c-.8-.2-1.6.2-2 1-.4.8-.1 1.7.5 2.2l4.8 3.6-2.5 2.5-2.3-.5c-.4-.1-.8.1-1.1.4l-.9.9 3.2 1.4 1.4 3.2.9-.9c.3-.3.5-.7.4-1.1l-.5-2.3 2.5-2.5 3.6 4.8c.5.6 1.4.9 2.2.5.8-.4 1.2-1.2 1-2z"></path></svg>
              <div class="dev-nahian-car-route-plane-line"></div>
            </div>
            <div class="dev-nahian-car-route-node" style="text-align: right;">
              <strong>JFK</strong>
              <span>Return Bay</span>
            </div>
          </div>
        </div>

        <!-- Itinerary Parameters -->
        <ul class="dev-nahian-car-itinerary-details-list">
          <li class="dev-nahian-car-itinerary-detail-row">
            <span class="dev-nahian-car-row-label">Handover Window:</span>
            <span class="dev-nahian-car-row-val">Oct 12, 2026 (10:00 AM)</span>
          </li>
          <li class="dev-nahian-car-itinerary-detail-row">
            <span class="dev-nahian-car-row-label">Return Window:</span>
            <span class="dev-nahian-car-row-val">Oct 15, 2026 (10:00 AM)</span>
          </li>
          <li class="dev-nahian-car-itinerary-detail-row">
            <span class="dev-nahian-car-row-label">Journey Duration:</span>
            <span class="dev-nahian-car-row-val">3 Consecutive Days</span>
          </li>
          <li class="dev-nahian-car-itinerary-detail-row">
            <span class="dev-nahian-car-row-label">Digital Key Access:</span>
            <span class="dev-nahian-car-row-val" style="color: var(--dev-nahian-car-accent-green);">Instant NFC Push</span>
          </li>
        </ul>

        <!-- Billing Breakdown -->
        <div class="dev-nahian-car-billing-breakdown">
          <div class="dev-nahian-car-bill-row">
            <span>Daily Rate ($189.00 &times; 3 Days):</span>
            <strong style="color: var(--dev-nahian-car-text-dark);">$567.00</strong>
          </div>
          <div class="dev-nahian-car-bill-row">
            <span>FBO Airside Staging Fee:</span>
            <span style="color: var(--dev-nahian-car-accent-green); font-weight: 700;">$0.00 (Waived)</span>
          </div>
          <div class="dev-nahian-car-bill-row">
            <span>Zero-Excess Comprehensive Protection:</span>
            <span style="color: var(--dev-nahian-car-accent-green); font-weight: 700;">$0.00 (Included)</span>
          </div>
          <div class="dev-nahian-car-bill-row">
            <span>Security Deposit Hold:</span>
            <span style="color: var(--dev-nahian-car-text-dark); font-weight: 700;">$0.00 (Pre-Verified)</span>
          </div>
          <div class="dev-nahian-car-bill-row total-row">
            <span>Total Estimated:</span>
            <span class="dev-nahian-car-bill-total-fig">$567.00</span>
          </div>
        </div>

        <div class="dev-nahian-car-terms-note">
          &bull; Smartphone NFC Bluetooth unlock enabled immediately upon completion.<br>
          &bull; Free cancellation up to 24 hours prior to scheduled departure window.
        </div>
      </aside>
    </div>

  </div>
</div>

<!-- Internal Checkout JavaScript Architecture -->
<script id="dev-nahian-checkout-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const paymentLabels = document.querySelectorAll('.dev-nahian-car-payment-option-label');
      const cardInputs = document.getElementById('cardInputsContainer');
      const altNotice = document.getElementById('altPaymentNotice');
      const cardNum = document.getElementById('cardNumber');
      const cardExp = document.getElementById('cardExpiry');
      const cardCvc = document.getElementById('cardCvc');
      const form = document.getElementById('checkoutAuthorizationForm');
      const successBanner = document.getElementById('checkoutSuccess');

      // 1. Payment Method Switching
      paymentLabels.forEach(function(label) {
        label.addEventListener('click', function() {
          paymentLabels.forEach(function(l) { l.classList.remove('active'); });
          label.classList.add('active');

          const radio = label.querySelector('input[type="radio"]');
          if (radio) {
            radio.checked = true;
            const isCard = radio.value === 'card';

            if (cardInputs && altNotice) {
              cardInputs.style.display = isCard ? 'grid' : 'none';
              altNotice.style.display = isCard ? 'none' : 'block';
            }

            if (cardNum && cardExp && cardCvc) {
              cardNum.required = isCard;
              cardExp.required = isCard;
              cardCvc.required = isCard;
            }
          }
        });
      });

      // 2. Card Number Formatting (Groups of 4)
      if (cardNum) {
        cardNum.addEventListener('input', function(e) {
          const raw = e.target.value.replace(/\D/g, '').substring(0, 16);
          const groups = raw.match(/.{1,4}/g);
          e.target.value = groups ? groups.join(' ') : '';
        });
      }

      // 3. Card Expiry Formatting (MM/YY)
      if (cardExp) {
        cardExp.addEventListener('input', function(e) {
          let val = e.target.value.replace(/\D/g, '').substring(0, 4);
          if (val.length >= 2) {
            val = val.substring(0, 2) + '/' + val.substring(2);
          }
          e.target.value = val;
        });
      }

      // 4. Form Submit Authorization Handler
      if (form && successBanner) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          successBanner.classList.add('show');
          successBanner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
      }
    });
  })();
</script>

<?php get_footer(); ?>