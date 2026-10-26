<?php
/**
 * The template for displaying the Blog Archive (Journal)
 *
 * Fully dynamic: Pulls header copy, badges, and category controls
 * from the Dev Nahian Settings > Pages > Blogs tab.
 *
 * @package Veloce_Prestige_Mobility
 * @since 1.0.0
 */

get_header(); 

// 1. Fetch Dynamic Settings from Blogs Sub-Tab
$badge          = get_option( 'dev_nahian_blogs_badge', 'Editorial Dispatch' );
$title          = get_option( 'dev_nahian_blogs_title', 'The Veloce <span>Journal</span>' );
$subtitle       = get_option( 'dev_nahian_blogs_subtitle', 'Driving mechanics, coastal itineraries, 800V fast-charging architectures, and perspectives from our test pilots.' );
$show_categories = (int) get_option( 'dev_nahian_blogs_show_categories', 1 );

// Contextual title fallback for specific category/tag/author archives
if ( is_category() ) {
    $badge    = __( 'Category Archive', 'dev-nahian-car' );
    $title    = single_cat_title( '', false );
    $subtitle = category_description() ? strip_tags( category_description() ) : $subtitle;
} elseif ( is_tag() ) {
    $badge    = __( 'Tag Archive', 'dev-nahian-car' );
    $title    = single_tag_title( '', false );
    $subtitle = tag_description() ? strip_tags( tag_description() ) : $subtitle;
} elseif ( is_author() ) {
    $badge    = __( 'Author Dispatch', 'dev-nahian-car' );
    $title    = get_the_author();
    $subtitle = sprintf( __( 'All editorial publications by %s.', 'dev-nahian-car' ), get_the_author() );
}
?>

<!-- Internal Blog Archive CSS Architecture -->
<style id="dev-nahian-blogs-styles">
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
    --dev-nahian-car-radius-lg: 16px;
    --dev-nahian-car-radius-sm: 8px;
  }

  .dev-nahian-car-blog-wrapper {
    padding: 64px 20px 96px;
    max-width: 1240px;
    margin: 0 auto;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  /* Centered Header */
  .dev-nahian-car-blog-header {
    text-align: center;
    max-width: 720px;
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

  .dev-nahian-car-blog-header h1 {
    font-size: clamp(2.1rem, 3.8vw, 2.85rem);
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 14px;
  }

  .dev-nahian-car-blog-header h1 span {
    color: var(--dev-nahian-car-gold);
  }

  .dev-nahian-car-blog-header p {
    color: var(--dev-nahian-car-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
  }

  /* Category Filter Pills */
  .dev-nahian-car-cat-strip {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 44px;
  }

  @media (max-width: 640px) {
    .dev-nahian-car-cat-strip {
      flex-wrap: nowrap;
      overflow-x: auto;
      justify-content: flex-start;
      padding-bottom: 8px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }
    .dev-nahian-car-cat-strip::-webkit-scrollbar {
      display: none;
    }
  }

  .dev-nahian-car-cat-chip {
    background: var(--dev-nahian-car-bg-light);
    border: 1px solid var(--dev-nahian-car-border);
    color: var(--dev-nahian-car-text-muted);
    font-size: 0.85rem;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 999px;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-cat-chip:hover,
  .dev-nahian-car-cat-chip.active {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
  }

  /* Blog Cards Grid */
  .dev-nahian-car-blog-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 28px;
  }

  @media (min-width: 640px) {
    .dev-nahian-car-blog-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1024px) {
    .dev-nahian-car-blog-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .dev-nahian-car-blog-card {
    background: #ffffff;
    border: 1px solid var(--dev-nahian-car-border);
    border-radius: var(--dev-nahian-car-radius-lg);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    opacity: 0;
    transform: translateY(20px);
    transition: transform 0.4s ease, box-shadow 0.25s ease, opacity 0.4s ease;
  }

  .dev-nahian-car-blog-card.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  .dev-nahian-car-blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.1);
  }

  .dev-nahian-car-card-thumb {
    height: 220px;
    position: relative;
    overflow: hidden;
    background: #0f172a;
  }

  .dev-nahian-car-card-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
  }

  .dev-nahian-car-blog-card:hover .dev-nahian-car-card-thumb img {
    transform: scale(1.06);
  }

  .dev-nahian-car-cat-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 4px 12px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .dev-nahian-car-card-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }

  .dev-nahian-car-article-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    color: var(--dev-nahian-car-text-muted);
    font-weight: 600;
    margin-bottom: 10px;
  }

  .dev-nahian-car-card-title {
    font-size: 1.22rem;
    font-weight: 800;
    color: var(--dev-nahian-car-text-dark);
    line-height: 1.35;
    margin: 0 0 10px;
  }

  .dev-nahian-car-card-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .dev-nahian-car-card-title a:hover {
    color: var(--dev-nahian-car-gold) !important;
  }

  .dev-nahian-car-card-excerpt {
    font-size: 0.92rem;
    color: var(--dev-nahian-car-text-muted);
    line-height: 1.6;
    margin: 0 0 20px;
    flex-grow: 1;
  }

  .dev-nahian-car-card-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.86rem;
    font-weight: 700;
    color: var(--dev-nahian-car-text-dark);
    text-decoration: none;
    margin-top: auto;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-card-link:hover {
    color: var(--dev-nahian-car-gold);
    gap: 10px;
  }

  /* Pagination Bar */
  .dev-nahian-car-pagination-wrap {
    margin-top: 56px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
  }

  .dev-nahian-car-pagination-wrap a,
  .dev-nahian-car-pagination-wrap span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    border-radius: var(--dev-nahian-car-radius-sm);
    border: 1px solid var(--dev-nahian-car-border);
    background: #ffffff;
    color: var(--dev-nahian-car-text-dark);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 700;
    transition: all 0.2s ease;
  }

  .dev-nahian-car-pagination-wrap a:hover {
    background: var(--dev-nahian-car-bg-light);
    border-color: var(--dev-nahian-car-primary);
  }

  .dev-nahian-car-pagination-wrap .current {
    background: var(--dev-nahian-car-primary);
    color: #ffffff;
    border-color: var(--dev-nahian-car-primary);
  }
