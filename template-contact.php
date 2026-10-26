<?php
/**
 * Template Name: Contact Us
 * Description: Dynamic contact page pulling directly from Contact Tab settings with zero hardcoded defaults.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since 1.0.0
 */

// 1. Handle Form Submission
$form_status  = '';
$form_message = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['dn_contact_submit'] ) ) {
    if ( ! isset( $_POST['dn_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dn_contact_nonce'] ) ), 'dn_contact_form_action' ) ) {
        $form_status  = 'error';
        $form_message = __( 'Security check failed. Please refresh and try again.', 'dev-nahian-car' );
    } else {
        $name    = sanitize_text_field( $_POST['dn_name'] ?? '' );
        $email   = sanitize_email( $_POST['dn_email'] ?? '' );
        $phone   = sanitize_text_field( $_POST['dn_phone'] ?? '' );
        $subject = sanitize_text_field( $_POST['dn_service'] ?? '' );
        $msg     = sanitize_textarea_field( $_POST['dn_message'] ?? '' );

        if ( empty( $name ) || empty( $email ) || empty( $msg ) ) {
            $form_status  = 'error';
            $form_message = __( 'Please fill in all required fields.', 'dev-nahian-car' );
        } else {
            // Recipient set from Contact Tab form settings (fallback to admin_email)
            $recipient = get_option( 'dev_nahian_contact_recipient', '' );
            if ( empty( $recipient ) ) {
                $recipient = get_option( 'admin_email' );
            }

            $mail_subject = sprintf( '[%s] %s - %s', get_bloginfo( 'name' ), ( $subject ? $subject : __( 'Contact Inquiry', 'dev-nahian-car' ) ), $name );
            $mail_body    = "Name: {$name}\n";
            $mail_body   .= "Email: {$email}\n";
            $mail_body   .= "Phone: {$phone}\n";
            $mail_body   .= "Subject: {$subject}\n\n";
            $mail_body   .= "Message:\n{$msg}\n\n";
            $mail_body   .= "Sent from: " . home_url( $_SERVER['REQUEST_URI'] ?? '' );

            $headers = array(
                'Content-Type: text/plain; charset=UTF-8',
                'Reply-To: ' . $name . ' <' . $email . '>',
            );

            if ( wp_mail( $recipient, $mail_subject, $mail_body, $headers ) ) {
                $form_status  = 'success';
                $form_message = __( 'Your message has been sent successfully. We will get back to you shortly.', 'dev-nahian-car' );
            } else {
                $form_status  = 'error';
                $form_message = __( 'Failed to send your message. Please try again later.', 'dev-nahian-car' );
            }
        }
    }
}

get_header(); 

// 2. Fetch Options from Contact Sub-Tab (Zero hardcoded text fallbacks)
$badge        = get_option( 'dev_nahian_contact_badge', '' );
$title        = get_option( 'dev_nahian_contact_title', '' );
$desc         = get_option( 'dev_nahian_contact_desc', '' );

$phone        = get_option( 'dev_nahian_contact_phone', '' );
$email        = get_option( 'dev_nahian_contact_email', '' );
$address      = get_option( 'dev_nahian_contact_address', '' );
$hours        = get_option( 'dev_nahian_contact_hours', '' );
$map_embed    = get_option( 'dev_nahian_contact_map_embed', '' );

$form_heading = get_option( 'dev_nahian_contact_form_heading', '' );
$form_sub     = get_option( 'dev_nahian_contact_form_sub', '' );

$clean_phone  = preg_replace( '/[^\d+]/', '', $phone );
$has_channels = ! empty( $phone ) || ! empty( $email ) || ! empty( $address ) || ! empty( $hours ) || ! empty( $map_embed );
?>

