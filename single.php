<?php
/**
 * The template for displaying single blog posts
 *
 * Fully dynamic: Zero dummy/fallback content. All values pull from 
 * WordPress core post data, author profiles, categories, and tags.
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

get_header(); 

// Fetch current post & author data dynamically
the_post();
$author_id      = get_the_author_meta('ID');
$author_name    = get_the_author();
$author_bio     = get_the_author_meta('description');
$author_avatar  = get_avatar_url( $author_id, array( 'size' => 150 ) );
$author_job     = get_user_meta( $author_id, 'dev_nahian_user_job_title', true ); // Optional custom user meta or fallback empty
$categories     = get_the_category();
$cat_name       = ! empty( $categories ) ? esc_html( $categories[0]->name ) : '';
$cat_link       = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : '';
?>

<!-- Internal Single Post CSS Architecture -->
<style id="dev-nahian-single-post-styles">
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
    --dev-nahian-car-radius: 12px;
    --dev-nahian-car-radius-sm: 8px;
    --dev-nahian-car-radius-md: 16px;
  }

  /* Reading Progress Bar */
  #devNahianReadingBar {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    background: var(--dev-nahian-car-gold);
    width: 0%;
    z-index: 99999;
    transition: width 0.1s ease-out;
  }

  .dev-nahian-car-post-wrapper {
    padding: 64px 20px 88px;
    max-width: 1260px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  /* Centered Header with Pill Badge */
  .dev-nahian-car-post-header {
    text-align: center;
    max-width: 820px;
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
    text-decoration: none;
    transition: background-color 0.2s ease;
  }

  .dev-nahian-car-section-badge:hover {
    background: rgba(184, 142, 30, 0.18);
  }

  .dev-nahian-car-badge-pulse {
    width: 6px;
    height: 6px;
    background: var(--dev-nahian-car-gold);
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(184, 142, 30, 0.2);
  }

  .dev-nahian-car-post-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.2;
    margin-bottom: 16px;
  }

  .dev-nahian-car-post-meta-row {
    display: inline-flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 16px 24px;
    font-size: 0.85rem;
    color: var(--dev-nahian-car-text-muted);
    font-weight: 600;
  }

  .dev-nahian-car-post-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .dev-nahian-car-post-meta-item svg {
    color: var(--dev-nahian-car-gold);
  }

  /* Two Column Layout */
  .dev-nahian-car-blog-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 36px;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-blog-layout {
      grid-template-columns: 320px 1fr;
      gap: 48px;
      align-items: start;
    }
  }

  /* LEFT SIDEBAR STYLES */
  .dev-nahian-car-sidebar {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  @media (min-width: 992px) {
    .dev-nahian-car-sidebar {
      position: sticky;
      top: 96px;
    }
  }

  .dev-nahian-car-sidebar-widget {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: 24px;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-widget-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  .dev-nahian-car-widget-title::before {
    content: '';
    width: 4px;
    height: 14px;
    background: var(--dev-nahian-car-gold);
    border-radius: 999px;
  }

  /* Search Widget */
  .dev-nahian-car-search-form {
    position: relative;
    display: flex;
    align-items: center;
  }

  .dev-nahian-car-search-input {
    width: 100%;
    height: 42px;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    background: var(--dev-nahian-car-bg-light);
    padding: 0 40px 0 12px;
    font-size: 0.88rem;
    color: var(--dev-nahian-car-text-dark);
    outline: none;
    transition: border-color 0.2s;
  }

  .dev-nahian-car-search-input:focus {
    border-color: var(--dev-nahian-car-primary);
    background: #ffffff;
  }

  .dev-nahian-car-search-btn {
    position: absolute;
    right: 4px;
    width: 34px;
    height: 34px;
    border: none;
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
  }

  .dev-nahian-car-search-btn:hover {
    background: var(--dev-nahian-car-primary-hover);
  }

  /* Category List Widget */
  .dev-nahian-car-category-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .dev-nahian-car-category-item a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    border-radius: 6px;
    color: var(--dev-nahian-car-text-dark);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-category-item a:hover {
    background: var(--dev-nahian-car-bg-light);
    color: var(--dev-nahian-car-gold);
    transform: translateX(3px);
  }

  .dev-nahian-car-cat-count {
    font-size: 0.72rem;
    color: var(--dev-nahian-car-text-muted);
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    padding: 2px 8px;
    border-radius: 999px;
    font-weight: 700;
  }

  /* Recent Posts Widget */
  .dev-nahian-car-recent-posts {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .dev-nahian-car-recent-post-item {
    display: flex;
    gap: 12px;
    align-items: center;
    text-decoration: none;
  }

  .dev-nahian-car-recent-post-thumb {
    width: 60px;
    height: 60px;
    border-radius: var(--dev-nahian-car-radius-sm);
    overflow: hidden;
    flex-shrink: 0;
    background: #0f172a;
  }

  .dev-nahian-car-recent-post-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .dev-nahian-car-recent-post-item:hover .dev-nahian-car-recent-post-thumb img {
    transform: scale(1.08);
  }

  .dev-nahian-car-recent-post-info h4 {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1.35;
    margin: 0 0 4px;
    transition: color 0.2s;
  }

  .dev-nahian-car-recent-post-item:hover .dev-nahian-car-recent-post-info h4 {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-recent-post-date {
    font-size: 0.75rem;
    color: var(--dev-nahian-car-text-muted);
  }

  /* ARTICLE MAIN CONTENT */
  .dev-nahian-car-article-main {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    padding: clamp(24px, 4vw, 44px);
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
  }

  .dev-nahian-car-featured-lead-img {
    width: 100%;
    height: clamp(280px, 36vw, 460px);
    object-fit: cover;
    border-radius: var(--dev-nahian-car-radius-sm);
    margin-bottom: 32px;
    border: 1px solid var(--dev-nahian-car-border);
    display: block;
  }

  .dev-nahian-car-article-body {
    font-size: 1.02rem;
    color: #334155;
    line-height: 1.8;
  }

  .dev-nahian-car-article-body p {
    margin-bottom: 22px;
  }

  .dev-nahian-car-article-body h2 {
    font-size: clamp(1.4rem, 2.4vw, 1.75rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 36px 0 16px;
    letter-spacing: -0.02em;
  }

  .dev-nahian-car-article-body h3 {
    font-size: clamp(1.2rem, 2vw, 1.45rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 28px 0 12px;
  }

  .dev-nahian-car-article-body a {
    color: var(--dev-nahian-car-gold);
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s ease;
  }

  .dev-nahian-car-article-body a:hover {
    color: var(--dev-nahian-car-gold-hover);
  }

  .dev-nahian-car-table-scroll-wrapper {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 24px;
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-article-body table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.92rem;
  }

  .dev-nahian-car-article-body th,
  .dev-nahian-car-article-body td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--dev-nahian-car-border);
    text-align: left;
  }

  .dev-nahian-car-article-body th {
    background: var(--dev-nahian-car-bg-light);
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
  }

  /* Blockquote */
  .dev-nahian-car-article-quote,
  .dev-nahian-car-article-body blockquote {
    margin: 32px 0;
    padding: 20px 24px;
    background: var(--dev-nahian-car-bg-light);
    border-left: 4px solid var(--dev-nahian-car-gold);
    border-radius: 0 var(--dev-nahian-car-radius-sm) var(--dev-nahian-car-radius-sm) 0;
    font-style: italic;
    font-size: 1.08rem;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1.6;
  }

  /* Tags & Share Strip */
  .dev-nahian-car-tags-share-strip {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding-top: 24px;
    margin-top: 36px;
    border-top: 1px solid var(--dev-nahian-car-border);
  }

  .dev-nahian-car-post-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
  }

  .dev-nahian-car-tag-pill {
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    color: var(--dev-nahian-car-text-muted);
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-tag-pill:hover {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
  }

  .dev-nahian-car-share-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .dev-nahian-car-share-btn {
    width: 36px;
    height: 36px;
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid var(--dev-nahian-car-border);
    background: #ffffff;
    color: var(--dev-nahian-car-text-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-share-btn:hover {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
    transform: translateY(-2px);
  }

  /* Author Box */
  .dev-nahian-car-author-box {
    margin-top: 36px;
    padding: 24px;
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius);
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  @media (min-width: 580px) {
    .dev-nahian-car-author-box {
      flex-direction: row;
      align-items: center;
    }
  }

  .dev-nahian-car-author-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .dev-nahian-car-author-info h3 {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    margin: 0 0 2px;
  }

  .dev-nahian-car-author-role {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--dev-nahian-car-gold);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 6px;
    display: block;
  }

  .dev-nahian-car-author-info p {
    font-size: 0.88rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.6;
    margin: 0;
  }

  /* Post Navigation */
  .dev-nahian-car-post-nav-strip {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
    margin-top: 36px;
    padding-top: 24px;
    border-top: 1px solid var(--dev-nahian-car-border);
  }

  @media (min-width: 580px) {
    .dev-nahian-car-post-nav-strip {
      grid-template-columns: 1fr 1fr;
    }
  }

  .dev-nahian-car-post-nav-link {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-sm);
    padding: 16px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-post-nav-link:hover {
    border-color: var(--dev-nahian-car-primary);
    transform: translateY(-2px);
  }

  .dev-nahian-car-post-nav-dir {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--dev-nahian-car-text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .dev-nahian-car-post-nav-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1.35;
  }
</style>

<!-- Reading Progress Track Indicator -->
<div id="devNahianReadingBar"></div>

<div class="dev-nahian-car-post-wrapper">
  <!-- Centered Post Header -->
  <div class="dev-nahian-car-post-header">
    <?php if ( ! empty( $cat_name ) ) : ?>
      <a href="<?php echo esc_url( $cat_link ); ?>" class="dev-nahian-car-section-badge">
        <span class="dev-nahian-car-badge-pulse"></span>
        <?php echo $cat_name; ?>
      </a>
    <?php endif; ?>

    <h1><?php the_title(); ?></h1>

    <div class="dev-nahian-car-post-meta-row">
      <div class="dev-nahian-car-post-meta-item">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <span>By <strong><?php echo esc_html( $author_name ); ?></strong></span>
      </div>
      <div class="dev-nahian-car-post-meta-item">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
        <span><?php echo get_the_date(); ?></span>
      </div>
      <div class="dev-nahian-car-post-meta-item">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        <span><?php echo ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 ); ?> <?php esc_html_e( 'Min Read', 'dev-nahian-car' ); ?></span>
      </div>
    </div>
  </div>

  <!-- Main Grid Layout -->
  <div class="dev-nahian-car-blog-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="dev-nahian-car-sidebar" aria-label="<?php esc_attr_e( 'Dispatch Sidebar', 'dev-nahian-car' ); ?>">
      
      <!-- WordPress Dynamic Search Widget -->
      <div class="dev-nahian-car-sidebar-widget">
        <h3 class="dev-nahian-car-widget-title"><?php esc_html_e( 'Search Dispatches', 'dev-nahian-car' ); ?></h3>
        <form role="search" method="get" class="dev-nahian-car-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <input type="text" class="dev-nahian-car-search-input" placeholder="<?php esc_attr_e( 'Search keywords...', 'dev-nahian-car' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required>
          <button type="submit" class="dev-nahian-car-search-btn" aria-label="<?php esc_attr_e( 'Search', 'dev-nahian-car' ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </button>
        </form>
      </div>

      <!-- Categories Widget -->
      <div class="dev-nahian-car-sidebar-widget">
        <h3 class="dev-nahian-car-widget-title"><?php esc_html_e( 'Categories', 'dev-nahian-car' ); ?></h3>
        <ul class="dev-nahian-car-category-list">
          <?php
          $all_categories = get_categories( array( 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true ) );
          if ( ! empty( $all_categories ) ) {
              foreach ( $all_categories as $category ) {
                  echo '<li class="dev-nahian-car-category-item"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span>' . esc_html( $category->name ) . '</span><span class="dev-nahian-car-cat-count">' . esc_html( $category->count ) . '</span></a></li>';
              }
          }
          ?>
        </ul>
      </div>

      <!-- Recent Posts Widget -->
      <?php
      $recent_query = new WP_Query( array(
          'post_type'           => 'post',
          'posts_per_page'      => 3,
          'post__not_in'        => array( get_the_ID() ),
          'ignore_sticky_posts' => 1,
      ) );

      if ( $recent_query->have_posts() ) :
      ?>
      <div class="dev-nahian-car-sidebar-widget">
        <h3 class="dev-nahian-car-widget-title"><?php esc_html_e( 'Recent Stories', 'dev-nahian-car' ); ?></h3>
        <div class="dev-nahian-car-recent-posts">
          <?php
          while ( $recent_query->have_posts() ) :
              $recent_query->the_post();
              ?>
              <a href="<?php the_permalink(); ?>" class="dev-nahian-car-recent-post-item">
                <?php if ( has_post_thumbnail() ) : ?>
                  <div class="dev-nahian-car-recent-post-thumb">
                    <?php the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                  </div>
                <?php endif; ?>
                <div class="dev-nahian-car-recent-post-info">
                  <h4><?php the_title(); ?></h4>
                  <span class="dev-nahian-car-recent-post-date"><?php echo get_the_date(); ?></span>
                </div>
              </a>
              <?php
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      </div>
      <?php endif; ?>

    </aside>

    <!-- RIGHT MAIN CONTENT -->
    <article class="dev-nahian-car-article-main" id="articleMainContent">
      <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'large', array( 'class' => 'dev-nahian-car-featured-lead-img', 'alt' => get_the_title() ) ); ?>
      <?php endif; ?>

      <div class="dev-nahian-car-article-body" id="articleBody">
        <?php the_content(); ?>
      </div>

      <!-- Tags & Share -->
      <div class="dev-nahian-car-tags-share-strip">
        <div class="dev-nahian-car-post-tags">
          <?php 
          $tags = get_the_tags();
          if ( $tags ) {
              echo '<span style="font-size: 0.82rem; font-weight: 700; color: var(--dev-nahian-car-text-dark);">' . esc_html__( 'Tags:', 'dev-nahian-car' ) . '</span>';
              foreach( $tags as $tag ) {
                  echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="dev-nahian-car-tag-pill">#' . esc_html( $tag->name ) . '</a>';
              }
          }
          ?>
        </div>

        <div class="dev-nahian-car-share-buttons">
          <span style="font-size: 0.82rem; font-weight: 700; color: var(--dev-nahian-car-text-dark);"><?php esc_html_e( 'Share:', 'dev-nahian-car' ); ?></span>
          <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_the_title() ); ?>&url=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-share-btn" aria-label="<?php esc_attr_e( 'Share on X / Twitter', 'dev-nahian-car' ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="dev-nahian-car-share-btn" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'dev-nahian-car' ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
          </a>
          <button type="button" class="dev-nahian-car-share-btn" id="btnCopyPostLink" aria-label="<?php esc_attr_e( 'Copy Link', 'dev-nahian-car' ); ?>" title="<?php esc_attr_e( 'Copy article link', 'dev-nahian-car' ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
          </button>
        </div>
      </div>

      <!-- Author Box (Rendered only if author bio exists) -->
      <?php if ( ! empty( $author_bio ) ) : ?>
      <div class="dev-nahian-car-author-box">
        <?php if ( ! empty( $author_avatar ) ) : ?>
          <img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="dev-nahian-car-author-avatar">
        <?php endif; ?>
        <div class="dev-nahian-car-author-info">
          <h3><?php echo esc_html( $author_name ); ?></h3>
          <?php if ( ! empty( $author_job ) ) : ?>
            <span class="dev-nahian-car-author-role"><?php echo esc_html( $author_job ); ?></span>
          <?php endif; ?>
          <p><?php echo esc_html( $author_bio ); ?></p>
        </div>
      </div>
      <?php endif; ?>

      <!-- Post Navigation -->
      <div class="dev-nahian-car-post-nav-strip">
        <?php
        $prev_post = get_previous_post();
        if ( ! empty( $prev_post ) ) :
            ?>
            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="dev-nahian-car-post-nav-link">
              <span class="dev-nahian-car-post-nav-dir">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <?php esc_html_e( 'Previous Dispatch', 'dev-nahian-car' ); ?>
              </span>
              <span class="dev-nahian-car-post-nav-title"><?php echo esc_html( $prev_post->post_title ); ?></span>
            </a>
            <?php
        endif;

        $next_post = get_next_post();
        if ( ! empty( $next_post ) ) :
            ?>
            <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="dev-nahian-car-post-nav-link" style="text-align: right;">
              <span class="dev-nahian-car-post-nav-dir" style="justify-content: flex-end;">
                <?php esc_html_e( 'Next Dispatch', 'dev-nahian-car' ); ?>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </span>
              <span class="dev-nahian-car-post-nav-title"><?php echo esc_html( $next_post->post_title ); ?></span>
            </a>
            <?php
        endif;
        ?>
      </div>

    </article>
  </div>
</div>

<!-- Internal Single Post JavaScript Architecture -->
<script id="dev-nahian-single-post-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      // 1. Reading progress bar handler
      const readingBar = document.getElementById('devNahianReadingBar');
      const article = document.getElementById('articleMainContent');

      if (readingBar && article) {
        window.addEventListener('scroll', function() {
          const articleTop = article.offsetTop;
          const articleHeight = article.offsetHeight;
          const windowHeight = window.innerHeight;
          const scrollPos = window.scrollY;

          if (scrollPos < articleTop) {
            readingBar.style.width = '0%';
          } else if (scrollPos > (articleTop + articleHeight - windowHeight)) {
            readingBar.style.width = '100%';
          } else {
            const progress = ((scrollPos - articleTop) / (articleHeight - windowHeight)) * 100;
            readingBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
          }
        }, { passive: true });
      }

      // 2. Wrap content tables for horizontal responsive scrolling
      const bodyContent = document.getElementById('articleBody');
      if (bodyContent) {
        const tables = bodyContent.querySelectorAll('table');
        tables.forEach(function(table) {
          if (!table.parentElement.classList.contains('dev-nahian-car-table-scroll-wrapper')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'dev-nahian-car-table-scroll-wrapper';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
          }
        });

        // External link hardening
        const links = bodyContent.querySelectorAll('a[href^="http"]');
        const host = window.location.hostname;
        links.forEach(function(link) {
          try {
            const linkUrl = new URL(link.href);
            if (linkUrl.hostname !== host) {
              link.setAttribute('target', '_blank');
              link.setAttribute('rel', 'noopener noreferrer');
            }
          } catch(e) {}
        });
      }

      // 3. Clean clipboard share action
      const copyBtn = document.getElementById('btnCopyPostLink');
      if (copyBtn) {
        copyBtn.addEventListener('click', function(e) {
          e.preventDefault();
          if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(window.location.href).then(function() {
              const originalHTML = copyBtn.innerHTML;
              copyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--dev-nahian-car-accent-green)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>';
              setTimeout(function() {
                copyBtn.innerHTML = originalHTML;
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