<?php
/**
 * Settings Sub-Tab: Pages > Fleet Gallery
 * Converted to full page-load architecture with professional SaaS UI/UX cards,
 * structured visual grouping, and collapsible accordion cards.
 *
 * @package Dev_Nahian_Fleet_Manager
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Dedicated Direct Save Handler for Gallery Sub-Tab
 */
function dev_nahian_save_subtab_gallery_data( $data ) {
    $active_tab    = $data['dev_nahian_active_tab_tracker'] ?? '';
    $active_subtab = $data['dev_nahian_active_subtab_tracker'] ?? '';

    if ( 'pages' !== $active_tab || 'gallery' !== $active_subtab ) {
        return;
    }

    // Visibility Switch
    update_option( 'dev_nahian_gallery_show_section', isset( $data['dev_nahian_gallery_show_section'] ) ? 1 : 0 );

    // Basic text options
    update_option( 'dev_nahian_gallery_badge', sanitize_text_field( $data['dev_nahian_gallery_badge'] ?? '' ) );
    update_option( 'dev_nahian_gallery_title', wp_kses( $data['dev_nahian_gallery_title'] ?? '', array( 'span' => array() ) ) );
    update_option( 'dev_nahian_gallery_desc', sanitize_textarea_field( $data['dev_nahian_gallery_desc'] ?? '' ) );

    // 1. Process Categories Repeater
    $categories = array();
    if ( isset( $data['gallery_cat_slug'] ) && is_array( $data['gallery_cat_slug'] ) ) {
        $count = count( $data['gallery_cat_slug'] );
        for ( $c = 0; $c < $count; $c++ ) {
            $slug  = sanitize_key( $data['gallery_cat_slug'][$c] ?? '' );
            $label = sanitize_text_field( $data['gallery_cat_label'][$c] ?? '' );
            if ( ! empty( $slug ) || ! empty( $label ) ) {
                $categories[] = array(
                    'slug'  => ! empty( $slug ) ? $slug : sanitize_key( $label ),
                    'label' => ! empty( $label ) ? $label : ucfirst( $slug ),
                );
            }
        }
    }
    update_option( 'dev_nahian_gallery_categories_data', $categories );

    // 2. Process Photos Repeater
    $items = array();
    if ( isset( $data['gallery_item_image'] ) && is_array( $data['gallery_item_image'] ) ) {
        $count = count( $data['gallery_item_image'] );
        for ( $i = 0; $i < $count; $i++ ) {
            $img = esc_url_raw( trim( $data['gallery_item_image'][$i] ?? '' ) );
            if ( ! empty( $img ) ) {
                $items[] = array(
                    'image'    => $img,
                    'title'    => sanitize_text_field( $data['gallery_item_title'][$i] ?? '' ),
                    'category' => sanitize_key( $data['gallery_item_category'][$i] ?? 'all' ),
                );
            }
        }
    }
    update_option( 'dev_nahian_gallery_items_data', $items );
}
add_action( 'dev_nahian_save_settings_data', 'dev_nahian_save_subtab_gallery_data', 10, 1 );

/**
 * 2. Render Sub-Tab Panel
 */
