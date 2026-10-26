<?php
/**
 * Template Name: Cars
 * Description: Executive vehicle catalog template with interactive filtering and multi-facet search sidebar.
 */

get_header(); 

global $wpdb;

// 1. Fetch Dynamic Options from Settings
$badge        = get_option( 'dev_nahian_cars_badge', 'The Sovereign Stable' );
$title        = get_option( 'dev_nahian_cars_title', 'All Prestige <span>Vehicles</span>' );
$desc         = get_option( 'dev_nahian_cars_desc', 'Factory-calibrated supercars, electric flagships, and luxury touring SUVs available for immediate dispatch.' );
$price_min    = absint( get_option( 'dev_nahian_cars_price_min', 100 ) );
$price_max    = absint( get_option( 'dev_nahian_cars_price_max', 2500 ) );
$price_step   = absint( get_option( 'dev_nahian_cars_price_step', 25 ) );
$per_page     = absint( get_option( 'dev_nahian_cars_per_page', 24 ) );
$default_sort = get_option( 'dev_nahian_cars_default_sort', 'featured' );

// 2. Query Live Vehicles from Custom Database Table
$table_cars = $wpdb->prefix . 'dev_nahian_cars';
$cars_exist = $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_cars ) ) === $table_cars;

$cars = array();
if ( $cars_exist ) {
    $cars = $wpdb->get_results( "SELECT * FROM {$table_cars} WHERE status != 'maintenance' ORDER BY id DESC LIMIT {$per_page}", ARRAY_A );
}

// 3. Dynamic Categories Computation
$categories_count = array();
$real_prices      = array();

if ( ! empty( $cars ) ) {
    foreach ( $cars as $c ) {
        $cat = ! empty( $c['category'] ) ? trim( $c['category'] ) : 'Sports GT';
        $categories_count[$cat] = ( $categories_count[$cat] ?? 0 ) + 1;
        $real_prices[] = (float) $c['price'];
    }
    // Automatically match price slider ceiling if max vehicle rate exceeds configured value
    if ( ! empty( $real_prices ) ) {
        $detected_max = ceil( max( $real_prices ) );
        if ( $detected_max > $price_max ) {
            $price_max = $detected_max;
        }
    }
}
$total_cars_count = count( $cars );
?>

