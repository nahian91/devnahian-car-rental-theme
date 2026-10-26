<?php
/**
 * Template Name: Template Authentication
 * Description: Secure client login and membership registration gateway template with encrypted NFC portal access.
 */

get_header(); 
?>

<!-- Internal Authentication CSS Architecture -->
<style id="dev-nahian-auth-styles">
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
  }

  .dev-nahian-car-auth-wrapper {
    padding: 64px 20px 88px;
    max-width: 1260px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  /* Centered Header with Pill Badge */
  .dev-nahian-car-auth-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 36px;
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

  .dev-nahian-car-auth-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 10px;
  }

  .dev-nahian-car-auth-header h1 span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-auth-header p {
    color: var(--dev-nahian-car-text-muted);
    font-size: 1.05rem;
    line-height: 1.5;
    margin: 0;
  }

  /* Auth Card Container */
  .dev-nahian-car-auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .dev-nahian-car-auth-card {
    width: 100%;
    max-width: 500px;
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-lg);
    box-shadow: 0 12px 36px -8px rgba(15, 23, 42, 0.08);
    padding: clamp(28px, 4.5vw, 40px);
  }

  /* Tab Switcher */
  .dev-nahian-car-auth-tab-switch {
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 4px;
    margin-bottom: 28px;
    gap: 4px;
  }

  .dev-nahian-car-auth-tab-btn {
    background: transparent;
    border: none;
    padding: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-muted);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-auth-tab-btn.active {
    background: #ffffff;
    color: var(--dev-nahian-car-text-dark);
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
  }

  /* Form Panes */
  .dev-nahian-car-auth-form-pane {
    display: none;
    flex-direction: column;
    gap: 18px;
  }

  .dev-nahian-car-auth-form-pane.active {
    display: flex;
  }

  .dev-nahian-car-pane-heading h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.02em;
    margin: 0 0 4px;
  }

  .dev-nahian-car-pane-heading p {
    font-size: 0.88rem;
    color: var(--dev-nahian-car-text-muted);
    margin: 0;
    line-height: 1.5;
  }

  .dev-nahian-car-form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
  }

  @media (min-width: 480px) {
    .dev-nahian-car-form-grid.dev-nahian-car-two-col {
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
  }

  .dev-nahian-car-input-shell {
    position: relative;
    display: flex;
    align-items: center;
  }

  .dev-nahian-car-input-shell svg.dev-nahian-car-input-icon-lead {
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

  .dev-nahian-car-input-control.dev-nahian-car-has-toggle {
    padding-right: 42px;
  }

  .dev-nahian-car-input-control:focus {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
  }

  .dev-nahian-car-input-control:focus ~ svg.dev-nahian-car-input-icon-lead {
    color: var(--dev-nahian-car-primary);
  }

  /* Password Toggle Button */
  .dev-nahian-car-pwd-toggle-btn {
    position: absolute;
    right: 12px;
    background: transparent;
    border: none;
    color: var(--dev-nahian-car-text-muted);
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
  }

  .dev-nahian-car-pwd-toggle-btn:hover {
    color: var(--dev-nahian-car-text-dark);
  }

  /* Utilities */
  .dev-nahian-car-form-row-utility {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    margin-top: -4px;
  }

  .dev-nahian-car-form-checkbox-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--dev-nahian-car-text-muted);
    cursor: pointer;
    user-select: none;
  }

  .dev-nahian-car-form-checkbox-label input {
    accent-color: var(--dev-nahian-car-primary);
    width: 15px;
    height: 15px;
    cursor: pointer;
  }

  .dev-nahian-car-utility-link {
    color: var(--dev-nahian-car-gold);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
  }

  .dev-nahian-car-utility-link:hover {
    color: var(--dev-nahian-car-gold-hover);
    text-decoration: underline;
  }

  /* Buttons */
  .dev-nahian-car-btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 48px;
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border: none;
    border-radius: var(--dev-nahian-car-radius-sm);
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
  }

  .dev-nahian-car-btn-submit:hover {
    background: var(--dev-nahian-car-primary-hover);
    transform: translateY(-1px);
  }

  .dev-nahian-car-btn-submit.dev-nahian-car-btn-gold {
    background: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-btn-submit.dev-nahian-car-btn-gold:hover {
    background: var(--dev-nahian-car-gold-hover);
  }

  /* Inline Feedback Alert */
  .dev-nahian-car-auth-alert-banner {
    display: none;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--dev-nahian-car-radius-sm);
    background: var(--dev-nahian-car-accent-green-bg);
    border: 1px solid rgba(13, 148, 136, 0.3);
    color: var(--dev-nahian-car-accent-green);
    font-size: 0.85rem;
    font-weight: 700;
    line-height: 1.4;
    margin-top: 12px;
  }

  .dev-nahian-car-auth-alert-banner.show {
    display: flex;
  }

  .dev-nahian-car-auth-alert-banner svg {
    flex-shrink: 0;
  }