<style id="dev-nahian-contact-styles">
  :root {
    --dn-cnt-primary: var(--dev-nahian-car-primary, #111827);
    --dn-cnt-primary-hover: var(--dev-nahian-car-primary-hover, #1f2937);
    --dn-cnt-gold: var(--dev-nahian-car-gold, #b88e1e);
    --dn-cnt-gold-glow: rgba(184, 142, 30, 0.12);
    --dn-cnt-gold-border: rgba(184, 142, 30, 0.3);
    --dn-cnt-text-dark: var(--dev-nahian-car-text-dark, #0f172a);
    --dn-cnt-text-muted: var(--dev-nahian-car-text-muted, #64748b);
    --dn-cnt-border: var(--dev-nahian-car-border, #e2e8f0);
    --dn-cnt-bg-light: var(--dev-nahian-car-bg-light, #f8fafc);
    --dn-cnt-radius: var(--dev-nahian-car-radius, 12px);
    --dn-cnt-radius-sm: 8px;
  }

  .dev-nahian-car-contact-wrap {
    padding: 64px 20px 96px;
    max-width: 1240px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--dn-cnt-text-dark);
  }

  /* Header */
  .dev-nahian-car-contact-header {
    text-align: center;
    max-width: 720px;
    margin: 0 auto 56px;
  }

  .dev-nahian-car-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--dn-cnt-gold);
    background: var(--dn-cnt-gold-glow);
    border: 1px solid var(--dn-cnt-gold-border);
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 16px;
  }

  .dev-nahian-car-contact-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.85rem);
    font-weight: 800;
    color: var(--dn-cnt-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin: 0 0 14px;
  }

  .dev-nahian-car-contact-header h1 span {
    color: var(--dn-cnt-gold);
  }

  .dev-nahian-car-contact-header p {
    color: var(--dn-cnt-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
  }

  /* Layout */
  .dev-nahian-car-contact-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-contact-grid {
      grid-template-columns: <?php echo $has_channels ? '1.05fr 0.95fr' : '1fr'; ?>;
      gap: 48px;
      align-items: start;
    }
  }

  /* Form */
  .dev-nahian-car-form-card {
    background: #ffffff;
    border: 1px solid var(--dn-cnt-border);
    border-radius: var(--dn-cnt-radius);
    padding: 36px 32px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-form-card h2 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dn-cnt-text-dark);
    margin: 0 0 6px;
  }

  .dev-nahian-car-form-card p {
    font-size: 0.92rem;
    color: var(--dn-cnt-text-muted);
    margin: 0 0 26px;
  }

  .dev-nahian-car-form-group {
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .dev-nahian-car-form-group label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--dn-cnt-text-dark);
  }

  .dev-nahian-car-form-input,
  .dev-nahian-car-form-select,
  .dev-nahian-car-form-textarea {
    width: 100%;
    height: 46px;
    border: 1px solid var(--dn-cnt-border);
    border-radius: var(--dn-cnt-radius-sm);
    padding: 0 14px;
    font-size: 0.92rem;
    color: var(--dn-cnt-text-dark);
    background: var(--dn-cnt-bg-light);
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-form-textarea {
    height: 110px;
    padding: 12px 14px;
    resize: vertical;
  }

  .dev-nahian-car-form-input:focus,
  .dev-nahian-car-form-select:focus,
  .dev-nahian-car-form-textarea:focus {
    border-color: var(--dn-cnt-primary);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.08);
  }

  .dev-nahian-car-form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 600px) {
    .dev-nahian-car-form-row {
      grid-template-columns: 1fr 1fr;
    }
  }

  .dev-nahian-car-btn-submit {
    width: 100%;
    height: 48px;
    background: var(--dn-cnt-primary);
    color: #ffffff;
    border: 1px solid var(--dn-cnt-primary);
    border-radius: var(--dn-cnt-radius-sm);
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .dev-nahian-car-btn-submit:hover {
    background: var(--dn-cnt-primary-hover);
    transform: translateY(-1px);
  }

  .dev-nahian-car-btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
  }

  /* Channels Sidebar */
  .dev-nahian-car-info-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .dev-nahian-car-channel-card {
    background: #ffffff;
    border: 1px solid var(--dn-cnt-border);
    border-radius: var(--dn-cnt-radius);
    padding: 24px;
    display: flex;
    align-items: flex-start;
    gap: 18px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-channel-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    background: var(--dn-cnt-gold-glow);
    border: 1px solid var(--dn-cnt-gold-border);
    color: var(--dn-cnt-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .dev-nahian-car-channel-content h3 {
    font-size: 0.98rem;
    font-weight: 800;
    color: var(--dn-cnt-text-dark);
    margin: 0 0 4px;
  }

  .dev-nahian-car-channel-content p,
  .dev-nahian-car-channel-content a {
    font-size: 0.92rem;
    color: var(--dn-cnt-text-muted);
    line-height: 1.5;
    margin: 0;
    text-decoration: none;
    word-break: break-word;
  }

  .dev-nahian-car-channel-content a:hover {
    color: var(--dn-cnt-gold);
  }

  .dev-nahian-car-map-shell {
    background: #ffffff;
    border: 1px solid var(--dn-cnt-border);
    border-radius: var(--dn-cnt-radius);
    overflow: hidden;
    height: 250px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-map-shell iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
  }

  .dev-nahian-car-alert {
    padding: 14px 18px;
    border-radius: var(--dn-cnt-radius-sm);
    font-size: 0.92rem;
    font-weight: 600;
    margin-bottom: 22px;
  }

  .dev-nahian-car-alert.success {
    background: #f0fdf4;
    border: 1px solid #86efac;
    color: #166534;
  }

  .dev-nahian-car-alert.error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
  }
</style>

<div class="dev-nahian-car-contact-wrap">
  
  <!-- Header (Rendered only if values exist) -->
  <?php if ( ! empty( $badge ) || ! empty( $title ) || ! empty( $desc ) ) : ?>
    <div class="dev-nahian-car-contact-header">
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

  <div class="dev-nahian-car-contact-grid">
    
    <!-- Left: Form -->
    <div class="dev-nahian-car-form-card">
      <?php if ( ! empty( $form_heading ) ) : ?>
        <h2><?php echo esc_html( $form_heading ); ?></h2>
      <?php endif; ?>

      <?php if ( ! empty( $form_sub ) ) : ?>
        <p><?php echo esc_html( $form_sub ); ?></p>
      <?php endif; ?>

      <?php if ( ! empty( $form_message ) ) : ?>
        <div class="dev-nahian-car-alert <?php echo esc_attr( $form_status ); ?>" id="dnContactAlert" role="alert">
          <?php echo esc_html( $form_message ); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="" id="dnContactForm">
        <?php wp_nonce_field( 'dn_contact_form_action', 'dn_contact_nonce' ); ?>

        <div class="dev-nahian-car-form-row">
          <div class="dev-nahian-car-form-group">
            <label for="dn_name"><?php esc_html_e( 'Name *', 'dev-nahian-car' ); ?></label>
            <input type="text" id="dn_name" name="dn_name" class="dev-nahian-car-form-input" required placeholder="<?php esc_attr_e( 'Your Name', 'dev-nahian-car' ); ?>">
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="dn_email"><?php esc_html_e( 'Email *', 'dev-nahian-car' ); ?></label>
            <input type="email" id="dn_email" name="dn_email" class="dev-nahian-car-form-input" required placeholder="<?php esc_attr_e( 'Your Email', 'dev-nahian-car' ); ?>">
          </div>
        </div>

        <div class="dev-nahian-car-form-row">
          <div class="dev-nahian-car-form-group">
            <label for="dn_phone"><?php esc_html_e( 'Phone', 'dev-nahian-car' ); ?></label>
            <input type="tel" id="dn_phone" name="dn_phone" class="dev-nahian-car-form-input" placeholder="<?php esc_attr_e( 'Your Phone Number', 'dev-nahian-car' ); ?>">
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="dn_service"><?php esc_html_e( 'Subject', 'dev-nahian-car' ); ?></label>
            <input type="text" id="dn_service" name="dn_service" class="dev-nahian-car-form-input" placeholder="<?php esc_attr_e( 'Inquiry Subject', 'dev-nahian-car' ); ?>">
          </div>
        </div>

        <div class="dev-nahian-car-form-group">
          <label for="dn_message"><?php esc_html_e( 'Message *', 'dev-nahian-car' ); ?></label>
          <textarea id="dn_message" name="dn_message" class="dev-nahian-car-form-textarea" required placeholder="<?php esc_attr_e( 'Write your message here...', 'dev-nahian-car' ); ?>"></textarea>
        </div>

        <button type="submit" name="dn_contact_submit" class="dev-nahian-car-btn-submit" id="dnContactSubmitBtn">
          <span><?php esc_html_e( 'Send Message', 'dev-nahian-car' ); ?></span>
        </button>
      </form>
    </div>

    <!-- Right: Channels from Contact Tab -->
    <?php if ( $has_channels ) : ?>
      <div class="dev-nahian-car-info-sidebar">
        
        <!-- Phone -->
        <?php if ( ! empty( $phone ) ) : ?>
          <div class="dev-nahian-car-channel-card">
            <div class="dev-nahian-car-channel-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
            <div class="dev-nahian-car-channel-content">
              <h3><?php esc_html_e( 'Phone', 'dev-nahian-car' ); ?></h3>
              <a href="tel:<?php echo esc_attr( $clean_phone ); ?>"><?php echo esc_html( $phone ); ?></a>
            </div>
          </div>
        <?php endif; ?>

        <!-- Email -->
        <?php if ( ! empty( $email ) ) : ?>
          <div class="dev-nahian-car-channel-card">
            <div class="dev-nahian-car-channel-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
            <div class="dev-nahian-car-channel-content">
              <h3><?php esc_html_e( 'Email', 'dev-nahian-car' ); ?></h3>
              <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
            </div>
          </div>
        <?php endif; ?>

        <!-- Address -->
        <?php if ( ! empty( $address ) ) : ?>
          <div class="dev-nahian-car-channel-card">
            <div class="dev-nahian-car-channel-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <div class="dev-nahian-car-channel-content">
              <h3><?php esc_html_e( 'Address', 'dev-nahian-car' ); ?></h3>
              <p><?php echo nl2br( esc_html( $address ) ); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Hours -->
        <?php if ( ! empty( $hours ) ) : ?>
          <div class="dev-nahian-car-channel-card">
            <div class="dev-nahian-car-channel-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div class="dev-nahian-car-channel-content">
              <h3><?php esc_html_e( 'Opening Hours', 'dev-nahian-car' ); ?></h3>
              <p><?php echo nl2br( esc_html( $hours ) ); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Map Embed -->
        <?php if ( ! empty( $map_embed ) ) : ?>
          <div class="dev-nahian-car-map-shell">
            <?php 
            echo wp_kses( $map_embed, array(
                'iframe' => array(
                    'src'             => array(),
                    'width'           => array(),
                    'height'          => array(),
                    'style'           => array(),
                    'allowfullscreen' => array(),
                    'loading'         => array(),
                    'referrerpolicy'  => array(),
                ),
            ) ); 
            ?>
          </div>
        <?php endif; ?>

      </div>
    <?php endif; ?>

  </div>
</div>

<script id="dev-nahian-contact-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const form       = document.getElementById('dnContactForm');
      const submitBtn  = document.getElementById('dnContactSubmitBtn');
      const phoneInput = document.getElementById('dn_phone');
      const alertBox   = document.getElementById('dnContactAlert');

      if (alertBox) {
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }

      if (form && submitBtn) {
        form.addEventListener('submit', function() {
          submitBtn.disabled = true;
          const textSpan = submitBtn.querySelector('span');
          if (textSpan) {
            textSpan.textContent = '<?php echo esc_js( __( 'Sending...', 'dev-nahian-car' ) ); ?>';
          }
        });
      }

      if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
          e.target.value = e.target.value.replace(/[^\d+()\s-]/g, '');
        });
      }
    });
  })();
</script>

<?php 
get_footer(); 
?>