<!-- Internal Catalog CSS Architecture -->
<style id="dev-nahian-cars-styles">
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
    --dev-nahian-car-warning-gold: #d97706;
    --dev-nahian-car-radius: 12px;
    --dev-nahian-car-radius-sm: 8px;
  }

  .dev-nahian-car-catalog-wrapper {
    padding: 64px 20px 88px;
    max-width: 1280px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  /* Centered Header */
  .dev-nahian-car-catalog-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 52px;
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

  .dev-nahian-car-catalog-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 14px;
  }

  .dev-nahian-car-catalog-header h1 span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-catalog-header p {
    color: var(--dev-nahian-car-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
  }

  /* Main Split Layout */
  .dev-nahian-car-catalog-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-catalog-layout {
      grid-template-columns: 310px 1fr;
      gap: 36px;
      align-items: start;
    }
  }

  /* Upgraded Executive Sidebar */
  .dev-nahian-car-catalog-sidebar {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: 24px 20px;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.05);
    position: sticky;
    top: 96px;
  }

  .dev-nahian-car-sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 14px;
    margin-bottom: 20px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-sidebar-header h3 {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin: 0;
  }

  .dev-nahian-car-sidebar-header h3 svg {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-reset-btn {
    background: rgba(184, 142, 30, 0.08);
    border: 1px solid var(--dev-nahian-car-gold-border);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--dev-nahian-car-gold);
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 999px;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-reset-btn:hover {
    background: var(--dev-nahian-car-gold);
    color: #ffffff;
  }

  .dev-nahian-car-filter-group {
    margin-bottom: 22px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-filter-group:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
  }

  .dev-nahian-car-filter-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.73rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--dev-nahian-car-text-dark);
    margin-bottom: 12px;
  }

  /* Search Shell */
  .dev-nahian-car-search-shell {
    position: relative;
    display: flex;
    align-items: center;
  }

  .dev-nahian-car-search-shell svg {
    position: absolute;
    left: 14px;
    color: var(--dev-nahian-car-text-muted);
    pointer-events: none;
    transition: color 0.2s;
  }

  .dev-nahian-car-sidebar-input {
    width: 100%;
    height: 44px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding-left: 40px;
    padding-right: 14px;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--dev-nahian-car-text-dark);
    background: var(--dev-nahian-car-bg-light);
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s, background-color 0.2s, box-shadow 0.2s;
  }

  .dev-nahian-car-sidebar-input:focus {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.06);
  }

  /* Category Pill List */
  .dev-nahian-car-category-pill-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .dev-nahian-car-category-pill {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid transparent;
    background: transparent;
    cursor: pointer;
    font-size: 0.86rem;
    font-weight: 600;
    color: var(--dev-nahian-car-text-muted);
    transition: all 0.2s ease;
    user-select: none;
  }

  .dev-nahian-car-category-pill input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .dev-nahian-car-category-pill:hover {
    background: var(--dev-nahian-car-bg-light);
    color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-category-pill.active {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.12);
  }

  .dev-nahian-car-category-pill .dev-nahian-car-pill-count {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 999px;
    background: var(--dev-nahian-car-bg-light);
    color: var(--dev-nahian-car-text-muted);
    transition: all 0.2s;
  }

  .dev-nahian-car-category-pill.active .dev-nahian-car-pill-count {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
  }

  /* Price Range Card & Slider */
  .dev-nahian-car-price-hud-box {
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 14px;
  }

  .dev-nahian-car-price-hud-display {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 12px;
  }

  .dev-nahian-car-price-hud-display span {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-muted);
    text-transform: uppercase;
  }

  .dev-nahian-car-price-hud-display strong {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dev-nahian-car-primary);
  }

  .dev-nahian-car-range-slider {
    width: 100%;
    height: 6px;
    border-radius: 999px;
    background: #cbd5e1;
    outline: none;
    accent-color: var(--dev-nahian-car-primary);
    cursor: pointer;
    margin-bottom: 8px;
    display: block;
  }

  .dev-nahian-car-range-limits {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--dev-nahian-car-text-muted);
  }

  /* Drivetrain Chip Grid */
  .dev-nahian-car-drivetrain-chips {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
  }

  .dev-nahian-car-chip-label {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px 4px;
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid var(--dev-nahian-car-border);
    background: var(--dev-nahian-car-bg-light);
    cursor: pointer;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
    text-align: center;
    transition: all 0.2s ease;
    user-select: none;
  }

  .dev-nahian-car-chip-label input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .dev-nahian-car-chip-label:hover {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
  }

  .dev-nahian-car-chip-label.active {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
    box-shadow: 0 4px 10px rgba(17, 24, 39, 0.12);
  }

  /* Right Catalog Main View */
  .dev-nahian-car-catalog-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .dev-nahian-car-catalog-controls {
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: 14px 20px;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
  }

  @media (min-width: 600px) {
    .dev-nahian-car-catalog-controls {
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
    }
  }

  .dev-nahian-car-results-count {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
  }

  .dev-nahian-car-results-count span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-sort-wrap {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .dev-nahian-car-sort-wrap label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--dev-nahian-car-text-muted);
  }

  .dev-nahian-car-sort-select {
    height: 36px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding-inline: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--dev-nahian-car-text-dark);
    background: var(--dev-nahian-car-bg-light);
    outline: none;
    cursor: pointer;
  }

  /* Fleet Cards Grid */
  .dev-nahian-car-fleet-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
  }

  @media (min-width: 640px) {
    .dev-nahian-car-fleet-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1100px) {
    .dev-nahian-car-fleet-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-car-box {
    background: #ffffff;
    border-radius: var(--dev-nahian-car-radius);
    border: 1px solid var(--dev-nahian-car-border);
    overflow: hidden;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .dev-nahian-car-car-box:hover {
    box-shadow: 0 16px 32px -6px rgba(15, 23, 42, 0.1);
    transform: translateY(-4px);
  }

  .dev-nahian-car-car-thumb {
    position: relative;
    height: 210px;
    overflow: hidden;
    background: #0f172a;
  }

  .dev-nahian-car-car-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
  }

  .dev-nahian-car-car-box:hover .dev-nahian-car-car-thumb img {
    transform: scale(1.05);
  }

  .dev-nahian-car-badge-category {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.82);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .dev-nahian-car-rating-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #ffffff;
    color: var(--dev-nahian-car-text-dark);
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
  }

  .dev-nahian-car-rating-badge svg {
    color: var(--dev-nahian-car-warning-gold);
  }

  .dev-nahian-car-car-details {
    padding: 18px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }

  .dev-nahian-car-car-details h3 {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0;
  }

  .dev-nahian-car-car-sub {
    font-size: 0.8rem;
    color: var(--dev-nahian-car-text-muted);
    margin: 4px 0 14px;
  }

  .dev-nahian-car-car-specs {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
    background: var(--dev-nahian-car-bg-light);
    padding: 8px 10px;
    border-radius: var(--dev-nahian-car-radius-sm);
    margin-bottom: 16px;
    border: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-spec-node span {
    font-size: 0.65rem;
    color: var(--dev-nahian-car-text-muted);
    text-transform: uppercase;
    font-weight: 700;
    display: block;
    margin-bottom: 2px;
  }

  .dev-nahian-car-spec-node strong {
    font-size: 0.82rem;
    color: var(--dev-nahian-car-text-dark);
    font-weight: 700;
    display: block;
  }

  .dev-nahian-car-car-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-rate strong {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1;
  }

  .dev-nahian-car-rate span {
    font-size: 0.7rem;
    color: var(--dev-nahian-car-text-muted);
    display: block;
    margin-top: 2px;
  }

  .dev-nahian-car-btn-reserve {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    background: var(--dev-nahian-car-bg-light);
    color: var(--dev-nahian-car-text-dark);
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-btn-reserve:hover {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
  }

  /* Empty state */
  .dev-nahian-car-empty-state {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 50px 20px;
    text-align: center;
    background: #ffffff;
    border: 1px dashed var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    grid-column: 1 / -1;
  }

  .dev-nahian-car-empty-state.show {
    display: flex;
  }

  .dev-nahian-car-empty-state svg {
    color: var(--dev-nahian-car-text-muted);
    margin-bottom: 12px;
  }

  .dev-nahian-car-empty-state h4 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
    margin-bottom: 6px;
  }

  .dev-nahian-car-empty-state p {
    font-size: 0.9rem;
    color: var(--dev-nahian-car-text-muted);
    max-width: 360px;
    margin-bottom: 16px;
  }
</style>

<div class="dev-nahian-car-catalog-wrapper">
  <!-- Centered Header with Pill Badge -->
  <div class="dev-nahian-car-catalog-header">
    <?php if ( ! empty( $badge ) ) : ?>
      <div class="dev-nahian-car-section-badge">
        <span class="dev-nahian-car-badge-pulse"></span>
        <?php echo esc_html( $badge ); ?>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $title ) ) : ?>
      <h1><?php echo wp_kses( $title, array( 'span' => array() ) ); ?></h1>
    <?php endif; ?>

    <?php if ( ! empty( $desc ) ) : ?>
      <p><?php echo esc_html( $desc ); ?></p>
    <?php endif; ?>
  </div>

  <!-- Catalog Layout -->
  <div class="dev-nahian-car-catalog-layout">
    
    <!-- Left Filter Sidebar -->
    <aside class="dev-nahian-car-catalog-sidebar" aria-label="<?php esc_attr_e( 'Fleet Filters', 'dev-nahian-car' ); ?>">
      <div class="dev-nahian-car-sidebar-header">
        <h3>
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
          </svg>
          <?php esc_html_e( 'Filter Fleet', 'dev-nahian-car' ); ?>
        </h3>
        <button type="button" class="dev-nahian-car-reset-btn" id="resetFiltersBtn"><?php esc_html_e( 'Reset', 'dev-nahian-car' ); ?></button>
      </div>

      <!-- Keyword Search -->
      <div class="dev-nahian-car-filter-group">
        <label class="dev-nahian-car-filter-label" for="keywordSearch"><?php esc_html_e( 'Search Chassis', 'dev-nahian-car' ); ?></label>
        <div class="dev-nahian-car-search-shell">
          <input type="text" class="dev-nahian-car-sidebar-input" id="keywordSearch" placeholder="<?php esc_attr_e( 'Model, engine, or spec...', 'dev-nahian-car' ); ?>">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </div>
      </div>

      <!-- Dynamic Category Pill List -->
      <div class="dev-nahian-car-filter-group">
        <div class="dev-nahian-car-filter-label"><?php esc_html_e( 'Vehicle Category', 'dev-nahian-car' ); ?></div>
        <div class="dev-nahian-car-category-pill-list">
          <label class="dev-nahian-car-category-pill active">
            <input type="radio" name="categoryFilter" value="all" checked>
            <span><?php esc_html_e( 'All Categories', 'dev-nahian-car' ); ?></span>
            <span class="dev-nahian-car-pill-count"><?php echo esc_html( $total_cars_count ); ?></span>
          </label>
          <?php foreach ( $categories_count as $c_name => $c_count ) : ?>
            <label class="dev-nahian-car-category-pill">
              <input type="radio" name="categoryFilter" value="<?php echo esc_attr( $c_name ); ?>">
              <span><?php echo esc_html( $c_name ); ?></span>
              <span class="dev-nahian-car-pill-count"><?php echo esc_html( $c_count ); ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Price HUD Box -->
      <div class="dev-nahian-car-filter-group">
        <div class="dev-nahian-car-filter-label"><?php esc_html_e( 'Daily Budget', 'dev-nahian-car' ); ?></div>
        <div class="dev-nahian-car-price-hud-box">
          <div class="dev-nahian-car-price-hud-display">
            <span><?php esc_html_e( 'Ceiling', 'dev-nahian-car' ); ?></span>
            <strong id="priceReadout">$<?php echo esc_html( $price_max ); ?></strong>
          </div>
          <input type="range" class="dev-nahian-car-range-slider" id="priceRange" min="<?php echo esc_attr( $price_min ); ?>" max="<?php echo esc_attr( $price_max ); ?>" step="<?php echo esc_attr( $price_step ); ?>" value="<?php echo esc_attr( $price_max ); ?>">
          <div class="dev-nahian-car-range-limits">
            <span>$<?php echo esc_html( $price_min ); ?></span>
            <span>$<?php echo esc_html( $price_max ); ?> <?php esc_html_e( 'Max', 'dev-nahian-car' ); ?></span>
          </div>
        </div>
      </div>

      <!-- Drivetrain Chips -->
      <div class="dev-nahian-car-filter-group">
        <div class="dev-nahian-car-filter-label"><?php esc_html_e( 'Drivetrain & Power', 'dev-nahian-car' ); ?></div>
        <div class="dev-nahian-car-drivetrain-chips">
          <label class="dev-nahian-car-chip-label">
            <input type="checkbox" class="dev-nahian-car-drive-filter" value="AWD">
            <span>AWD</span>
          </label>
          <label class="dev-nahian-car-chip-label">
            <input type="checkbox" class="dev-nahian-car-drive-filter" value="RWD">
            <span>RWD</span>
          </label>
          <label class="dev-nahian-car-chip-label">
            <input type="checkbox" class="dev-nahian-car-drive-filter" value="EV">
            <span>EV</span>
          </label>
        </div>
      </div>
    </aside>

    <!-- Main Fleet View -->
    <main class="dev-nahian-car-catalog-main">
      <!-- Controls Topbar -->
      <div class="dev-nahian-car-catalog-controls">
        <div class="dev-nahian-car-results-count">
          <?php esc_html_e( 'Showing', 'dev-nahian-car' ); ?> <span id="filteredCount"><?php echo esc_html( $total_cars_count ); ?></span> <?php esc_html_e( 'of', 'dev-nahian-car' ); ?> <?php echo esc_html( $total_cars_count ); ?> <?php esc_html_e( 'Vehicles', 'dev-nahian-car' ); ?>
        </div>

        <div class="dev-nahian-car-sort-wrap">
          <label for="sortBySelect"><?php esc_html_e( 'Sort By', 'dev-nahian-car' ); ?></label>
          <select class="dev-nahian-car-sort-select" id="sortBySelect">
            <option value="featured"><?php esc_html_e( 'Featured Collection', 'dev-nahian-car' ); ?></option>
            <option value="price-asc"><?php esc_html_e( 'Price: Low to High', 'dev-nahian-car' ); ?></option>
            <option value="price-desc"><?php esc_html_e( 'Price: High to Low', 'dev-nahian-car' ); ?></option>
            <option value="power-desc"><?php esc_html_e( 'Horsepower: Highest First', 'dev-nahian-car' ); ?></option>
          </select>
        </div>
      </div>

      <!-- Fleet Cards Grid -->
      <div class="dev-nahian-car-fleet-grid" id="fleetGrid">
        <?php if ( ! empty( $cars ) ) : ?>
          <?php foreach ( $cars as $car ) : 
            $c_id        = $car['id'];
            $c_name      = $car['name'];
            $c_brand     = ! empty( $car['brand'] ) ? $car['brand'] : 'Veloce Prestige';
            $c_cat       = ! empty( $car['category'] ) ? $car['category'] : 'Sports GT';
            $c_price     = (float) $car['price'];
            $c_power     = absint( $car['horsepower'] );
            $c_accel     = ! empty( $car['acceleration'] ) ? $car['acceleration'] : '3.2s';
            $c_drive     = ! empty( $car['drivetrain'] ) ? strtoupper( $car['drivetrain'] ) : 'AWD';
            $c_fuel      = ! empty( $car['fuel'] ) ? $car['fuel'] : 'Gasoline';
            $c_gear      = ! empty( $car['transmission'] ) ? $car['transmission'] : 'Automatic';
            $c_img       = ! empty( $car['image'] ) ? $car['image'] : 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=700&q=80';
            
            // Build searchable drive tokens
            $drive_tokens = array( $c_drive );
            if ( stripos( $c_fuel, 'electric' ) !== false || stripos( $c_cat, 'electric' ) !== false || stripos( $c_cat, 'ev' ) !== false ) {
                $drive_tokens[] = 'EV';
            }
            $drive_data = implode( ',', array_unique( $drive_tokens ) );
            
            // Single Car Dossier Link
            $single_url = add_query_arg( array( 'car_id' => $c_id ), home_url( '/single-car/' ) );
          ?>
            <div class="dev-nahian-car-car-box" data-category="<?php echo esc_attr( $c_cat ); ?>" data-price="<?php echo esc_attr( $c_price ); ?>" data-power="<?php echo esc_attr( $c_power ); ?>" data-drive="<?php echo esc_attr( $drive_data ); ?>">
              <div class="dev-nahian-car-car-thumb">
                <a href="<?php echo esc_url( $single_url ); ?>">
                  <img src="<?php echo esc_url( $c_img ); ?>" alt="<?php echo esc_attr( $c_name ); ?>" loading="lazy">
                </a>
                <span class="dev-nahian-car-badge-category"><?php echo esc_html( $c_cat ); ?></span>
                <div class="dev-nahian-car-rating-badge">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  5.0
                </div>
              </div>
              <div class="dev-nahian-car-car-details">
                <h3><a href="<?php echo esc_url( $single_url ); ?>" style="color:inherit; text-decoration:none;"><?php echo esc_html( $c_name ); ?></a></h3>
                <p class="dev-nahian-car-car-sub"><?php echo esc_html( $c_brand ); ?> &bull; <?php echo esc_html( ucfirst( $c_gear ) ); ?></p>
                <div class="dev-nahian-car-car-specs">
                  <div class="dev-nahian-car-spec-node">
                    <span><?php esc_html_e( 'Power', 'dev-nahian-car' ); ?></span>
                    <strong><?php echo esc_html( $c_power ); ?> HP</strong>
                  </div>
                  <div class="dev-nahian-car-spec-node">
                    <span><?php esc_html_e( '0-100', 'dev-nahian-car' ); ?></span>
                    <strong><?php echo esc_html( $c_accel ); ?></strong>
                  </div>
                  <div class="dev-nahian-car-spec-node">
                    <span><?php esc_html_e( 'Drive', 'dev-nahian-car' ); ?></span>
                    <strong><?php echo esc_html( $c_drive ); ?></strong>
                  </div>
                </div>
                <div class="dev-nahian-car-car-bottom">
                  <div class="dev-nahian-car-rate">
                    <strong>$<?php echo number_format( $c_price, 0 ); ?></strong>
                    <span><?php esc_html_e( 'per day / tax inc.', 'dev-nahian-car' ); ?></span>
                  </div>
                  <a href="<?php echo esc_url( $single_url ); ?>" class="dev-nahian-car-btn-reserve"><?php esc_html_e( 'Reserve', 'dev-nahian-car' ); ?></a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- Empty State Container -->
        <div class="dev-nahian-car-empty-state" id="emptyState">
          <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="8" y1="12" x2="16" y2="12"></line>
          </svg>
          <h4><?php esc_html_e( 'No Vehicles Match Your Criteria', 'dev-nahian-car' ); ?></h4>
          <p><?php esc_html_e( 'Try widening your daily rate threshold, resetting the search term, or clearing drivetrain checkboxes.', 'dev-nahian-car' ); ?></p>
          <button type="button" class="dev-nahian-car-reset-btn" id="resetEmptyBtn" style="font-size: 0.88rem; padding: 6px 16px;"><?php esc_html_e( 'Clear All Filters', 'dev-nahian-car' ); ?></button>
        </div>

      </div>
    </main>
  </div>