</style>

<div class="dev-nahian-car-auth-wrapper">
  <!-- Header -->
  <div class="dev-nahian-car-auth-header">
    <div class="dev-nahian-car-section-badge">
      <span class="dev-nahian-car-badge-pulse"></span>
      Client Security &bull; Biometric Access
    </div>
    <h1>Member <span>Gateway</span></h1>
    <p>Manage encrypted NFC key passes, access fleet telemetry, and review reserved itineraries.</p>
  </div>

  <!-- Auth Card -->
  <div class="dev-nahian-car-auth-container">
    <div class="dev-nahian-car-auth-card">
      
      <!-- Tab Switcher -->
      <div class="dev-nahian-car-auth-tab-switch" role="tablist">
        <button class="dev-nahian-car-auth-tab-btn active" id="tabLoginBtn" type="button" role="tab" aria-selected="true" aria-controls="loginFormPane">Client Login</button>
        <button class="dev-nahian-car-auth-tab-btn" id="tabRegBtn" type="button" role="tab" aria-selected="false" aria-controls="regFormPane">New Membership</button>
      </div>

      <!-- =========================================================
            LOGIN FORM PANE
      ========================================================= -->
      <form class="dev-nahian-car-auth-form-pane active" id="loginFormPane" role="tabpanel" aria-labelledby="tabLoginBtn">
        <div class="dev-nahian-car-pane-heading">
          <h2>Welcome Back</h2>
          <p>Access your encrypted NFC keys, reservations, and vehicle dossier.</p>
        </div>

        <div class="dev-nahian-car-form-grid">
          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
            <label for="loginEmail">Email Address</label>
            <div class="dev-nahian-car-input-shell">
              <input type="email" class="dev-nahian-car-input-control" id="loginEmail" placeholder="vance@familyoffice.com" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
            <label for="loginPassword">Password / Biometric PIN</label>
            <div class="dev-nahian-car-input-shell">
              <input type="password" class="dev-nahian-car-input-control dev-nahian-car-has-toggle" id="loginPassword" placeholder="••••••••••••" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              <button type="button" class="dev-nahian-car-pwd-toggle-btn" data-target="loginPassword" aria-label="Toggle password visibility">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
          </div>

          <div class="dev-nahian-car-col-span-full dev-nahian-car-form-row-utility">
            <label class="dev-nahian-car-form-checkbox-label">
              <input type="checkbox" id="rememberMe">
              <span>Remember device</span>
            </label>
            <a href="#" class="dev-nahian-car-utility-link" id="btnForgotPin">Forgot PIN?</a>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full" style="margin-top: 4px;">
            <button type="submit" class="dev-nahian-car-btn-submit">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              Authenticate &amp; Access Portal
            </button>
          </div>
        </div>

        <div class="dev-nahian-car-auth-alert-banner" id="loginAlert" role="alert" aria-live="polite">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Authentication successful. Opening your client console...</span>
        </div>
      </form>

      <!-- =========================================================
            REGISTRATION FORM PANE
      ========================================================= -->
      <form class="dev-nahian-car-auth-form-pane" id="regFormPane" role="tabpanel" aria-labelledby="tabRegBtn">
        <div class="dev-nahian-car-pane-heading">
          <h2>Apply for Membership</h2>
          <p>Join the Sovereign Tier for instant chassis allocation and zero deposit holds.</p>
        </div>

        <div class="dev-nahian-car-form-grid dev-nahian-car-two-col">
          <div class="dev-nahian-car-form-group">
            <label for="regFirstName">First Name</label>
            <div class="dev-nahian-car-input-shell">
              <input type="text" class="dev-nahian-car-input-control" id="regFirstName" placeholder="Alexander" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="regLastName">Last Name</label>
            <div class="dev-nahian-car-input-shell">
              <input type="text" class="dev-nahian-car-input-control" id="regLastName" placeholder="Vance" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
            <label for="regEmail">Official Email</label>
            <div class="dev-nahian-car-input-shell">
              <input type="email" class="dev-nahian-car-input-control" id="regEmail" placeholder="vance@familyoffice.com" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
            <label for="regPhone">Mobile Phone</label>
            <div class="dev-nahian-car-input-shell">
              <input type="tel" class="dev-nahian-car-input-control" id="regPhone" placeholder="+1 (555) 000-0000" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full">
            <label for="regPassword">Create Master Password</label>
            <div class="dev-nahian-car-input-shell">
              <input type="password" class="dev-nahian-car-input-control dev-nahian-car-has-toggle" id="regPassword" placeholder="Minimum 8 characters" required>
              <svg class="dev-nahian-car-input-icon-lead" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              <button type="button" class="dev-nahian-car-pwd-toggle-btn" data-target="regPassword" aria-label="Toggle password visibility">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
          </div>

          <div class="dev-nahian-car-col-span-full dev-nahian-car-form-row-utility">
            <label class="dev-nahian-car-form-checkbox-label">
              <input type="checkbox" id="acceptTerms" required>
              <span>Accept Sovereign charter &amp; biometric telemetry terms</span>
            </label>
          </div>

          <div class="dev-nahian-car-form-group dev-nahian-car-col-span-full" style="margin-top: 4px;">
            <button type="submit" class="dev-nahian-car-btn-submit dev-nahian-car-btn-gold">
              Submit Membership Application
            </button>
          </div>
        </div>

        <div class="dev-nahian-car-auth-alert-banner" id="regAlert" role="alert" aria-live="polite">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>Application logged. Verification token dispatched to your email address.</span>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Internal Authentication JavaScript Architecture -->
