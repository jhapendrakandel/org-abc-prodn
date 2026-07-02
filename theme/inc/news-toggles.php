<?php
/**
 * ABC Nepal TV — News Toggle System
 * Adds Breaking News / Featured / Homepage Hero toggles to post editor
 * Drop this file in your theme's /inc/ folder and require it from functions.php:
 *   require_once get_template_directory() . '/inc/news-toggles.php';
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ══════════════════════════════════════════════════════
   1.  REGISTER META BOX
══════════════════════════════════════════════════════ */
add_action( 'add_meta_boxes', 'abcnt_register_toggle_metabox' );
function abcnt_register_toggle_metabox() {
    add_meta_box(
        'abcnt_news_toggles',
        '🔴 ABC Nepal TV — News Toggles',
        'abcnt_toggle_metabox_html',
        'post',
        'side',
        'high'
    );
}

/* ══════════════════════════════════════════════════════
   2.  META BOX HTML
══════════════════════════════════════════════════════ */
function abcnt_toggle_metabox_html( $post ) {
    wp_nonce_field( 'abcnt_save_toggles', 'abcnt_toggles_nonce' );

    $is_breaking = get_post_meta( $post->ID, '_abcnt_breaking',      true );
    $is_featured = get_post_meta( $post->ID, '_abcnt_featured',      true );
    $is_hero     = get_post_meta( $post->ID, '_abcnt_homepage_hero', true );

    // Count how many posts currently hold each flag
    $breaking_count = abcnt_count_flagged( '_abcnt_breaking' );
    $hero_count     = abcnt_count_flagged( '_abcnt_homepage_hero' );

    // Is limit reached for breaking (and this post is not already one of them)?
    $breaking_limit_reached = ( $breaking_count >= 5 && $is_breaking !== '1' );
    ?>
    <style>
        .abcnt-toggle-wrap { font-family: -apple-system, sans-serif; }
        .abcnt-toggle-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .abcnt-toggle-row:last-child { border-bottom: none; }
        .abcnt-toggle-row input[type=checkbox] {
            width: 18px; height: 18px;
            margin-top: 2px; flex-shrink: 0;
            accent-color: #c0392b;
        }
        .abcnt-toggle-label  { font-weight: 700; font-size: 13px; color: #1a1a2e; display: block; }
        .abcnt-toggle-desc   { font-size: 11px; color: #888; margin-top: 2px; line-height: 1.4; }
        .abcnt-toggle-badge  {
            display: inline-block;
            background: #fff3cd; color: #856404;
            font-size: 10px; font-weight: 700;
            padding: 1px 6px; border-radius: 10px;
            margin-left: 4px; vertical-align: middle;
        }
        .abcnt-toggle-badge.red   { background: #fde8e8; color: #c0392b; }
        .abcnt-toggle-badge.green { background: #d4edda; color: #155724; }
        .abcnt-toggle-badge.gray  { background: #f0f0f0; color: #555; }

        /* Active breaking posts list */
        .abcnt-breaking-list {
            margin: 6px 0 0; padding: 0; list-style: none;
        }
        .abcnt-breaking-list li {
            font-size: 10px; color: #555;
            padding: 2px 0; border-bottom: 1px solid #f5f5f5;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .abcnt-breaking-list li::before { content: '🔴 '; }
        .abcnt-breaking-list li a { color: #555; text-decoration: none; }
        .abcnt-breaking-list li a:hover { color: #c0392b; }

        .abcnt-limit-msg {
            font-size: 11px; color: #c0392b;
            font-weight: 600; margin-top: 4px; display: block;
        }
    </style>

    <div class="abcnt-toggle-wrap">

        <!-- ── Breaking News ── -->
        <div class="abcnt-toggle-row">
            <input type="checkbox"
                   id="abcnt_breaking"
                   name="abcnt_breaking"
                   value="1"
                   <?php checked( $is_breaking, '1' ); ?>
                   <?php disabled( $breaking_limit_reached, true ); ?>>
            <div style="flex:1;min-width:0;">
                <label class="abcnt-toggle-label" for="abcnt_breaking">
                    🔴 ब्रेकिङ समाचार
                    <?php if ( $is_breaking === '1' ) : ?>
                        <span class="abcnt-toggle-badge red">LIVE</span>
                    <?php elseif ( $breaking_limit_reached ) : ?>
                        <span class="abcnt-toggle-badge red">5/5 FULL</span>
                    <?php elseif ( $breaking_count > 0 ) : ?>
                        <span class="abcnt-toggle-badge gray"><?php echo esc_html( $breaking_count ); ?>/5 active</span>
                    <?php endif; ?>
                </label>

                <span class="abcnt-toggle-desc">
                    Breaking banner मा देखाउनु।
                    एकसाथ अधिकतम <strong>५ वटा</strong> active हुन सक्छ।
                </span>

                <?php if ( $breaking_limit_reached ) : ?>
                    <span class="abcnt-limit-msg">
                        ⚠️ Limit पुग्यो (5/5)। थप्नु अघि एउटा हटाउनुस्।
                    </span>
                <?php endif; ?>

                <?php
                // Show list of currently active breaking posts
                $active_breaking = get_posts( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',
                    'meta_key'       => '_abcnt_breaking',
                    'meta_value'     => '1',
                    'fields'         => 'ids',
                ) );
                if ( ! empty( $active_breaking ) ) : ?>
                    <ul class="abcnt-breaking-list">
                        <?php foreach ( $active_breaking as $bid ) : ?>
                            <li title="<?php echo esc_attr( get_the_title( $bid ) ); ?>">
                                <a href="<?php echo esc_url( get_edit_post_link( $bid ) ); ?>">
                                    <?php echo esc_html( wp_trim_words( get_the_title( $bid ), 6 ) ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── Featured ── -->
        <div class="abcnt-toggle-row">
            <input type="checkbox"
                   id="abcnt_featured"
                   name="abcnt_featured"
                   value="1"
                   <?php checked( $is_featured, '1' ); ?>>
            <div>
                <label class="abcnt-toggle-label" for="abcnt_featured">
                    ⭐ Featured समाचार
                    <?php if ( $is_featured === '1' ) : ?>
                        <span class="abcnt-toggle-badge green">ACTIVE</span>
                    <?php endif; ?>
                </label>
                <span class="abcnt-toggle-desc">
                    Main News page को sub-hero section मा priority दिन्छ।
                    एकभन्दा बढी हुन सक्छ।
                </span>
            </div>
        </div>

        <!-- ── Homepage Hero ── -->
        <div class="abcnt-toggle-row">
            <input type="checkbox"
                   id="abcnt_homepage_hero"
                   name="abcnt_homepage_hero"
                   value="1"
                   <?php checked( $is_hero, '1' ); ?>>
            <div>
                <label class="abcnt-toggle-label" for="abcnt_homepage_hero">
                    🏠 Homepage Hero
                    <?php if ( $is_hero === '1' ) : ?>
                        <span class="abcnt-toggle-badge green">ACTIVE</span>
                    <?php elseif ( $hero_count > 0 && ! $is_hero ) : ?>
                        <span class="abcnt-toggle-badge"><?php echo esc_html( $hero_count ); ?> active</span>
                    <?php endif; ?>
                </label>
                <span class="abcnt-toggle-desc">
                    Main News को ठूलो hero section मा pin गर्छ।
                    सक्रिय गर्दा पुरानो hero automatically हट्छ।
                </span>
            </div>
        </div>

    </div>
    <?php
}

/* ══════════════════════════════════════════════════════
   3.  SAVE META
══════════════════════════════════════════════════════ */
add_action( 'save_post_post', 'abcnt_save_toggles', 10, 2 );
function abcnt_save_toggles( $post_id, $post ) {
    if ( ! isset( $_POST['abcnt_toggles_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['abcnt_toggles_nonce'], 'abcnt_save_toggles' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    /* ── Breaking: up to 5 posts at a time, NO auto-clear of others ── */
    $new_breaking  = isset( $_POST['abcnt_breaking'] ) ? '1' : '';
    $already_set   = get_post_meta( $post_id, '_abcnt_breaking', true );
    if ( $new_breaking === '1' && $already_set !== '1' ) {
        // Only allow if under the limit
        $current_count = abcnt_count_flagged( '_abcnt_breaking' );
        if ( $current_count >= 5 ) {
            $new_breaking = ''; // Reject silently — limit reached
        }
    }
    update_post_meta( $post_id, '_abcnt_breaking', $new_breaking );

    /* ── Featured: multiple allowed, no limit ── */
    $new_featured = isset( $_POST['abcnt_featured'] ) ? '1' : '';
    update_post_meta( $post_id, '_abcnt_featured', $new_featured );

    /* ── Homepage Hero: only one at a time, auto-clear others ── */
    $new_hero = isset( $_POST['abcnt_homepage_hero'] ) ? '1' : '';
    if ( $new_hero === '1' ) {
        abcnt_clear_flag_from_others( '_abcnt_homepage_hero', $post_id );
    }
    update_post_meta( $post_id, '_abcnt_homepage_hero', $new_hero );
}

/* ══════════════════════════════════════════════════════
   4.  HELPER — clear a flag from all other posts
══════════════════════════════════════════════════════ */
function abcnt_clear_flag_from_others( $meta_key, $exclude_id ) {
    $others = get_posts( array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => array( 'publish', 'future', 'private', 'draft', 'pending' ),
        'meta_key'       => $meta_key,
        'meta_value'     => '1',
        'exclude'        => array( $exclude_id ),
        'fields'         => 'ids',
    ) );
    foreach ( $others as $id ) {
        update_post_meta( $id, $meta_key, '' );
    }
}

/* ══════════════════════════════════════════════════════
   5.  HELPER — count active flags
══════════════════════════════════════════════════════ */
function abcnt_count_flagged( $meta_key ) {
    $posts = get_posts( array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => $meta_key,
        'meta_value'     => '1',
        'fields'         => 'ids',
    ) );
    return count( $posts );
}

/* ══════════════════════════════════════════════════════
   6.  ADMIN COLUMNS
══════════════════════════════════════════════════════ */
add_filter( 'manage_posts_columns', 'abcnt_add_toggle_columns' );
function abcnt_add_toggle_columns( $cols ) {
    $new = array();
    foreach ( $cols as $k => $v ) {
        $new[ $k ] = $v;
        if ( $k === 'title' ) {
            $new['abcnt_breaking']      = '🔴 Breaking';
            $new['abcnt_featured']      = '⭐ Featured';
            $new['abcnt_homepage_hero'] = '🏠 Hero';
        }
    }
    return $new;
}

add_action( 'manage_posts_custom_column', 'abcnt_toggle_column_content', 10, 2 );
function abcnt_toggle_column_content( $col, $post_id ) {
    $map = array(
        'abcnt_breaking'      => '_abcnt_breaking',
        'abcnt_featured'      => '_abcnt_featured',
        'abcnt_homepage_hero' => '_abcnt_homepage_hero',
    );
    if ( isset( $map[ $col ] ) ) {
        $val = get_post_meta( $post_id, $map[ $col ], true );
        echo $val === '1'
            ? '<span style="color:#27ae60;font-size:16px;" title="Active">✔</span>'
            : '<span style="color:#ddd;font-size:16px;">—</span>';
    }
}

add_filter( 'manage_posts_sortable_columns', 'abcnt_sortable_toggle_columns' );
function abcnt_sortable_toggle_columns( $cols ) {
    $cols['abcnt_breaking']      = '_abcnt_breaking';
    $cols['abcnt_featured']      = '_abcnt_featured';
    $cols['abcnt_homepage_hero'] = '_abcnt_homepage_hero';
    return $cols;
}

/* ══════════════════════════════════════════════════════
   7.  PUBLIC HELPER FUNCTIONS
══════════════════════════════════════════════════════ */

/**
 * Get ALL active breaking posts (up to 5)
 */
function abcnt_get_breaking_posts( $limit = 5 ) {
    return get_posts( array(
        'post_type'      => 'post',
        'posts_per_page' => min( $limit, 5 ),
        'post_status'    => 'publish',
        'meta_key'       => '_abcnt_breaking',
        'meta_value'     => '1',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
}

/**
 * Get single active breaking post — backward compatible
 */
function abcnt_get_breaking_post() {
    $posts = abcnt_get_breaking_posts( 1 );
    return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Get the single active homepage hero post (or null)
 */
function abcnt_get_hero_post() {
    $posts = get_posts( array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_key'       => '_abcnt_homepage_hero',
        'meta_value'     => '1',
        'orderby'        => 'modified',
        'order'          => 'DESC',
    ) );
    return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Get featured posts (multiple allowed), optionally excluding IDs
 */
function abcnt_get_featured_posts( $limit = 5, $exclude_ids = array() ) {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'meta_key'       => '_abcnt_featured',
        'meta_value'     => '1',
        'orderby'        => 'modified',
        'order'          => 'DESC',
    );
    if ( ! empty( $exclude_ids ) ) {
        $args['post__not_in'] = $exclude_ids;
    }
    return get_posts( $args );
}