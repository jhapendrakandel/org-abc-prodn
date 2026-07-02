<?php
/**
 * ABC Nepal TV — Breaking Banner Partial (Multi-banner, up to 5)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Get all breaking posts
$breaking_posts = array();

if ( function_exists( 'abcnt_get_breaking_posts' ) ) {
    $breaking_posts = abcnt_get_breaking_posts( 5 );
} else {
    // Legacy fallback
    $breaking_posts = get_posts( array(
        'posts_per_page' => 5,
        'category_name'  => 'breaking',
        'post_status'    => 'publish',
    ) );
}

if ( empty( $breaking_posts ) ) return;
?>

<style>
/* Shared styles */
.bnn-stack { display: flex; flex-direction: column; gap: 16px; margin: 28px 0; }

.bnn-section {
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
    border: 2px solid #c0392b;
    box-shadow: 0 2px 16px rgba(192,57,43,.12);
}

/* Alternate border colour for items 2+ to visually distinguish */
.bnn-section:nth-child(n+2) {
    border-color: #c0392b;
    box-shadow: 0 2px 10px rgba(192,57,43,.07);
}

.bnn-topbar {
    background: #c0392b;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 20px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .8px;
    text-transform: uppercase;
    font-family: sans-serif;
}
.bnn-section:nth-child(n+2) .bnn-topbar { background: #a93226; }

.bnn-live-dot {
    width: 9px; height: 9px;
    background: #fff; border-radius: 50%;
    flex-shrink: 0;
    animation: bnn-pulse 1.4s ease-in-out infinite;
}
@keyframes bnn-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .4; transform: scale(.7); }
}
.bnn-topbar-label { flex: 1; }
.bnn-topbar-time  { font-size: 11px; font-weight: 400; opacity: .85; font-family: sans-serif; }
.bnn-topbar-count {
    background: rgba(255,255,255,.2);
    font-size: 10px; padding: 2px 7px;
    border-radius: 10px; font-weight: 700;
}

.bnn-body { display: flex; align-items: stretch; }

.bnn-thumb { flex-shrink: 0; width: 260px; }
.bnn-thumb a { display: block; height: 100%; }
.bnn-thumb img {
    width: 260px; height: 100%;
    min-height: 160px; object-fit: cover;
    display: block; transition: opacity .3s;
}
.bnn-thumb a:hover img { opacity: .88; }

.bnn-content {
    flex: 1; padding: 20px 24px;
    display: flex; flex-direction: column; justify-content: center;
}
.bnn-title {
    font-size: 20px; font-weight: 800;
    color: #1a1a2e; line-height: 1.45;
    margin: 0 0 10px;
    font-family: 'Hind Siliguri', sans-serif;
}
.bnn-title a { color: inherit; text-decoration: none; transition: color .2s; }
.bnn-title a:hover { color: #c0392b; }

.bnn-excerpt {
    font-size: 14px; color: #555; line-height: 1.7;
    margin: 0 0 16px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-family: 'Hind Siliguri', sans-serif;
}
.bnn-meta {
    display: flex; align-items: center; gap: 14px;
    font-size: 12px; color: #aaa;
    font-family: sans-serif; margin-bottom: 16px;
}
.bnn-meta span { display: flex; align-items: center; gap: 5px; }

.bnn-cat-badge {
    background: #fde8e8; color: #c0392b;
    font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 10px;
    text-transform: uppercase; letter-spacing: .4px;
    font-family: sans-serif;
}
.bnn-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: #c0392b; color: #fff;
    padding: 9px 20px; border-radius: 4px;
    font-size: 13px; font-weight: 700;
    text-decoration: none; letter-spacing: .3px;
    transition: background .2s; align-self: flex-start;
    font-family: 'Hind Siliguri', sans-serif;
}
.bnn-btn:hover { background: #a93226; }

@media (max-width: 640px) {
    .bnn-body        { flex-direction: column; }
    .bnn-thumb       { width: 100%; }
    .bnn-thumb img   { width: 100%; height: 200px; min-height: unset; }
    .bnn-content     { padding: 16px; }
    .bnn-title       { font-size: 16px; }
}
</style>

<div class="bnn-stack">
<?php
$total = count( $breaking_posts );
foreach ( $breaking_posts as $index => $breaking_post ) :
    $bp_id      = $breaking_post->ID;
    $bp_title   = get_the_title( $bp_id );
    $bp_link    = get_permalink( $bp_id );
    $bp_excerpt = wp_trim_words( get_the_excerpt( $bp_id ), 40 );
    $bp_date    = get_the_date( 'M j, Y, g:i a', $bp_id );
    $bp_thumb   = get_the_post_thumbnail_url( $bp_id, 'medium_large' );
    $bp_cats    = get_the_category( $bp_id );
    $bp_cat     = ! empty( $bp_cats ) ? $bp_cats[0]->name : 'समाचार';
    $item_num   = $index + 1;
?>
    <section class="bnn-section" role="region" aria-label="ब्रेकिङ समाचार <?php echo esc_attr( $item_num ); ?>">

        <div class="bnn-topbar">
            <span class="bnn-live-dot"></span>
            <span class="bnn-topbar-label">ब्रेकिङ समाचार</span>
            <span class="bnn-topbar-time"><?php echo esc_html( $bp_date ); ?></span>
            <?php if ( $total > 1 ) : ?>
                <span class="bnn-topbar-count"><?php echo esc_html( $item_num . '/' . $total ); ?></span>
            <?php endif; ?>
        </div>

        <div class="bnn-body">
            <?php if ( $bp_thumb ) : ?>
            <div class="bnn-thumb">
                <a href="<?php echo esc_url( $bp_link ); ?>" tabindex="-1" aria-hidden="true">
                    <img src="<?php echo esc_url( $bp_thumb ); ?>"
                         alt="<?php echo esc_attr( $bp_title ); ?>">
                </a>
            </div>
            <?php endif; ?>

            <div class="bnn-content">
                <span class="bnn-cat-badge"><?php echo esc_html( $bp_cat ); ?></span>

                <h2 class="bnn-title">
                    <a href="<?php echo esc_url( $bp_link ); ?>">
                        <?php echo esc_html( $bp_title ); ?>
                    </a>
                </h2>

                <?php if ( $bp_excerpt ) : ?>
                <p class="bnn-excerpt"><?php echo esc_html( $bp_excerpt ); ?></p>
                <?php endif; ?>

                <div class="bnn-meta">
                    <span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <?php echo esc_html( $bp_date ); ?>
                    </span>
                </div>

                <a class="bnn-btn" href="<?php echo esc_url( $bp_link ); ?>">
                    पूरा समाचार पढ्नुहोस्
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
            </div>
        </div>

    </section>
<?php endforeach; ?>
</div>