<?php
/**
 * Template Name: Single Car
 * 
 * Fully dynamic: Pulls exact vehicle records, technical specs, insurance, 
 * and cross-border options from the Dev Nahian Fleet Manager database.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

get_header();

global $wpdb;
$table_cars = $wpdb->prefix . 'dev_nahian_cars';

// Retrieve Car ID from query string or current post context
$car_id = isset( $_GET['car_id'] ) ? absint( $_GET['car_id'] ) : get_queried_object_id();
$car    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_cars} WHERE id = %d", $car_id ), ARRAY_A );

// Fallback if no specific vehicle ID is found
if ( ! $car ) {
    $car = $wpdb->get_row( "SELECT * FROM {$table_cars} ORDER BY id DESC LIMIT 1", ARRAY_A );
}

if ( ! $car ) {
    echo '<div class="dev-nahian-car-container" style="padding: 100px 20px; text-align: center;"><h2>No vehicle assets found in the fleet registry.</h2></div>';
    get_footer();
    exit;
}

$car_id   = absint( $car['id'] );
$meta     = get_option( "dev_nahian_car_meta_{$car_id}", array() );
$currency = get_option( 'dev_nahian_currency', 'USD' );

$car_name     = $car['name'] ?? 'Veloce Prestige Vehicle';
$car_brand    = $car['brand'] ?? 'Veloce';
$car_year     = $car['year'] ?? 2026;
$car_vin      = $car['vin'] ?? 'N/A';
$car_plate    = $car['plate'] ?? 'N/A';
$car_price    = floatval( $car['price'] ?? 189.00 );
$car_deposit  = floatval( $car['deposit'] ?? 500.00 );
$car_img      = ! empty( $car['image'] ) ? $car['image'] : 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80';
$car_notes    = $car['notes'] ?? '';
$car_location = $car['location'] ?? 'JFK Aviation Bay 04';
$horsepower   = $car['horsepower'] ?? 443;
$acceleration = $car['acceleration'] ?? '3.4s';
$top_speed    = $car['speed'] ?? '318 km/h';
$drivetrain   = $car['drivetrain'] ?? 'AWD';

$specs      = $meta['technical_specs'] ?? array();
$amenities  = $meta['amenities'] ?? array();
$insurances = $meta['insurance'] ?? array();
$borders    = $meta['border_crossing'] ?? array();
$gallery    = $meta['gallery_images'] ?? array();
$video_url  = $meta['video_url'] ?? '';

// Fallback gallery images if none uploaded
if ( empty( $gallery ) ) {
    $gallery = array(
        $car_img,
        'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=1200&q=80',
    );
}
?>

<!-- Internal Vehicle Single CSS Architecture -->
<style id="dev-nahian-car-detail-styles">
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

  .dev-nahian-car-detail-wrapper {
    padding: 64px 20px 88px;
    max-width: 1280px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  .dev-nahian-car-detail-header {
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

  .dev-nahian-car-detail-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 10px;
  }

  .dev-nahian-car-detail-header h1 span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-detail-header p {
    color: var(--dev-nahian-car-text-muted);
    font-size: 1.05rem;
    line-height: 1.5;
    margin: 0;
  }

  .dev-nahian-car-detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 36px;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-detail-grid {
      grid-template-columns: 1.25fr 0.75fr;
      gap: 40px;
      align-items: start;
    }
  }

  .dev-nahian-car-card-surface {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: 24px;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
  }

  .dev-nahian-car-gallery-stage {
    padding: 16px;
  }

  .dev-nahian-car-gallery-viewport {
    position: relative;
    width: 100%;
    height: clamp(280px, 36vw, 440px);
    border-radius: var(--dev-nahian-car-radius-sm);
    overflow: hidden;
    background: #0f172a;
  }

  .dev-nahian-car-gallery-viewport img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    cursor: zoom-in;
    transition: opacity 0.2s ease;
  }

  .dev-nahian-car-gallery-floating-pill {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .dev-nahian-car-gallery-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
  }

  .dev-nahian-car-gallery-btn {
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    color: var(--dev-nahian-car-text-muted);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 999px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-gallery-btn:hover {
    color: var(--dev-nahian-car-text-dark);
    background: #ffffff;
    border-color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-gallery-thumbs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 12px;
  }

  .dev-nahian-car-thumb-item {
    height: 72px;
    border-radius: var(--dev-nahian-car-radius-sm);
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    opacity: 0.6;
    background: #0f172a;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-thumb-item.active,
  .dev-nahian-car-thumb-item:hover {
    opacity: 1;
    border-color: var(--dev-nahian-car-primary);
  }

  .dev-nahian-car-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .dev-nahian-car-features-quad {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 24px;
  }

  @media (min-width: 600px) {
    .dev-nahian-car-features-quad {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .dev-nahian-car-quad-item {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
  }

  .dev-nahian-car-quad-item span {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--dev-nahian-car-text-muted);
    letter-spacing: 0.05em;
    display: block;
    margin-bottom: 4px;
  }

  .dev-nahian-car-quad-item strong {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    display: block;
  }

  .dev-nahian-car-telemetry-card h3 {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 6px;
  }

  .dev-nahian-car-telemetry-card p {
    font-size: 0.9rem;
    color: var(--dev-nahian-car-text-muted);
    margin: 0 0 18px;
  }

  .dev-nahian-car-telemetry-matrix {
    display: grid;
    grid-template-columns: 1fr;
    gap: 8px;
  }

  @media (min-width: 600px) {
    .dev-nahian-car-telemetry-matrix {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .dev-nahian-car-telemetry-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    background: var(--dev-nahian-car-bg-light);
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-telemetry-row .dev-nahian-car-spec-name {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-telemetry-row .dev-nahian-car-spec-val {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
  }

  /* Separate Add-ons Card Styling */
  .dev-nahian-car-addons-card {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: 24px;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
  }

  .dev-nahian-car-addons-card h3 {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 6px;
  }

  .dev-nahian-car-addons-card p {
    font-size: 0.9rem;
    color: var(--dev-nahian-car-text-muted);
    margin: 0 0 18px;
  }

  .dev-nahian-car-addons-stack {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .dev-nahian-car-addon-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    background: var(--dev-nahian-car-bg-light);
    cursor: pointer;
    user-select: none;
    transition: border-color 0.15s, background 0.15s;
  }

  .dev-nahian-car-addon-box:hover {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
  }

  .dev-nahian-car-addon-box input {
    accent-color: var(--dev-nahian-car-primary);
    width: 16px;
    height: 16px;
    margin-right: 12px;
    cursor: pointer;
  }

  .dev-nahian-car-addon-info strong {
    font-size: 0.86rem;
    color: var(--dev-nahian-car-text-dark);
    display: block;
  }

  .dev-nahian-car-addon-info span {
    font-size: 0.75rem;
    color: var(--dev-nahian-car-text-muted);
    display: block;
  }

  .dev-nahian-car-addon-price {
    font-size: 0.88rem;
    font-weight: 800;
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-privileges-card h3 {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 16px;
  }

  .dev-nahian-car-privilege-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .dev-nahian-car-privilege-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 0.92rem;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1.5;
  }

  .dev-nahian-car-privilege-item svg {
    color: var(--dev-nahian-car-accent-green);
    margin-top: 3px;
    flex-shrink: 0;
  }

  .dev-nahian-car-dispatch-terminal {
    position: sticky;
    top: 96px;
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: 24px 20px;
    box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
  }

  .dev-nahian-car-terminal-top {
    padding-bottom: 14px;
    margin-bottom: 18px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-terminal-top h3 {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 4px;
  }

  .dev-nahian-car-terminal-top p {
    font-size: 0.85rem;
    color: var(--dev-nahian-car-text-muted);
    margin: 0;
  }

  .dev-nahian-car-form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  @media (max-width: 480px) {
    .dev-nahian-car-form-row-2 {
      grid-template-columns: 1fr;
    }
  }

  .dev-nahian-car-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 14px;
  }

  .dev-nahian-car-form-group label {
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: 0.04em;
  }

  .dev-nahian-car-terminal-input {
    width: 100%;
    height: 42px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 0 12px;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--dev-nahian-car-text-dark);
    background: var(--dev-nahian-car-bg-light);
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s, background-color 0.2s;
  }

  .dev-nahian-car-terminal-input:focus {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
  }

  .dev-nahian-car-terminal-textarea {
    height: 72px;
    padding: 10px 12px;
    resize: vertical;
  }

  .dev-nahian-car-cost-summary {
    background: var(--dev-nahian-car-bg-light);
    border: 1px dashed var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 14px;
    margin: 18px 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .dev-nahian-car-cost-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-cost-row.total-row {
    border-top: 1px solid var(--dev-nahian-car-border);
    padding-top: 8px;
    margin-top: 2px;
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-total-price {
    font-size: 1.4rem;
    color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-btn-dispatch {
    width: 100%;
    height: 48px;
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border: none;
    border-radius: var(--dev-nahian-car-radius-sm);
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background 0.2s;
  }

  .dev-nahian-car-btn-dispatch:hover {
    background: var(--dev-nahian-car-primary-hover);
  }

  .dev-nahian-car-confirmation-banner {
    display: none;
    padding: 14px;
    border-radius: var(--dev-nahian-car-radius-sm);
    background: var(--dev-nahian-car-accent-green-bg);
    border: 1px solid rgba(13, 148, 136, 0.3);
    color: var(--dev-nahian-car-accent-green);
    font-size: 0.85rem;
    font-weight: 700;
    text-align: center;
    margin-top: 14px;
  }

  .dev-nahian-car-confirmation-banner.show {
    display: block;
  }

  .dev-nahian-car-lightbox-modal {
    position: fixed;
    inset: 0;
    background: rgba(10, 13, 20, 0.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-lightbox-modal.active {
    opacity: 1;
    visibility: visible;
  }

  .dev-nahian-car-lightbox-dialog {
    max-width: 90vw;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
  }

  .dev-nahian-car-lightbox-dialog img {
    max-width: 100%;
    max-height: 75vh;
    border-radius: var(--dev-nahian-car-radius-sm);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
  }

  .dev-nahian-car-lightbox-caption {
    color: #ffffff;
    margin-top: 14px;
    font-size: 0.95rem;
    font-weight: 600;
  }

  .dev-nahian-car-lightbox-btn {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
  }

  .dev-nahian-car-lightbox-btn:hover {
    background: #ffffff;
    color: var(--dev-nahian-car-primary);
  }

  .dev-nahian-car-lightbox-close { top: -46px; right: 0; font-size: 1.25rem; }
  .dev-nahian-car-lightbox-prev { left: -50px; top: 50%; transform: translateY(-50%); }
  .dev-nahian-car-lightbox-next { right: -50px; top: 50%; transform: translateY(-50%); }

  @media (max-width: 768px) {
    .dev-nahian-car-lightbox-prev { left: 8px; }
    .dev-nahian-car-lightbox-next { right: 8px; }
    .dev-nahian-car-lightbox-close { top: 8px; right: 8px; }
  }
</style>

<div class="dev-nahian-car-detail-wrapper">
  <!-- Header -->
  <div class="dev-nahian-car-detail-header">
    <div class="dev-nahian-car-section-badge">
      <span class="dev-nahian-car-badge-pulse"></span>
      Vehicle Dossier &bull; VIN #<?php echo esc_html( $car_vin ); ?>
    </div>
    <h1><?php echo esc_html( $car_brand ); ?> <span><?php echo esc_html( str_replace( $car_brand, '', $car_name ) ); ?></span></h1>
    <p><?php echo esc_html( $car_year ); ?> Model &bull; <?php echo esc_html( $drivetrain ); ?> &bull; Staged for Handover at <?php echo esc_html( $car_location ); ?></p>
  </div>

  <!-- Main Grid Layout -->
  <div class="dev-nahian-car-detail-grid">

    <!-- LEFT COLUMN -->
    <div class="dev-nahian-car-detail-left">
      
      <!-- Interactive Stage -->
      <div class="dev-nahian-car-card-surface dev-nahian-car-gallery-stage">
        <div class="dev-nahian-car-gallery-viewport" id="galleryViewport">
          <img id="mainStageImage" src="<?php echo esc_url( $gallery[0] ); ?>" alt="<?php echo esc_attr( $car_name ); ?>">
          <div class="dev-nahian-car-gallery-floating-pill">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Staged at <?php echo esc_html( $car_location ); ?>
          </div>
        </div>

        <div class="dev-nahian-car-gallery-toolbar">
          <span style="font-size: 0.8rem; font-weight: 700; color: var(--dev-nahian-car-text-muted); text-transform: uppercase;">Angle Selector</span>
          <button class="dev-nahian-car-gallery-btn" id="openFullscreenBtn" type="button">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>
            Enlarge View
          </button>
        </div>

        <div class="dev-nahian-car-gallery-thumbs">
          <?php foreach ( $gallery as $idx => $img_url ) : ?>
            <div class="dev-nahian-car-thumb-item <?php echo $idx === 0 ? 'active' : ''; ?>" data-src="<?php echo esc_url( $img_url ); ?>" data-caption="<?php echo esc_attr( $car_name ); ?> Perspective <?php echo $idx + 1; ?>">
              <img src="<?php echo esc_url( $img_url ); ?>" alt="Thumb <?php echo $idx + 1; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Performance Quad Highlights -->
      <div class="dev-nahian-car-features-quad">
        <div class="dev-nahian-car-quad-item">
          <span>Peak Power</span>
          <strong><?php echo esc_html( $horsepower ); ?> HP</strong>
        </div>
        <div class="dev-nahian-car-quad-item">
          <span>0–100 km/h</span>
          <strong><?php echo esc_html( $acceleration ); ?></strong>
        </div>
        <div class="dev-nahian-car-quad-item">
          <span>Top Speed</span>
          <strong><?php echo esc_html( $top_speed ); ?></strong>
        </div>
        <div class="dev-nahian-car-quad-item">
          <span>Drivetrain</span>
          <strong><?php echo esc_html( $drivetrain ); ?></strong>
        </div>
      </div>

      <!-- Telemetry Specifications Matrix -->
      <div class="dev-nahian-car-card-surface dev-nahian-car-telemetry-card">
        <h3>Factory Calibration Telemetry</h3>
        <p>Pre-inspected prior to delivery. Compression curves and brake coefficients certified to track spec.</p>

        <div class="dev-nahian-car-telemetry-matrix">
          <?php if ( ! empty( $specs ) ) : ?>
            <?php foreach ( $specs as $s_label => $s_val ) : ?>
              <div class="dev-nahian-car-telemetry-row">
                <span class="dev-nahian-car-spec-name"><?php echo esc_html( $s_label ); ?></span>
                <span class="dev-nahian-car-spec-val"><?php echo esc_html( $s_val ); ?></span>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <div class="dev-nahian-car-telemetry-row">
              <span class="dev-nahian-car-spec-name">License Plate</span>
              <span class="dev-nahian-car-spec-val"><?php echo esc_html( $car_plate ); ?></span>
            </div>
            <div class="dev-nahian-car-telemetry-row">
              <span class="dev-nahian-car-spec-name">Color Finish</span>
              <span class="dev-nahian-car-spec-val"><?php echo esc_html( $car['color'] ?? 'Standard' ); ?></span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Separate Protection & Cross-Border Add-ons Card -->
      <?php if ( ! empty( $insurances ) || ! empty( $borders ) ) : ?>
      <div class="dev-nahian-car-addons-card">
        <h3>Protection &amp; Cross-Border Add-ons</h3>
        <p>Select specialized coverage tiers and cross-border transit clearance for your journey.</p>
        <div class="dev-nahian-car-addons-stack">
          <?php foreach ( $insurances as $ins_k => $ins_v ) : 
              if ( empty( $ins_v['enabled'] ) ) continue;
          ?>
            <label class="dev-nahian-car-addon-box">
              <div style="display: flex; align-items: center;">
                <input type="checkbox" class="dev-nahian-car-addon-check" data-rate="<?php echo esc_attr( $ins_v['price'] ); ?>" id="ins_<?php echo esc_attr( $ins_k ); ?>">
                <div class="dev-nahian-car-addon-info">
                  <strong><?php echo esc_html( ucfirst( $ins_k ) ); ?> Insurance</strong>
                  <span>Fully synchronized protection plan</span>
                </div>
              </div>
              <span class="dev-nahian-car-addon-price">+<?php echo esc_html( $currency . ' ' . $ins_v['price'] ); ?></span>
            </label>
          <?php endforeach; ?>

          <?php foreach ( $borders as $b_k => $b_v ) : 
              if ( empty( $b_v['enabled'] ) ) continue;
          ?>
            <label class="dev-nahian-car-addon-box">
              <div style="display: flex; align-items: center;">
                <input type="checkbox" class="dev-nahian-car-addon-check" data-rate="<?php echo esc_attr( $b_v['price'] ); ?>" id="border_<?php echo esc_attr( $b_k ); ?>">
                <div class="dev-nahian-car-addon-info">
                  <strong><?php echo esc_html( ucfirst( $b_k ) ); ?> Clearance</strong>
                  <span>Cross-border travel clearance</span>
                </div>
              </div>
              <span class="dev-nahian-car-addon-price">+<?php echo esc_html( $currency . ' ' . $b_v['price'] ); ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if ( ! empty( $video_url ) ) : ?>
      <!-- Video Feature Card -->
      <div class="dev-nahian-car-card-surface dev-nahian-car-video-card">
        <div class="dev-nahian-car-video-viewport">
          <video id="chassisVideo" poster="<?php echo esc_url( $car_img ); ?>" preload="none">
            <source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
          </video>
          <button class="dev-nahian-car-video-play-btn" id="videoPlayOverlayBtn" aria-label="Play Exhaust Preview" type="button">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
          </button>
        </div>
        <div class="dev-nahian-car-video-meta">
          <div>
            <h4>Exhaust Note &amp; Walkaround Telemetry</h4>
            <p>Listen to factory twin-turbo acoustics and review vehicle walkthrough.</p>
          </div>
          <button class="dev-nahian-car-gallery-btn" id="restartVideoBtn" type="button">Restart Clip</button>
        </div>
      </div>
      <?php endif; ?>

      <!-- Privileges -->
      <div class="dev-nahian-car-card-surface dev-nahian-car-privileges-card">
        <h3>Included Client Privileges</h3>
        <ul class="dev-nahian-car-privilege-list">
          <li class="dev-nahian-car-privilege-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span><strong>Exact VIN Allocation Guarantee:</strong> You receive this specific chassis (#<?php echo esc_html( $car_vin ); ?>) rather than an unspecified placeholder model.</span>
          </li>
          <li class="dev-nahian-car-privilege-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span><strong>Pre-Staged Airside Arrival:</strong> Vehicle is pre-conditioned and parked inside Signature or Atlantic Aviation FBOs prior to touchdown.</span>
          </li>
          <li class="dev-nahian-car-privilege-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span><strong>Zero Counter Wait Times:</strong> Walk straight to your bay and unlock with the encrypted smartphone pass issued upon booking confirmation.</span>
          </li>
        </ul>
      </div>

    </div>

    <!-- RIGHT COLUMN: Sticky Dispatch Terminal -->
    <div class="dev-nahian-car-detail-right">
      <aside class="dev-nahian-car-dispatch-terminal" id="dispatchTerminal">
        <div class="dev-nahian-car-terminal-top">
          <h3>Configure Dispatch</h3>
          <p>Immediate digital key generation with real-time rate lock.</p>
        </div>

        <form id="vehicleTerminalForm">
          <input type="hidden" id="carIdInput" value="<?php echo esc_attr( $car_id ); ?>">
          <input type="hidden" id="baseDailyRate" value="<?php echo esc_attr( $car_price ); ?>">

          <div class="dev-nahian-car-form-row-2">
            <div class="dev-nahian-car-form-group">
              <label for="clientName">Client Name</label>
              <input type="text" class="dev-nahian-car-terminal-input" id="clientName" placeholder="Alexander Vance" required>
            </div>
            <div class="dev-nahian-car-form-group">
              <label for="clientPhone">Direct Phone</label>
              <input type="tel" class="dev-nahian-car-terminal-input" id="clientPhone" placeholder="+1 (555) 000-0000" required>
            </div>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="clientEmail">Official Email</label>
            <input type="email" class="dev-nahian-car-terminal-input" id="clientEmail" placeholder="vance@familyoffice.com" required>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="deliveryMode">Delivery Mode</label>
            <select class="dev-nahian-car-terminal-input" id="deliveryMode">
              <option value="self">Self-Drive (Smartphone NFC Key)</option>
              <option value="chauffeur">Chauffeur Escort (Security-Cleared)</option>
            </select>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="pickupTerminalSelect">Departure Bay</label>
            <select class="dev-nahian-car-terminal-input" id="pickupTerminalSelect">
              <option value="<?php echo esc_attr( $car_location ); ?>"><?php echo esc_html( $car_location ); ?></option>
              <option value="JFK">JFK Signature Aviation FBO Hangar</option>
              <option value="Midtown">Manhattan Midtown Executive Pad</option>
            </select>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="dropoffTerminalSelect">Return Bay</label>
            <select class="dev-nahian-car-terminal-input" id="dropoffTerminalSelect">
              <option value="same">Same as Departure Bay</option>
              <option value="JFK">JFK Signature Aviation FBO Hangar</option>
              <option value="Midtown">Manhattan Midtown Executive Pad</option>
            </select>
          </div>

          <div class="dev-nahian-car-form-row-2">
            <div class="dev-nahian-car-form-group">
              <label for="flightTailNumber">Flight Tail / Code</label>
              <input type="text" class="dev-nahian-car-terminal-input" id="flightTailNumber" placeholder="e.g. N942VX">
            </div>
            <div class="dev-nahian-car-form-group">
              <label for="handoverTime">Staging ETA</label>
              <input type="time" class="dev-nahian-car-terminal-input" id="handoverTime" value="14:00" required>
            </div>
          </div>

          <div class="dev-nahian-car-form-row-2">
            <div class="dev-nahian-car-form-group">
              <label for="startDate">Dispatch Date</label>
              <input type="date" class="dev-nahian-car-terminal-input" id="startDate" required>
            </div>
            <div class="dev-nahian-car-form-group">
              <label for="endDate">Return Date</label>
              <input type="date" class="dev-nahian-car-terminal-input" id="endDate" required>
            </div>
          </div>

          <!-- Payment Method Selector -->
          <div class="dev-nahian-car-form-group">
            <label for="paymentMethodSelect">Payment Method</label>
            <select class="dev-nahian-car-terminal-input" id="paymentMethodSelect">
              <option value="card">Secure Credit Card / Amex</option>
              <option value="wire">Family Office Wire Transfer</option>
              <option value="crypto">USDC / Enterprise Crypto Invoice</option>
            </select>
          </div>

          <div class="dev-nahian-car-form-group">
            <label for="customNotes">Special Requirements</label>
            <textarea class="dev-nahian-car-terminal-input dev-nahian-car-terminal-textarea" id="customNotes" placeholder="Hangar coordinates, custom temperature, or luggage count..."></textarea>
          </div>

          <!-- Real-Time Cost Summary -->
          <div class="dev-nahian-car-cost-summary">
            <div class="dev-nahian-car-cost-row">
              <span>Daily Rate:</span>
              <strong style="color: var(--dev-nahian-car-text-dark);"><?php echo esc_html( $currency . ' ' . number_format_i18n( $car_price, 2 ) ); ?></strong>
            </div>
            <div class="dev-nahian-car-cost-row">
              <span>Duration:</span>
              <strong id="scopeDaysText" style="color: var(--dev-nahian-car-text-dark);">3 Days</strong>
            </div>
            <div class="dev-nahian-car-cost-row">
              <span>Add-ons Total:</span>
              <strong id="addonsFeeText" style="color: var(--dev-nahian-car-text-dark);"><?php echo esc_html( $currency ); ?> 0.00</strong>
            </div>
            <div class="dev-nahian-car-cost-row">
              <span>Inter-Bay Relocation:</span>
              <span id="airportFeeText" style="color: var(--dev-nahian-car-accent-green); font-weight: 700;"><?php echo esc_html( $currency ); ?> 0.00 (Waived)</span>
            </div>
            <div class="dev-nahian-car-cost-row total-row">
              <span>Estimated Total:</span>
              <strong class="dev-nahian-car-total-price" id="totalPriceFig"><?php echo esc_html( $currency ); ?> <?php echo esc_html( number_format_i18n( $car_price * 3, 2 ) ); ?></strong>
            </div>
          </div>

          <button type="submit" class="dev-nahian-car-btn-dispatch">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Authorize Priority Dispatch
          </button>
        </form>

        <div class="dev-nahian-car-confirmation-banner" id="confirmationBox" role="alert" aria-live="polite">
          Chassis Allocation #<?php echo esc_html( $car_vin ); ?> Authorized.
          <div style="font-size: 0.74rem; font-weight: 500; margin-top: 4px; color: var(--dev-nahian-car-text-muted);">
            Flight telemetry received. Encrypted NFC digital key will be delivered 2 hours prior to arrival.
          </div>
        </div>
      </aside>
    </div>

  </div>
</div>

<!-- Fullscreen Lightbox Modal -->
<div class="dev-nahian-car-lightbox-modal" id="lightboxModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="dev-nahian-car-lightbox-dialog">
    <button class="dev-nahian-car-lightbox-btn dev-nahian-car-lightbox-close" id="lightboxCloseBtn" aria-label="Close Preview" type="button">&times;</button>
    <button class="dev-nahian-car-lightbox-btn dev-nahian-car-lightbox-prev" id="lightboxPrevBtn" aria-label="Previous Perspective" type="button">&#10094;</button>
    <img id="lightboxImg" src="" alt="Enlarged Perspective">
    <p class="dev-nahian-car-lightbox-caption" id="lightboxCaptionText"></p>
    <button class="dev-nahian-car-lightbox-btn dev-nahian-car-lightbox-next" id="lightboxNextBtn" aria-label="Next Perspective" type="button">&#10095;</button>
  </div>
</div>

<!-- Internal Vehicle Single JavaScript Architecture -->
<script id="dev-nahian-car-detail-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      // 1. Gallery Switcher & Lightbox
      const mainStageImg     = document.getElementById('mainStageImage');
      const galleryViewport  = document.getElementById('galleryViewport');
      const thumbItems       = Array.from(document.querySelectorAll('.dev-nahian-car-thumb-item'));
      const lightboxModal    = document.getElementById('lightboxModal');
      const lightboxImg      = document.getElementById('lightboxImg');
      const lightboxCaption  = document.getElementById('lightboxCaptionText');
      const openFullscreenBtn  = document.getElementById('openFullscreenBtn');
      const lightboxCloseBtn   = document.getElementById('lightboxCloseBtn');
      const lightboxPrevBtn    = document.getElementById('lightboxPrevBtn');
      const lightboxNextBtn    = document.getElementById('lightboxNextBtn');

      let currentPhotoIdx = 0;

      function setPerspective(index) {
        if (!thumbItems.length || !mainStageImg || !lightboxImg || !lightboxCaption) return;
        currentPhotoIdx = (index + thumbItems.length) % thumbItems.length;
        thumbItems.forEach(function(t, i) {
          t.classList.toggle('active', i === currentPhotoIdx);
        });

        const newSrc = thumbItems[currentPhotoIdx].getAttribute('data-src');
        mainStageImg.style.opacity = '0.3';
        setTimeout(function() {
          mainStageImg.src = newSrc;
          mainStageImg.style.opacity = '1';
        }, 120);

        lightboxImg.src = newSrc;
        lightboxCaption.textContent = thumbItems[currentPhotoIdx].getAttribute('data-caption') || 'Veloce Perspective';
      }

      thumbItems.forEach(function(thumb, idx) {
        thumb.addEventListener('click', function() {
          setPerspective(idx);
        });
      });

      function openLightbox() {
        if (!lightboxModal) return;
        setPerspective(currentPhotoIdx);
        lightboxModal.classList.add('active');
        lightboxModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      }

      function closeLightbox() {
        if (!lightboxModal) return;
        lightboxModal.classList.remove('active');
        lightboxModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }

      if (openFullscreenBtn) openFullscreenBtn.addEventListener('click', openLightbox);
      if (galleryViewport) galleryViewport.addEventListener('click', openLightbox);
      if (lightboxCloseBtn) lightboxCloseBtn.addEventListener('click', closeLightbox);

      if (lightboxPrevBtn) {
        lightboxPrevBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          setPerspective(currentPhotoIdx - 1);
        });
      }

      if (lightboxNextBtn) {
        lightboxNextBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          setPerspective(currentPhotoIdx + 1);
        });
      }

      if (lightboxModal) {
        lightboxModal.addEventListener('click', function(e) {
          if (e.target === lightboxModal) closeLightbox();
        });
      }

      document.addEventListener('keydown', function(e) {
        if (!lightboxModal || !lightboxModal.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') setPerspective(currentPhotoIdx - 1);
        if (e.key === 'ArrowRight') setPerspective(currentPhotoIdx + 1);
      });

      // 2. Video Playback
      const chassisVideo     = document.getElementById('chassisVideo');
      const playOverlayBtn   = document.getElementById('videoPlayOverlayBtn');
      const restartVideoBtn  = document.getElementById('restartVideoBtn');

      if (chassisVideo && playOverlayBtn) {
        playOverlayBtn.addEventListener('click', function() {
          chassisVideo.play();
          chassisVideo.controls = true;
          playOverlayBtn.style.display = 'none';
        });

        chassisVideo.addEventListener('pause', function() {
          if (!chassisVideo.seeking) {
            playOverlayBtn.style.display = 'flex';
            chassisVideo.controls = false;
          }
        });

        chassisVideo.addEventListener('play', function() {
          playOverlayBtn.style.display = 'none';
          chassisVideo.controls = true;
        });
      }

      if (restartVideoBtn && chassisVideo && playOverlayBtn) {
        restartVideoBtn.addEventListener('click', function() {
          chassisVideo.currentTime = 0;
          chassisVideo.play();
          playOverlayBtn.style.display = 'none';
          chassisVideo.controls = true;
        });
      }

      // 3. Dispatch Terminal Real-Time Calculation
      const startInput      = document.getElementById('startDate');
      const endInput        = document.getElementById('endDate');
      const scopeDaysText   = document.getElementById('scopeDaysText');
      const totalPriceFig   = document.getElementById('totalPriceFig');
      const addonsFeeText   = document.getElementById('addonsFeeText');
      const dropoffSelect   = document.getElementById('dropoffTerminalSelect');
      const airportFeeText  = document.getElementById('airportFeeText');
      const addonCheckboxes = document.querySelectorAll('.dev-nahian-car-addon-check');
      const rateInput       = document.getElementById('baseDailyRate');

      const BASE_DAILY_RATE = rateInput ? Number(rateInput.value) : 189;

      if (startInput && endInput) {
        const today  = new Date();
        const future = new Date();
        future.setDate(today.getDate() + 3);

        const todayStr  = today.toISOString().split('T')[0];
        const futureStr = future.toISOString().split('T')[0];

        startInput.value = todayStr;
        endInput.value   = futureStr;
        startInput.min   = todayStr;
        endInput.min     = todayStr;

        function calculateTotal() {
          const start = new Date(startInput.value);
          const end   = new Date(endInput.value);
          const days  = Math.max(1, Math.ceil((end - start) / (1000 * 60 * 60 * 24)));
          
          let addonTotal = 0;
          addonCheckboxes.forEach(function(cb) {
            if (cb.checked) addonTotal += Number(cb.getAttribute('data-rate'));
          });

          if (addonsFeeText) {
            addonsFeeText.textContent = '<?php echo esc_js( $currency ); ?> ' + addonTotal.toFixed(2);
          }

          let relocationFee = (dropoffSelect && dropoffSelect.value !== 'same' && dropoffSelect.value !== '<?php echo esc_js( $car_location ); ?>') ? 120 : 0;
          if (airportFeeText) {
            if (relocationFee > 0) {
              airportFeeText.textContent = '<?php echo esc_js( $currency ); ?> ' + relocationFee + '.00 (Inter-Bay)';
              airportFeeText.style.color = 'var(--dev-nahian-car-text-dark)';
            } else {
              airportFeeText.textContent = '<?php echo esc_js( $currency ); ?> 0.00 (Waived)';
              airportFeeText.style.color = 'var(--dev-nahian-car-accent-green)';
            }
          }

          const grandTotal = (days * BASE_DAILY_RATE) + addonTotal + relocationFee;

          if (scopeDaysText) {
            scopeDaysText.textContent = days + ' Day' + (days > 1 ? 's' : '');
          }
          if (totalPriceFig) {
            totalPriceFig.textContent = '<?php echo esc_js( $currency ); ?> ' + grandTotal.toLocaleString();
          }
        }

        startInput.addEventListener('change', function() {
          if (new Date(endInput.value) <= new Date(startInput.value)) {
            const nextDay = new Date(startInput.value);
            nextDay.setDate(nextDay.getDate() + 1);
            endInput.value = nextDay.toISOString().split('T')[0];
          }
          endInput.min = startInput.value;
          calculateTotal();
        });

        endInput.addEventListener('change', calculateTotal);
        if (dropoffSelect) dropoffSelect.addEventListener('change', calculateTotal);
        addonCheckboxes.forEach(function(cb) {
          cb.addEventListener('change', calculateTotal);
        });

        calculateTotal();
      }

      // 4. Form Submission Simulation
      const terminalForm = document.getElementById('vehicleTerminalForm');
      const confBox      = document.getElementById('confirmationBox');

      if (terminalForm && confBox) {
        terminalForm.addEventListener('submit', function(e) {
          e.preventDefault();
          confBox.classList.add('show');
          confBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
      }
    });
  })();
</script>

<?php get_footer(); ?>