<?php
/**
 * Template Name: Client Account Console
 * Description: Client console for viewing all booking lists, profile details, and security settings.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.1.0
 */

// 1. Authentication Check
if ( ! is_user_logged_in() ) {
    wp_safe_redirect( wp_login_url( get_permalink() ) );
    exit;
}

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;

// 2. Save Handlers (Profile or Password)
$status_message = '';
$error_message  = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
    // Handle Profile / Preferences Update
    if ( isset( $_POST['dn_account_save_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dn_account_save_nonce'] ) ), 'dn_save_account_action' ) ) {
        
        $first_name = sanitize_text_field( $_POST['acc_first_name'] ?? '' );
        $last_name  = sanitize_text_field( $_POST['acc_last_name'] ?? '' );
        $user_email = sanitize_email( $_POST['acc_email'] ?? '' );

        wp_update_user( array(
            'ID'         => $user_id,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'user_email' => $user_email,
        ) );

        update_user_meta( $user_id, 'dn_driver_phone', sanitize_text_field( $_POST['acc_phone'] ?? '' ) );
        update_user_meta( $user_id, 'dn_driver_license', sanitize_text_field( $_POST['acc_license'] ?? '' ) );
        update_user_meta( $user_id, 'dn_driver_country', sanitize_text_field( $_POST['acc_country'] ?? '' ) );
        
        update_user_meta( $user_id, 'dn_pref_climate', isset( $_POST['pref_climate'] ) ? 1 : 0 );
        update_user_meta( $user_id, 'dn_pref_audio', isset( $_POST['pref_audio'] ) ? 1 : 0 );
        update_user_meta( $user_id, 'dn_pref_deposit_waiver', isset( $_POST['pref_deposit_waiver'] ) ? 1 : 0 );
        
        $status_message = __( 'Changes saved successfully.', 'dev-nahian-car' );
    }

    // Handle Password Change Update
    if ( isset( $_POST['dn_password_save_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dn_password_save_nonce'] ) ), 'dn_save_password_action' ) ) {
        $current_pass = $_POST['current_password'] ?? '';
        $new_pass     = $_POST['new_password'] ?? '';
        $confirm_pass = $_POST['confirm_password'] ?? '';

        if ( empty( $current_pass ) || empty( $new_pass ) || empty( $confirm_pass ) ) {
            $error_message = __( 'Please fill in all password fields.', 'dev-nahian-car' );
        } elseif ( $new_pass !== $confirm_pass ) {
            $error_message = __( 'New passwords do not match.', 'dev-nahian-car' );
        } else {
            $user_data = get_userdata( $user_id );
            if ( $user_data && wp_check_password( $current_pass, $user_data->user_pass, $user_id ) ) {
                wp_set_password( $new_pass, $user_id );
                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );
                $status_message = __( 'Password updated successfully.', 'dev-nahian-car' );
            } else {
                $error_message = __( 'Current password is incorrect.', 'dev-nahian-car' );
            }
        }
    }
}

// 3. User Data Fetching
$first_name   = get_user_meta( $user_id, 'first_name', true );
$last_name    = get_user_meta( $user_id, 'last_name', true );
$display_name = ! empty( $first_name ) ? trim( "$first_name $last_name" ) : $current_user->display_name;
$user_email   = $current_user->user_email;
$phone        = get_user_meta( $user_id, 'dn_driver_phone', true );
$license_num  = get_user_meta( $user_id, 'dn_driver_license', true );
$country      = get_user_meta( $user_id, 'dn_driver_country', true );

$pref_climate = (int) get_user_meta( $user_id, 'dn_pref_climate', true );
$pref_audio   = (int) get_user_meta( $user_id, 'dn_pref_audio', true );
$pref_waiver  = (int) get_user_meta( $user_id, 'dn_pref_deposit_waiver', true );

$avatar_initials = strtoupper( substr( ! empty( $first_name ) ? $first_name : $display_name, 0, 1 ) . substr( ! empty( $last_name ) ? $last_name : '', 0, 1 ) );
if ( empty( trim( $avatar_initials ) ) ) {
    $avatar_initials = strtoupper( substr( $current_user->user_login, 0, 2 ) );
}

// 4. Server-Side Tab Routing (Dashboard, Profile, Password, Preferences)
$active_tab   = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'dashboard';
$allowed_tabs = array( 'dashboard', 'profile', 'password', 'preferences' );
if ( ! in_array( $active_tab, $allowed_tabs, true ) ) {
    $active_tab = 'dashboard';
}