</style>

<div class="dev-nahian-car-blog-wrapper">
  <!-- Header -->
  <div class="dev-nahian-car-blog-header">
    <?php if ( ! empty( $badge ) ) : ?>
      <div class="dev-nahian-car-section-badge">
        <span class="dev-nahian-car-badge-pulse"></span>
        <?php echo esc_html( $badge ); ?>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $title ) ) : ?>
      <h1><?php echo wp_kses( $title, array( 'span' => array() ) ); ?></h1>
    <?php endif; ?>

    <?php if ( ! empty( $subtitle ) ) : ?>
      <p><?php echo esc_html( $subtitle ); ?></p>
    <?php endif; ?>
  </div>

  <!-- Dynamic Category Filter Navigation -->
  <?php if ( $show_categories === 1 ) : 
    $blog_page_id = (int) get_option( 'page_for_posts' );
    $blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/blog/' );
    $all_cats     = get_categories( array( 'hide_empty' => true ) );

    if ( ! empty( $all_cats ) ) :
  ?>
    <nav class="dev-nahian-car-cat-strip" aria-label="<?php esc_attr_e( 'Article categories', 'dev-nahian-car' ); ?>">
      <a href="<?php echo esc_url( $blog_url ); ?>" class="dev-nahian-car-cat-chip <?php echo ( ! is_category() ) ? 'active' : ''; ?>">
        <?php esc_html_e( 'All Entries', 'dev-nahian-car' ); ?>
      </a>
      <?php foreach ( $all_cats as $category ) : ?>
        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="dev-nahian-car-cat-chip <?php echo ( is_category( $category->term_id ) ) ? 'active' : ''; ?>">
          <?php echo esc_html( $category->name ); ?> (<?php echo esc_html( $category->count ); ?>)
        </a>
      <?php endforeach; ?>
    </nav>
  <?php endif; endif; ?>

  <!-- WordPress Dynamic Loop Grid -->
  <div class="dev-nahian-car-blog-grid">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            
            // Extract post category
            $categories = get_the_category();
            $cat_name   = ! empty( $categories ) ? esc_html( $categories[0]->name ) : __( 'General', 'dev-nahian-car' );

            // Estimated reading time calculation (approx 200 words per minute)
            $content_words = str_word_count( wp_strip_all_tags( get_the_content() ) );
            $reading_time  = max( 1, ceil( $content_words / 200 ) );
            ?>
            <article class="dev-nahian-car-blog-card" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <?php if ( has_post_thumbnail() ) : ?>
                <div class="dev-nahian-car-card-thumb">
                  <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                    <?php the_post_thumbnail( 'large', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                  </a>
                  <span class="dev-nahian-car-cat-badge"><?php echo $cat_name; ?></span>
                </div>
              <?php endif; ?>
              
              <div class="dev-nahian-car-card-body">
                <div class="dev-nahian-car-article-meta">
                  <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></time>
                  <span>&bull;</span>
                  <span><?php echo esc_html( $reading_time ); ?> <?php esc_html_e( 'min read', 'dev-nahian-car' ); ?></span>
                </div>
                <h2 class="dev-nahian-car-card-title">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h2>
                <p class="dev-nahian-car-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 16, '...' ); ?></p>
                <a href="<?php the_permalink(); ?>" class="dev-nahian-car-card-link">
                  <?php esc_html_e( 'Read Story', 'dev-nahian-car' ); ?>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
              </div>
            </article>
            <?php
        endwhile;
    else :
        ?>
        <p style="text-align: center; grid-column: 1 / -1; color: var(--dev-nahian-car-text-muted); padding: 48px 0;">
            <?php esc_html_e( 'No entries found within the editorial dispatch.', 'dev-nahian-car' ); ?>
        </p>
        <?php
    endif;
    ?>
  </div>

  <!-- WordPress Numeric Pagination -->
  <?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav class="dev-nahian-car-pagination-wrap" aria-label="<?php esc_attr_e( 'Journal Page Navigation', 'dev-nahian-car' ); ?>">
      <?php
      echo paginate_links( array(
          'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>',
          'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>',
          'type'      => 'plain',
      ) );
      ?>
    </nav>
  <?php endif; ?>
</div>

<!-- Internal Blog Archive JavaScript Architecture -->
<script id="dev-nahian-blogs-js">
  (function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.dev-nahian-car-blog-card');

      if (cards.length > 0 && 'IntersectionObserver' in window) {
        const cardObserver = new IntersectionObserver(function(entries, observer) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              observer.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.1,
          rootMargin: '0px 0px -30px 0px'
        });

        cards.forEach(function(card) {
          cardObserver.observe(card);
        });
      } else {
        cards.forEach(function(card) {
          card.classList.add('is-visible');
        });
      }
    });
  })();
</script>

<?php 
get_footer(); 
?>