<script id="dev-nahian-auth-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      // 1. Interactive Tabs
      const tabLoginBtn   = document.getElementById('tabLoginBtn');
      const tabRegBtn     = document.getElementById('tabRegBtn');
      const loginFormPane = document.getElementById('loginFormPane');
      const regFormPane   = document.getElementById('regFormPane');

      if (tabLoginBtn && tabRegBtn && loginFormPane && regFormPane) {
        tabLoginBtn.addEventListener('click', function() {
          tabLoginBtn.classList.add('active');
          tabLoginBtn.setAttribute('aria-selected', 'true');
          tabRegBtn.classList.remove('active');
          tabRegBtn.setAttribute('aria-selected', 'false');

          loginFormPane.classList.add('active');
          regFormPane.classList.remove('active');
        });

        tabRegBtn.addEventListener('click', function() {
          tabRegBtn.classList.add('active');
          tabRegBtn.setAttribute('aria-selected', 'true');
          tabLoginBtn.classList.remove('active');
          tabLoginBtn.setAttribute('aria-selected', 'false');

          regFormPane.classList.add('active');
          loginFormPane.classList.remove('active');
        });
      }

      // 2. Password Visibility Toggle
      const pwdToggleBtns = document.querySelectorAll('.dev-nahian-car-pwd-toggle-btn');
      pwdToggleBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
          const targetInput = document.getElementById(btn.getAttribute('data-target'));
          if (!targetInput) return;
          const isPassword = targetInput.type === 'password';
          targetInput.type = isPassword ? 'text' : 'password';

          btn.innerHTML = isPassword
            ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>'
            : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        });
      });

      // 3. Forgot PIN Link Handler
      const forgotPinLink = document.getElementById('btnForgotPin');
      if (forgotPinLink) {
        forgotPinLink.addEventListener('click', function(e) {
          e.preventDefault();
          alert('Password reset instructions dispatched to your verified email.');
        });
      }

      // 4. Form Submission Handlers
      if (loginFormPane) {
        loginFormPane.addEventListener('submit', function(e) {
          e.preventDefault();
          const alertBox = document.getElementById('loginAlert');
          if (alertBox) alertBox.classList.add('show');
          setTimeout(function() {
            window.location.href = <?php echo wp_json_encode( esc_url( home_url( '/cars/' ) ) ); ?>;
          }, 1500);
        });
      }

      if (regFormPane) {
        regFormPane.addEventListener('submit', function(e) {
          e.preventDefault();
          const alertBox = document.getElementById('regAlert');
          if (alertBox) alertBox.classList.add('show');
          e.target.reset();
          setTimeout(function() {
            if (alertBox) alertBox.classList.remove('show');
            if (tabLoginBtn) tabLoginBtn.click();
          }, 3500);
        });
      }
    });
  })();
</script>

<?php get_footer(); ?>