</div>

<!-- Internal Catalog JavaScript Architecture -->
<script id="dev-nahian-cars-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const keywordInput      = document.getElementById('keywordSearch');
      const categoryPills     = document.querySelectorAll('.dev-nahian-car-category-pill');
      const categoryRadios    = document.querySelectorAll('input[name="categoryFilter"]');
      const priceRange        = document.getElementById('priceRange');
      const priceReadout      = document.getElementById('priceReadout');
      const driveCheckboxes   = document.querySelectorAll('.dev-nahian-car-drive-filter');
      const chipLabels        = document.querySelectorAll('.dev-nahian-car-chip-label');
      const sortSelect        = document.getElementById('sortBySelect');
      const gridContainer     = document.getElementById('fleetGrid');
      const carCards          = Array.from(document.querySelectorAll('.dev-nahian-car-fleet-grid .dev-nahian-car-car-box'));
      const filteredCountSpan = document.getElementById('filteredCount');
      const emptyState        = document.getElementById('emptyState');
      const resetFiltersBtn   = document.getElementById('resetFiltersBtn');
      const resetEmptyBtn     = document.getElementById('resetEmptyBtn');

      function updateVisualActiveStates() {
        categoryPills.forEach(function(pill) {
          const radio = pill.querySelector('input[type="radio"]');
          if (radio && radio.checked) {
            pill.classList.add('active');
          } else {
            pill.classList.remove('active');
          }
        });

        chipLabels.forEach(function(chip) {
          const cb = chip.querySelector('input[type="checkbox"]');
          if (cb && cb.checked) {
            chip.classList.add('active');
          } else {
            chip.classList.remove('active');
          }
        });
      }

      function applyFilters() {
        updateVisualActiveStates();

        const keyword          = keywordInput ? keywordInput.value.trim().toLowerCase() : '';
        const selectedRadio    = document.querySelector('input[name="categoryFilter"]:checked');
        const selectedCategory = selectedRadio ? selectedRadio.value : 'all';
        const maxPrice         = priceRange ? Number(priceRange.value) : 999999;
        
        if (priceReadout) {
          priceReadout.textContent = '$' + maxPrice.toLocaleString();
        }

        const selectedDrives = Array.from(driveCheckboxes)
          .filter(function(cb) { return cb.checked; })
          .map(function(cb) { return cb.value; });

        let visibleCount = 0;

        carCards.forEach(function(card) {
          const titleEl  = card.querySelector('h3');
          const subEl    = card.querySelector('.dev-nahian-car-car-sub');
          const title    = titleEl ? titleEl.textContent.toLowerCase() : '';
          const subtitle = subEl ? subEl.textContent.toLowerCase() : '';
          const category = card.getAttribute('data-category') || '';
          const price    = Number(card.getAttribute('data-price') || 0);
          const driveAttr  = card.getAttribute('data-drive') || '';
          const driveTypes = driveAttr.split(',');

          const matchesKeyword  = !keyword || title.includes(keyword) || subtitle.includes(keyword);
          const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
          const matchesPrice    = price <= maxPrice;
          const matchesDrive    = selectedDrives.length === 0 || selectedDrives.every(function(d) {
            return driveTypes.includes(d);
          });

          if (matchesKeyword && matchesCategory && matchesPrice && matchesDrive) {
            card.style.display = 'flex';
            visibleCount++;
          } else {
            card.style.display = 'none';
          }
        });

        if (filteredCountSpan) {
          filteredCountSpan.textContent = visibleCount;
        }

        if (emptyState) {
          if (visibleCount === 0) {
            emptyState.classList.add('show');
          } else {
            emptyState.classList.remove('show');
          }
        }
      }

      function applySorting() {
        if (!sortSelect || !gridContainer) return;
        const sortValue   = sortSelect.value;
        const sortedCards = [...carCards];

        if (sortValue === 'price-asc') {
          sortedCards.sort(function(a, b) {
            return Number(a.getAttribute('data-price')) - Number(b.getAttribute('data-price'));
          });
        } else if (sortValue === 'price-desc') {
          sortedCards.sort(function(a, b) {
            return Number(b.getAttribute('data-price')) - Number(a.getAttribute('data-price'));
          });
        } else if (sortValue === 'power-desc') {
          sortedCards.sort(function(a, b) {
            return Number(b.getAttribute('data-power')) - Number(a.getAttribute('data-power'));
          });
        }

        sortedCards.forEach(function(card) {
          gridContainer.appendChild(card);
        });

        if (emptyState) {
          gridContainer.appendChild(emptyState);
        }
      }

      function resetAllFilters() {
        if (keywordInput) keywordInput.value = '';
        const allRadio = document.querySelector('input[name="categoryFilter"][value="all"]');
        if (allRadio) allRadio.checked = true;
        if (priceRange) priceRange.value = priceRange.max;
        driveCheckboxes.forEach(function(cb) { cb.checked = false; });
        if (sortSelect) sortSelect.value = 'featured';
        applyFilters();
        applySorting();
      }

      // Event Listeners
      if (keywordInput) keywordInput.addEventListener('input', applyFilters);
      categoryRadios.forEach(function(r) { r.addEventListener('change', applyFilters); });
      if (priceRange) priceRange.addEventListener('input', applyFilters);
      driveCheckboxes.forEach(function(cb) { cb.addEventListener('change', applyFilters); });
      if (sortSelect) sortSelect.addEventListener('change', applySorting);
      if (resetFiltersBtn) resetFiltersBtn.addEventListener('click', resetAllFilters);
      if (resetEmptyBtn) resetEmptyBtn.addEventListener('click', resetAllFilters);

      // Initial execution
      applyFilters();
      applySorting();
    });
  })();
</script>

<?php get_footer(); ?>