function dev_nahian_render_subtab_gallery_panel( $active_subtab ) {
    if ( 'gallery' !== $active_subtab ) {
        return;
    }

    $show_section = (int) get_option( 'dev_nahian_gallery_show_section', 1 );
    $badge_val    = get_option( 'dev_nahian_gallery_badge', '' );
    $title_val    = get_option( 'dev_nahian_gallery_title', '' );
    $desc_val     = get_option( 'dev_nahian_gallery_desc', '' );

    $saved_cats   = get_option( 'dev_nahian_gallery_categories_data', array() );
    if ( ! is_array( $saved_cats ) ) {
        $saved_cats = array();
    }

    $gallery_list = get_option( 'dev_nahian_gallery_items_data', array() );
    if ( ! is_array( $gallery_list ) ) {
        $gallery_list = array();
    }
    ?>
    <style>
        /* Professional SaaS Accordion UI Framework Styles */
        .dn-accordion-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dn-accordion-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px -2px rgba(15, 23, 42, 0.05);
        }
        .dn-accordion-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1px solid transparent;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease;
        }
        .dn-accordion-card.is-open .dn-accordion-header {
            background: #f1f5f9;
            border-bottom-color: #e2e8f0;
        }
        .dn-accordion-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dn-accordion-title-wrap strong {
            font-size: 14.5px;
            font-weight: 800;
            color: #0f172a;
        }
        .dn-accordion-title-wrap span {
            font-size: 12px;
            color: #64748b;
        }
        .dn-accordion-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .dn-accordion-chevron {
            font-size: 16px;
            font-weight: bold;
            color: #64748b;
            transition: transform 0.25s ease;
        }
        .dn-accordion-card.is-open .dn-accordion-chevron {
            transform: rotate(180deg);
        }
        .dn-accordion-body {
            display: none;
            padding: 24px 28px;
            background: #ffffff;
        }
        .dn-accordion-card.is-open .dn-accordion-body {
            display: block;
        }
        .dev-nahian-field-box label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            margin-bottom: 6px !important;
        }
        .dev-nahian-input, .dev-nahian-select, .dev-nahian-textarea {
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 0 14px !important;
            font-size: 13.5px !important;
            transition: all 0.2s ease !important;
        }
        .dev-nahian-input:focus, .dev-nahian-select:focus, .dev-nahian-textarea:focus {
            background: #ffffff !important;
            border-color: #0f172a !important;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08) !important;
        }
        .dev-nahian-textarea {
            padding: 10px 14px !important;
        }
    </style>

    <div id="subtab-panel-gallery">

        <!-- SECTION 1: HEADER SETTINGS -->
        <div class="dn-accordion-card is-open">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '1. Header Settings', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Configure badge, headline, and subtitle intro.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right" onclick="event.stopPropagation();">
                    <label class="dev-nahian-switch" title="Toggle Section Visibility">
                        <input type="checkbox" name="dev_nahian_gallery_show_section" value="1" <?php checked( $show_section, 1 ); ?>>
                        <span class="dev-nahian-slider"></span>
                    </label>
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div class="dev-nahian-grid-2">
                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_gallery_badge"><?php esc_html_e( 'Badge Text', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_gallery_badge" name="dev_nahian_gallery_badge" class="dev-nahian-input" value="<?php echo esc_attr( $badge_val ); ?>" placeholder="e.g. Visual Showcase">
                    </div>

                    <div class="dev-nahian-field-box">
                        <label for="dev_nahian_gallery_title"><?php esc_html_e( 'Headline', 'dev-nahian-car' ); ?></label>
                        <input type="text" id="dev_nahian_gallery_title" name="dev_nahian_gallery_title" class="dev-nahian-input" value="<?php echo esc_attr( $title_val ); ?>" placeholder="e.g. The Fleet <span>Gallery</span>">
                    </div>

                    <div class="dev-nahian-field-box dev-nahian-grid-full">
                        <label for="dev_nahian_gallery_desc"><?php esc_html_e( 'Subtitle', 'dev-nahian-car' ); ?></label>
                        <textarea id="dev_nahian_gallery_desc" name="dev_nahian_gallery_desc" class="dev-nahian-textarea" placeholder="Enter header subtitle..."><?php echo esc_textarea( $desc_val ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: CATEGORY FILTERS REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '2. Category Filters', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Filter slugs and display names for gallery sorting.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_cat_btn" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add Category', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_cat_repeater_wrap" style="display: flex; flex-direction: column; gap: 10px;">
                    <?php if ( ! empty( $saved_cats ) ) : ?>
                        <?php foreach ( $saved_cats as $cat ) : ?>
                            <div class="dn-cat-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: grid; grid-template-columns: 1fr 1fr 40px; gap: 12px; align-items: center;">
                                <div class="dev-nahian-field-box">
                                    <label><?php esc_html_e( 'Category Slug', 'dev-nahian-car' ); ?></label>
                                    <input type="text" name="gallery_cat_slug[]" class="dev-nahian-input dn-cat-slug-input" value="<?php echo esc_attr( $cat['slug'] ?? '' ); ?>" placeholder="e.g. sports">
                                </div>
                                <div class="dev-nahian-field-box">
                                    <label><?php esc_html_e( 'Category Name', 'dev-nahian-car' ); ?></label>
                                    <input type="text" name="gallery_cat_label[]" class="dev-nahian-input dn-cat-label-input" value="<?php echo esc_attr( $cat['label'] ?? '' ); ?>" placeholder="e.g. Supercars">
                                </div>
                                <div style="align-self: flex-end;">
                                    <button type="button" class="dn-remove-cat-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="<?php esc_attr_e( 'Delete', 'dev-nahian-car' ); ?>">&times;</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- SECTION 3: GALLERY PHOTOS REPEATER -->
        <div class="dn-accordion-card">
            <div class="dn-accordion-header">
                <div class="dn-accordion-title-wrap">
                    <strong><?php esc_html_e( '3. Gallery Photos', 'dev-nahian-car' ); ?></strong>
                    <span><?php esc_html_e( 'Showcase grid photo assets and category tags.', 'dev-nahian-car' ); ?></span>
                </div>
                <div class="dn-accordion-right">
                    <span class="dn-accordion-chevron">&#9662;</span>
                </div>
            </div>
            <div class="dn-accordion-body">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                    <button type="button" class="dev-nahian-media-btn" id="dn_add_gallery_item" style="background: #0f172a; color: #fff; border-color: #0f172a;">
                        + <?php esc_html_e( 'Add Photo', 'dev-nahian-car' ); ?>
                    </button>
                </div>

                <div id="dn_gallery_repeater_wrap" style="display: flex; flex-direction: column; gap: 14px;">
                    <?php if ( ! empty( $gallery_list ) ) : ?>
                        <?php foreach ( $gallery_list as $item ) : ?>
                            <div class="dn-gallery-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; display: grid; grid-template-columns: 80px 1fr 200px 40px; gap: 14px; align-items: center;">
                                <div style="width: 80px; height: 56px; border-radius: 6px; overflow: hidden; background: #e2e8f0; border: 1px solid #cbd5e1;">
                                    <img src="<?php echo esc_url( $item['image'] ?? '' ); ?>" style="width: 100%; height: 100%; object-fit: cover; <?php echo empty( $item['image'] ) ? 'display:none;' : ''; ?>" class="dn-preview-img" alt="Preview">
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Image URL', 'dev-nahian-car' ); ?></label>
                                        <div style="display: flex; gap: 6px;">
                                            <input type="text" name="gallery_item_image[]" class="dev-nahian-input dn-img-url" value="<?php echo esc_attr( $item['image'] ?? '' ); ?>" placeholder="https://example.com/photo.jpg">
                                            <button type="button" class="dev-nahian-media-btn dn-upload-row-btn" style="flex-shrink: 0;"><?php esc_html_e( 'Upload', 'dev-nahian-car' ); ?></button>
                                        </div>
                                    </div>
                                    <div class="dev-nahian-field-box">
                                        <label><?php esc_html_e( 'Photo Title', 'dev-nahian-car' ); ?></label>
                                        <input type="text" name="gallery_item_title[]" class="dev-nahian-input" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="e.g. Aerodynamic Carbon Rear Wing">
                                    </div>
                                </div>

                                <div class="dev-nahian-field-box">
                                    <label><?php esc_html_e( 'Category', 'dev-nahian-car' ); ?></label>
                                    <select name="gallery_item_category[]" class="dev-nahian-select dn-cat-select">
                                        <option value=""><?php esc_html_e( '-- Select Category --', 'dev-nahian-car' ); ?></option>
                                        <?php foreach ( $saved_cats as $c ) : ?>
                                            <option value="<?php echo esc_attr( $c['slug'] ?? '' ); ?>" <?php selected( $item['category'] ?? '', $c['slug'] ?? '' ); ?>>
                                                <?php echo esc_html( $c['label'] ?? '' ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <button type="button" class="dn-remove-gallery-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="<?php esc_attr_e( 'Delete', 'dev-nahian-car' ); ?>">&times;</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts for Accordion Toggles, Media Pickers & Dynamic Category Sync -->
    <script id="dn-gallery-subtab-scripts">
    (function($) {
        'use strict';

        $(document).ready(function() {
            // Accordion Toggle Behavior
            $(document).on('click', '.dn-accordion-header', function(e) {
                if ($(e.target).closest('.dev-nahian-switch').length) {
                    return;
                }
                var $card = $(this).closest('.dn-accordion-card');
                $card.toggleClass('is-open');
            });

            function getActiveCategories() {
                var cats = [];
                $('.dn-cat-repeater-row').each(function() {
                    var slug  = $(this).find('.dn-cat-slug-input').val().trim();
                    var label = $(this).find('.dn-cat-label-input').val().trim();
                    if (slug || label) {
                        cats.push({
                            slug: slug ? slug : label.toLowerCase().replace(/[^a-z0-9]/g, '-'),
                            label: label ? label : slug
                        });
                    }
                });
                return cats;
            }

            function refreshCategorySelects() {
                var cats = getActiveCategories();
                $('.dn-cat-select').each(function() {
                    var $sel = $(this);
                    var currentVal = $sel.val();
                    $sel.empty();
                    $sel.append('<option value=""><?php echo esc_js( __( '-- Select Category --', 'dev-nahian-car' ) ); ?></option>');
                    cats.forEach(function(c) {
                        var selected = (currentVal === c.slug) ? 'selected' : '';
                        $sel.append('<option value="' + c.slug + '" ' + selected + '>' + c.label + '</option>');
                    });
                });
            }

            // Add Category
            $('#dn_add_cat_btn').on('click', function(e) {
                e.preventDefault();
                var row = '\
                <div class="dn-cat-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: grid; grid-template-columns: 1fr 1fr 40px; gap: 12px; align-items: center;">\
                    <div class="dev-nahian-field-box">\
                        <label><?php echo esc_js( __( 'Category Slug', 'dev-nahian-car' ) ); ?></label>\
                        <input type="text" name="gallery_cat_slug[]" class="dev-nahian-input dn-cat-slug-input" value="" placeholder="e.g. sports">\
                    </div>\
                    <div class="dev-nahian-field-box">\
                        <label><?php echo esc_js( __( 'Category Name', 'dev-nahian-car' ) ); ?></label>\
                        <input type="text" name="gallery_cat_label[]" class="dev-nahian-input dn-cat-label-input" value="" placeholder="e.g. Supercars">\
                    </div>\
                    <div style="align-self: flex-end;">\
                        <button type="button" class="dn-remove-cat-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="<?php echo esc_js( __( 'Delete', 'dev-nahian-car' ) ); ?>">&times;</button>\
                    </div>\
                </div>';
                $('#dn_cat_repeater_wrap').append(row);
            });

            // Remove Category
            $(document).on('click', '.dn-remove-cat-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-cat-repeater-row').remove();
                refreshCategorySelects();
            });

            $(document).on('input', '.dn-cat-slug-input, .dn-cat-label-input', function() {
                refreshCategorySelects();
            });

            // Add Photo
            $('#dn_add_gallery_item').on('click', function(e) {
                e.preventDefault();
                var cats = getActiveCategories();
                var optHtml = '<option value=""><?php echo esc_js( __( '-- Select Category --', 'dev-nahian-car' ) ); ?></option>';
                cats.forEach(function(c) {
                    optHtml += '<option value="' + c.slug + '">' + c.label + '</option>';
                });

                var photoRow = '\
                <div class="dn-gallery-repeater-row" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; display: grid; grid-template-columns: 80px 1fr 200px 40px; gap: 14px; align-items: center;">\
                    <div style="width: 80px; height: 56px; border-radius: 6px; overflow: hidden; background: #e2e8f0; border: 1px solid #cbd5e1;">\
                        <img src="" style="width: 100%; height: 100%; object-fit: cover; display: none;" class="dn-preview-img" alt="Preview">\
                    </div>\
                    <div style="display: flex; flex-direction: column; gap: 8px;">\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Image URL', 'dev-nahian-car' ) ); ?></label>\
                            <div style="display: flex; gap: 6px;">\
                                <input type="text" name="gallery_item_image[]" class="dev-nahian-input dn-img-url" value="" placeholder="https://example.com/photo.jpg">\
                                <button type="button" class="dev-nahian-media-btn dn-upload-row-btn" style="flex-shrink: 0;"><?php echo esc_js( __( 'Upload', 'dev-nahian-car' ) ); ?></button>\
                            </div>\
                        </div>\
                        <div class="dev-nahian-field-box">\
                            <label><?php echo esc_js( __( 'Photo Title', 'dev-nahian-car' ) ); ?></label>\
                            <input type="text" name="gallery_item_title[]" class="dev-nahian-input" value="" placeholder="e.g. Aerodynamic Carbon Rear Wing">\
                        </div>\
                    </div>\
                    <div class="dev-nahian-field-box">\
                        <label><?php echo esc_js( __( 'Category', 'dev-nahian-car' ) ); ?></label>\
                        <select name="gallery_item_category[]" class="dev-nahian-select dn-cat-select">\
                            ' + optHtml + '\
                        </select>\
                    </div>\
                    <div>\
                        <button type="button" class="dn-remove-gallery-row" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="<?php echo esc_js( __( 'Delete', 'dev-nahian-car' ) ); ?>">&times;</button>\
                    </div>\
                </div>';
                $('#dn_gallery_repeater_wrap').append(photoRow);
            });

            // Remove Photo
            $(document).on('click', '.dn-remove-gallery-row', function(e) {
                e.preventDefault();
                $(this).closest('.dn-gallery-repeater-row').remove();
            });

            // Open WP Media Uploader
            $(document).on('click', '.dn-upload-row-btn', function(e) {
                e.preventDefault();
                var $row = $(this).closest('.dn-gallery-repeater-row');
                var customUploader = wp.media({
                    title: '<?php echo esc_js( __( 'Select Gallery Photo', 'dev-nahian-car' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Use Photo', 'dev-nahian-car' ) ); ?>' },
                    multiple: false
                }).on('select', function() {
                    var attachment = customUploader.state().get('selection').first().toJSON();
                    $row.find('.dn-img-url').val(attachment.url);
                    $row.find('.dn-preview-img').attr('src', attachment.url).show();
                }).open();
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Single targeted hook registration to prevent duplicate renders
add_action( 'dev_nahian_render_subtab_gallery', function() {
    dev_nahian_render_subtab_gallery_panel( 'gallery' );
});