// 5. Query All Bookings for this User
$all_bookings_query = new WP_Query( array(
    'post_type'      => array( 'dev_nahian_rental', 'rental', 'car_booking' ),
    'post_status'    => array( 'publish', 'confirmed', 'active', 'completed' ),
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => '_dn_booking_user_id',
            'value'   => $user_id,
            'compare' => '=',
        ),
    ),
) );

get_header(); 
?>

<style id="dev-nahian-account-styles">
    :root {
        --dn-acc-primary: var(--dev-nahian-car-primary, #111827);
        --dn-acc-hover: var(--dev-nahian-car-primary-hover, #1f2937);
        --dn-acc-gold: var(--dev-nahian-car-gold, #b88e1e);
        --dn-acc-dark: var(--dev-nahian-car-text-dark, #0f172a);
        --dn-acc-muted: var(--dev-nahian-car-text-muted, #64748b);
        --dn-acc-border: var(--dev-nahian-car-border, #e2e8f0);
        --dn-acc-bg: var(--dev-nahian-car-bg-light, #f8fafc);
        --dn-acc-radius: var(--dev-nahian-car-radius, 12px);
        --dn-acc-radius-sm: 8px;
        --dn-acc-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }

    .dashboard-wrapper {
        padding: 56px 20px 88px;
        max-width: 1240px;
        margin: 0 auto;
        color: var(--dn-acc-dark);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .dashboard-header {
        text-align: center;
        max-width: 760px;
        margin: 0 auto 44px;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--dn-acc-gold);
        background: rgba(184, 142, 30, 0.08);
        border: 1px solid rgba(184, 142, 30, 0.25);
        padding: 5px 15px;
        border-radius: 999px;
        margin-bottom: 14px;
    }

    .badge-pulse {
        width: 6px;
        height: 6px;
        background: var(--dn-acc-gold);
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(184, 142, 30, 0.2);
    }

    .dashboard-header h1 {
        font-size: clamp(2rem, 3.5vw, 2.75rem);
        font-weight: 800;
        color: var(--dn-acc-dark);
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0 0 8px;
    }

    .dashboard-header p {
        color: var(--dn-acc-muted);
        font-size: 1.05rem;
        margin: 0 0 20px;
    }

    .driver-ribbon {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        background: #ffffff;
        border: 1px solid var(--dn-acc-border);
        border-radius: 999px;
        padding: 6px 18px 6px 8px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .driver-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--dn-acc-primary);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .driver-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--dn-acc-dark);
        text-align: left;
    }

    .driver-name span {
        display: block;
        font-size: 0.72rem;
        color: #0d9488;
        font-weight: 600;
    }

    .dashboard-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }

    @media (min-width: 992px) {
        .dashboard-layout {
            grid-template-columns: 280px 1fr;
            gap: 36px;
            align-items: start;
        }
    }

    .dash-sidebar {
        background: #ffffff;
        border: 1px solid var(--dn-acc-border);
        border-radius: var(--dn-acc-radius);
        padding: 14px;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
        position: sticky;
        top: 96px;
    }

    .dash-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .dash-nav-btn {
        width: 100%;
        text-align: left;
        background: transparent;
        border: none;
        padding: 11px 14px;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dn-acc-muted);
        border-radius: var(--dn-acc-radius-sm);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: all 0.15s ease;
        box-sizing: border-box;
    }

    .dash-nav-btn:hover {
        background: var(--dn-acc-bg);
        color: var(--dn-acc-dark);
    }

    .dash-nav-btn.is-active {
        background: var(--dn-acc-primary);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
    }

    .dash-nav-btn.is-active svg {
        color: var(--dn-acc-gold);
    }

    .dash-nav-btn svg {
        flex-shrink: 0;
    }

    .pane-card {
        background: #ffffff;
        border: 1px solid var(--dn-acc-border);
        border-radius: var(--dn-acc-radius);
        padding: clamp(20px, 3.5vw, 32px);
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .pane-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--dn-acc-dark);
        margin: 0 0 4px;
    }

    .pane-subtitle {
        font-size: 0.88rem;
        color: var(--dn-acc-muted);
        margin: 0 0 24px;
    }

    .booking-card-item {
        background: var(--dn-acc-bg);
        border: 1px solid var(--dn-acc-border);
        border-radius: var(--dn-acc-radius-sm);
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .booking-details h4 {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dn-acc-dark);
        margin: 0 0 4px;
    }

    .booking-details span {
        font-size: 0.8rem;
        color: var(--dn-acc-muted);
        display: block;
    }

    .booking-status-tag {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 999px;
        background: #f0fdfa;
        color: #0d9488;
        border: 1px solid rgba(13, 148, 136, 0.25);
        text-transform: uppercase;
    }

    .booking-status-tag.completed {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }

    .btn-sm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 20px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s ease;
        border: 1px solid transparent;
        box-sizing: border-box;
    }

    .btn-primary {
        background: var(--dn-acc-primary);
        color: #ffffff;
    }

    .btn-primary:hover {
        background: var(--dn-acc-hover);
    }

    .preference-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        background: var(--dn-acc-bg);
        border: 1px solid var(--dn-acc-border);
        border-radius: var(--dn-acc-radius-sm);
        margin-bottom: 12px;
        gap: 16px;
    }

    .preference-info strong {
        font-size: 0.9rem;
        color: var(--dn-acc-dark);
        display: block;
    }

    .preference-info span {
        font-size: 0.78rem;
        color: var(--dn-acc-muted);
        display: block;
        margin-top: 2px;
        line-height: 1.4;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 18px;
    }

    @media (min-width: 600px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .col-span-full {
            grid-column: span 2;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--dn-acc-dark);
    }

    .input-control {
        width: 100%;
        height: 44px;
        border: 1px solid var(--dn-acc-border);
        border-radius: var(--dn-acc-radius-sm);
        padding: 0 14px;
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--dn-acc-dark);
        background: var(--dn-acc-bg);
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.15s, background-color 0.15s;
    }

    .input-control:focus {
        border-color: var(--dn-acc-primary);
        background: #ffffff;
    }

    .alert-banner {
        padding: 12px 16px;
        border-radius: var(--dn-acc-radius-sm);
        background: #f0fdf4;
        border: 1px solid #86efac;
        color: #166534;
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .error-banner {
        padding: 12px 16px;
        border-radius: var(--dn-acc-radius-sm);
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 24px;
    }
</style>

<div class="dashboard-wrapper">

    <!-- Header Section -->
    <header class="dashboard-header">
        <div class="section-badge">
            <span class="badge-pulse"></span>
            <?php printf( esc_html__( 'Account ID #%s', 'dev-nahian-car' ), esc_html( str_pad( (string) $user_id, 5, '0', STR_PAD_LEFT ) ) ); ?>
        </div>
        <h1><?php esc_html_e( 'Client', 'dev-nahian-car' ); ?> <span><?php esc_html_e( 'Console', 'dev-nahian-car' ); ?></span></h1>
        <p><?php esc_html_e( 'Manage your bookings, profile settings, and credentials.', 'dev-nahian-car' ); ?></p>

        <div class="driver-ribbon">
            <div class="driver-avatar"><?php echo esc_html( $avatar_initials ); ?></div>
            <div class="driver-name">
                <?php echo esc_html( $display_name ); ?>
                <span><?php esc_html_e( 'Active Member', 'dev-nahian-car' ); ?></span>
            </div>
        </div>
    </header>

    <?php if ( ! empty( $status_message ) ) : ?>
        <div class="alert-banner">
            <?php echo esc_html( $status_message ); ?>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $error_message ) ) : ?>
        <div class="error-banner">
            <?php echo esc_html( $error_message ); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-layout">
        
        <!-- Sidebar Navigation -->
        <aside class="dash-sidebar" aria-label="<?php esc_attr_e( 'Account Menu', 'dev-nahian-car' ); ?>">
            <nav class="dash-nav-list">
                <?php
                $nav_items = array(
                    'dashboard'   => array( 'label' => __( 'Dashboard', 'dev-nahian-car' ),       'icon' => '<rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect>' ),
                    'profile'     => array( 'label' => __( 'Profile', 'dev-nahian-car' ),         'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>' ),
                    'password'    => array( 'label' => __( 'Change Password', 'dev-nahian-car' ), 'icon' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>' ),
                    'preferences' => array( 'label' => __( 'Preferences', 'dev-nahian-car' ),     'icon' => '<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>' ),
                );

                foreach ( $nav_items as $tab_key => $tab_data ) :
                    $is_current = ( $active_tab === $tab_key );
                    $tab_url    = add_query_arg( 'tab', $tab_key, get_permalink() );
                    ?>
                    <a href="<?php echo esc_url( $tab_url ); ?>" class="dash-nav-btn <?php echo $is_current ? 'is-active' : ''; ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <?php echo $tab_data['icon']; ?>
                        </svg>
                        <?php echo esc_html( $tab_data['label'] ); ?>
                    </a>
                <?php endforeach; ?>

                <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="dash-nav-btn" style="color: #dc2626; margin-top: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <?php esc_html_e( 'Sign Out', 'dev-nahian-car' ); ?>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="dash-content-area">

            <!-- TAB: DASHBOARD (SHOWS ALL BOOKINGS) -->
            <?php if ( 'dashboard' === $active_tab ) : ?>
                <div class="pane-card">
                    <h2 class="pane-title"><?php esc_html_e( 'All Bookings', 'dev-nahian-car' ); ?></h2>
                    <p class="pane-subtitle"><?php esc_html_e( 'Comprehensive list of your active and past vehicle reservations.', 'dev-nahian-car' ); ?></p>
                    
                    <?php if ( $all_bookings_query->have_posts() ) : ?>
                        <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 16px;">
                            <?php while ( $all_bookings_query->have_posts() ) : $all_bookings_query->the_post(); 
                                $car_id     = get_post_meta( get_the_ID(), '_dn_car_assigned_id', true );
                                $car_title  = $car_id ? get_the_title( $car_id ) : get_the_title();
                                $dates      = get_post_meta( get_the_ID(), '_dn_rental_dates', true );
                                $total      = get_post_meta( get_the_ID(), '_dn_booking_total', true );
                                $status     = get_post_meta( get_the_ID(), '_dn_booking_status', true );
                                $status_lbl = ! empty( $status ) ? ucfirst( $status ) : 'Active';
                                $is_comp    = ( 'completed' === strtolower( $status ) );
                            ?>
                                <div class="booking-card-item">
                                    <div class="booking-details">
                                        <h4><?php echo esc_html( $car_title ); ?></h4>
                                        <span><?php echo esc_html( ! empty( $dates ) ? $dates : get_the_date() ); ?> &bull; <strong><?php echo esc_html( ! empty( $total ) ? $total : '$0.00' ); ?></strong></span>
                                    </div>
                                    <div>
                                        <span class="booking-status-tag <?php echo $is_comp ? 'completed' : ''; ?>">&bull; <?php echo esc_html( $status_lbl ); ?></span>
                                    </div>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    <?php else : ?>
                        <div style="text-align: center; padding: 32px 20px; background: var(--dn-acc-bg); border-radius: 8px; border: 1px solid var(--dn-acc-border);">
                            <p style="margin: 0 0 14px; color: var(--dn-acc-muted);"><?php esc_html_e( 'No bookings found in your account ledger.', 'dev-nahian-car' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/cars/' ) ); ?>" class="btn-sm btn-primary"><?php esc_html_e( 'Explore Fleet', 'dev-nahian-car' ); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- TAB: PROFILE -->
            <?php if ( 'profile' === $active_tab ) : ?>
                <div class="pane-card">
                    <form method="post" action="<?php echo esc_url( add_query_arg( 'tab', 'profile', get_permalink() ) ); ?>">
                        <?php wp_nonce_field( 'dn_save_account_action', 'dn_account_save_nonce' ); ?>

                        <h2 class="pane-title"><?php esc_html_e( 'Driver Profile & Credentials', 'dev-nahian-car' ); ?></h2>
                        <p class="pane-subtitle"><?php esc_html_e( 'Update your official personal details and driver licenses.', 'dev-nahian-car' ); ?></p>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="acc_first_name"><?php esc_html_e( 'First Name', 'dev-nahian-car' ); ?></label>
                                <input type="text" class="input-control" id="acc_first_name" name="acc_first_name" value="<?php echo esc_attr( $first_name ); ?>" placeholder="e.g. John" required>
                            </div>

                            <div class="form-group">
                                <label for="acc_last_name"><?php esc_html_e( 'Last Name', 'dev-nahian-car' ); ?></label>
                                <input type="text" class="input-control" id="acc_last_name" name="acc_last_name" value="<?php echo esc_attr( $last_name ); ?>" placeholder="e.g. Doe" required>
                            </div>

                            <div class="form-group">
                                <label for="acc_email"><?php esc_html_e( 'Email', 'dev-nahian-car' ); ?></label>
                                <input type="email" class="input-control" id="acc_email" name="acc_email" value="<?php echo esc_attr( $user_email ); ?>" placeholder="e.g. name@example.com" required>
                            </div>

                            <div class="form-group">
                                <label for="acc_phone"><?php esc_html_e( 'Phone', 'dev-nahian-car' ); ?></label>
                                <input type="tel" class="input-control" id="acc_phone" name="acc_phone" value="<?php echo esc_attr( $phone ); ?>" placeholder="+1 (555) 000-0000">
                            </div>

                            <div class="form-group">
                                <label for="acc_license"><?php esc_html_e( 'License Number', 'dev-nahian-car' ); ?></label>
                                <input type="text" class="input-control" id="acc_license" name="acc_license" value="<?php echo esc_attr( $license_num ); ?>" placeholder="e.g. DL-0000000">
                            </div>

                            <div class="form-group">
                                <label for="acc_country"><?php esc_html_e( 'Country / State', 'dev-nahian-car' ); ?></label>
                                <input type="text" class="input-control" id="acc_country" name="acc_country" value="<?php echo esc_attr( $country ); ?>" placeholder="e.g. United States">
                            </div>
                        </div>

                        <div style="margin-top: 24px;">
                            <button type="submit" class="btn-sm btn-primary" style="height: 44px;">
                                <?php esc_html_e( 'Save Profile Changes', 'dev-nahian-car' ); ?>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- TAB: CHANGE PASSWORD -->
            <?php if ( 'password' === $active_tab ) : ?>
                <div class="pane-card">
                    <form method="post" action="<?php echo esc_url( add_query_arg( 'tab', 'password', get_permalink() ) ); ?>">
                        <?php wp_nonce_field( 'dn_save_password_action', 'dn_password_save_nonce' ); ?>

                        <h2 class="pane-title"><?php esc_html_e( 'Change Password', 'dev-nahian-car' ); ?></h2>
                        <p class="pane-subtitle"><?php esc_html_e( 'Secure your account with a strong passphrase.', 'dev-nahian-car' ); ?></p>

                        <div class="form-grid">
                            <div class="form-group col-span-full">
                                <label for="current_password"><?php esc_html_e( 'Current Password', 'dev-nahian-car' ); ?></label>
                                <input type="password" class="input-control" id="current_password" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password"><?php esc_html_e( 'New Password', 'dev-nahian-car' ); ?></label>
                                <input type="password" class="input-control" id="new_password" name="new_password" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password"><?php esc_html_e( 'Confirm New Password', 'dev-nahian-car' ); ?></label>
                                <input type="password" class="input-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>

                        <div style="margin-top: 24px;">
                            <button type="submit" class="btn-sm btn-primary" style="height: 44px;">
                                <?php esc_html_e( 'Update Password', 'dev-nahian-car' ); ?>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- TAB: PREFERENCES -->
            <?php if ( 'preferences' === $active_tab ) : ?>
                <div class="pane-card">
                    <form method="post" action="<?php echo esc_url( add_query_arg( 'tab', 'preferences', get_permalink() ) ); ?>">
                        <?php wp_nonce_field( 'dn_save_account_action', 'dn_account_save_nonce' ); ?>

                        <h2 class="pane-title"><?php esc_html_e( 'Preferences', 'dev-nahian-car' ); ?></h2>
                        <p class="pane-subtitle"><?php esc_html_e( 'Customize your car handover options.', 'dev-nahian-car' ); ?></p>

                        <div class="preference-row">
                            <div class="preference-info">
                                <strong><?php esc_html_e( 'AC / Heater Ready', 'dev-nahian-car' ); ?></strong>
                                <span><?php esc_html_e( 'Turn on car temperature controls 15 minutes before arrival.', 'dev-nahian-car' ); ?></span>
                            </div>
                            <input type="checkbox" name="pref_climate" value="1" <?php checked( $pref_climate, 1 ); ?> style="accent-color: var(--dn-acc-primary); width: 18px; height: 18px;">
                        </div>

                        <div class="preference-row">
                            <div class="preference-info">
                                <strong><?php esc_html_e( 'Audio Pairing', 'dev-nahian-car' ); ?></strong>
                                <span><?php esc_html_e( 'Connect phone music automatically when you enter the car.', 'dev-nahian-car' ); ?></span>
                            </div>
                            <input type="checkbox" name="pref_audio" value="1" <?php checked( $pref_audio, 1 ); ?> style="accent-color: var(--dn-acc-primary); width: 18px; height: 18px;">
                        </div>

                        <div class="preference-row">
                            <div class="preference-info">
                                <strong><?php esc_html_e( 'Zero Deposit', 'dev-nahian-car' ); ?></strong>
                                <span><?php esc_html_e( 'Skip hold deposits using your verified account history.', 'dev-nahian-car' ); ?></span>
                            </div>
                            <input type="checkbox" name="pref_deposit_waiver" value="1" <?php checked( $pref_waiver, 1 ); ?> style="accent-color: var(--dn-acc-primary); width: 18px; height: 18px;">
                        </div>

                        <div style="margin-top: 24px;">
                            <button type="submit" class="btn-sm btn-primary" style="height: 44px;">
                                <?php esc_html_e( 'Save Preferences', 'dev-nahian-car' ); ?>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<?php get_footer(); ?>