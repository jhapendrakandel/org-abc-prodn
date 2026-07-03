<?php
/**
 * Template Name: Single ABC Video (Watch Page)
 *
 * USED BY: single posts in the 'abc-video' category.
 * Route this template via single_template filter (see snippet at bottom of
 * this file / functions.php) so that ANY post in category 'abc-video' loads
 * this file instead of the default single.php — exactly like YouTube's
 * watch page: player row (player 80% + "more videos" 20%) on top, then
 * title/meta/description FULL WIDTH below it, and normal category bands
 * at the bottom.
 *
 * If the current post is NOT in 'abc-video' OR has no YouTube URL saved in
 * `_abc_youtube_url`, we fall back to a normal single post layout (featured
 * image + content) so this file is still safe to use as a generic fallback.
 */
get_header();

$post_id      = get_the_ID();
$post_obj     = get_post( $post_id ); // fetched directly so we never depend on global $post staying put
$is_abc_video = has_category( 'abc-video', $post_id );
$yt_url       = get_post_meta( $post_id, '_abc_youtube_url', true );

// ── Extract YouTube video ID from any common URL format ──
function abcnt_get_youtube_id_from_url( $url ) {
    if ( empty( $url ) ) {
        return '';
    }
    $patterns = array(
        '/youtu\.be\/([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
    );
    foreach ( $patterns as $pattern ) {
        if ( preg_match( $pattern, $url, $matches ) ) {
            return $matches[1];
        }
    }
    return '';
}

$video_id = $is_abc_video ? abcnt_get_youtube_id_from_url( $yt_url ) : '';
?>

<style>
/* ================================================
   ABC Nepal TV — Single Video Watch Page
   .abcv- prefix to avoid clashing with theme / nyt- styles
================================================ */
.abcv-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px 20px 60px;
    font-family: Georgia, 'Times New Roman', serif;
    color: #121212;
}

/* ── Row 1: player (80%) + sidebar list (20%) — ONLY the player row ── */
.abcv-watch-grid {
    display: grid;
    grid-template-columns: 4fr 1fr;
    gap: 28px;
    align-items: start;
    margin-bottom: 28px;
}

/* Player */
.abcv-player-col { min-width: 0; }
.abcv-player-frame {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 */
    background: #000;
    border-radius: 6px;
    overflow: hidden;
}
.abcv-player-frame iframe {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    border: 0;
}
.abcv-no-video {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-family: Arial, sans-serif;
    font-size: 14px;
    height: 100%;
    position: absolute;
    top: 0; left: 0; width: 100%;
}

/* Sidebar: more abc videos — pinned to the player row, scrolls if long */
.abcv-sidebar {
    font-family: Arial, sans-serif;
    max-height: 640px;
    overflow-y: auto;
}
.abcv-sidebar h3 {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin: 0 0 14px;
    padding-bottom: 10px;
    border-bottom: 2px solid #121212;
    position: sticky;
    top: 0;
    background: #fff;
}
.abcv-side-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.abcv-side-item {
    display: flex;
    gap: 10px;
    text-decoration: none;
    color: #121212;
}
.abcv-side-thumb-wrap {
    position: relative;
    flex-shrink: 0;
    width: 120px;
    height: 68px;
    border-radius: 4px;
    overflow: hidden;
    background: #ddd;
}
.abcv-side-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.abcv-side-play {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 26px; height: 26px;
    background: rgba(0,0,0,.55);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.abcv-side-play svg { width: 12px; height: 12px; }
.abcv-side-text h4 {
    font-size: 13.5px;
    line-height: 1.35;
    font-weight: 700;
    margin: 0 0 6px;
    font-family: Georgia, serif;
}
.abcv-side-item:hover h4 { text-decoration: underline; }
.abcv-side-text .abcv-side-time {
    font-size: 11.5px;
    color: #888;
}
.abcv-side-item.is-current .abcv-side-thumb-wrap {
    outline: 2px solid #c4170c;
    outline-offset: 2px;
}
.abcv-side-item.is-current h4 { color: #c4170c; }

/* ── Row 2: title / meta / description — FULL WIDTH below the player row ── */
.abcv-info-section {
    max-width: 100%;
    margin-bottom: 28px;
}
.abcv-video-title {
    font-size: 26px;
    line-height: 1.25;
    font-weight: 700;
    margin: 0 0 10px;
    font-family: Georgia, serif;
}
.abcv-video-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    font-family: Arial, sans-serif;
    font-size: 13px;
    color: #727272;
    border-bottom: 1px solid #e2e2e2;
    padding-bottom: 16px;
    margin-bottom: 16px;
}
.abcv-video-meta .abcv-readtime::before {
    content: "•";
    margin-right: 8px;
    color: #ccc;
}
.abcv-video-cat {
    display: inline-block;
    font-family: Arial, sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: #fff;
    background: #c4170c;
    padding: 3px 9px;
    border-radius: 3px;
    margin-right: 8px;
}
.abcv-video-desc {
    font-size: 16px;
    line-height: 1.7;
    color: #222;
    max-width: 900px; /* keep long paragraphs readable even at full width */
}
.abcv-video-desc p { margin: 0 0 14px; }

@media (max-width: 900px) {
    .abcv-watch-grid { grid-template-columns: 1fr; }
    .abcv-sidebar { max-height: none; border-top: 1px solid #e2e2e2; padding-top: 20px; }
    .abcv-sidebar h3 { position: static; }
}

/* ── Fallback (non-video) single post layout ── */
.abcv-normal-post { max-width: 820px; margin: 0 auto; }
.abcv-normal-post .abcv-featured-img img {
    width: 100%; height: auto; border-radius: 6px; margin-bottom: 20px; display:block;
}
.abcv-normal-post h1 {
    font-size: 30px; line-height: 1.25; margin: 0 0 12px; font-family: Georgia, serif;
}
.abcv-normal-post .abcv-content {
    font-size: 17px; line-height: 1.75; color: #222;
}

/* ── Lower section: category bands, reuses .nyt-band styles from index if present ── */
.abcv-lower-sections { margin-top: 48px; }
</style>

<div class="abcv-wrap">

<?php if ( $is_abc_video && $video_id ) : ?>

    <!-- =====================================================
         ROW 1 — player (80%) + more-videos list (20%)
    ===================================================== -->
    <div class="abcv-watch-grid">

        <!-- LEFT: player only -->
        <div class="abcv-player-col">
            <div class="abcv-player-frame">
                <iframe
                    src="https://www.youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?rel=0"
                    title="<?php echo esc_attr( get_the_title( $post_id ) ); ?>"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            </div>
        </div>

        <!-- RIGHT: more abc-video posts (title + thumbnail), current one highlighted -->
        <aside class="abcv-sidebar">
            <h3>थप एबीसी भिडियो</h3>
            <div class="abcv-side-list">
                <?php
                // IMPORTANT: we query by the "_abc_youtube_url" meta field
                // actually being set (not by category). Category tagging can
                // be missed/forgotten on a post, but the meta field is what
                // truly defines "this is a video post" — so this is the more
                // reliable signal and will surface every video, not just the
                // ones correctly filed under the 'abc-video' category.
                $more_q = new WP_Query( array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => 10,
                    'post__not_in'   => array( $post_id ),
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'meta_query'     => array(
                        array(
                            'key'     => '_abc_youtube_url',
                            'value'   => '',
                            'compare' => '!=',
                        ),
                    ),
                    // We only need IDs + core fields; skip terms/meta caching we don't use.
                    'no_found_rows'  => true,
                ) );

                // NOTE: we deliberately do NOT call $more_q->the_post() /
                // setup_postdata() here. Looping through ->posts directly
                // means this block can never disturb the global $post that
                // the description below depends on.
                if ( ! empty( $more_q->posts ) ) :
                    foreach ( $more_q->posts as $mp ) :
                        $mp_id  = $mp->ID;
                        $mp_yt  = get_post_meta( $mp_id, '_abc_youtube_url', true );
                        $mp_vid = abcnt_get_youtube_id_from_url( $mp_yt );

                        // Ordered fallback chain of YouTube thumbnail quality.
                        // hqdefault ALWAYS exists for a public video, so it's
                        // the primary source (mqdefault/maxres can 404 for
                        // some uploads and leave a blank box).
                        if ( $mp_vid ) {
                            $mp_thumb          = 'https://img.youtube.com/vi/' . $mp_vid . '/hqdefault.jpg';
                            $mp_thumb_fallback = 'https://placehold.co/240x135/eeeeee/999999?text=Video';
                        } else {
                            $mp_thumb          = has_post_thumbnail( $mp_id )
                                ? get_the_post_thumbnail_url( $mp_id, 'medium' )
                                : 'https://placehold.co/240x135/eeeeee/999999?text=Video';
                            $mp_thumb_fallback = 'https://placehold.co/240x135/eeeeee/999999?text=Video';
                        }
                        ?>
                        <a class="abcv-side-item" href="<?php echo esc_url( get_permalink( $mp_id ) ); ?>">
                            <div class="abcv-side-thumb-wrap">
                                <img
                                    src="<?php echo esc_url( $mp_thumb ); ?>"
                                    alt=""
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='<?php echo esc_js( $mp_thumb_fallback ); ?>';"
                                >
                                <?php if ( $mp_vid ) : ?>
                                <span class="abcv-side-play">
                                    <svg viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="abcv-side-text">
                                <h4><?php echo esc_html( wp_trim_words( get_the_title( $mp_id ), 10 ) ); ?></h4>
                                <span class="abcv-side-time"><?php echo esc_html( nyt_read_time( $mp_id ) ); ?></span>
                            </div>
                        </a>
                        <?php
                    endforeach;
                else :
                    ?>
                    <p style="font-size:13px;color:#999;">थप भिडियो छिट्टै थपिनेछ।</p>
                    <?php
                endif;
                ?>
            </div>
        </aside>
    </div>

    <!-- =====================================================
         ROW 2 — title / meta / description, FULL WIDTH
         Rendered straight from the post object's post_content
         (via the "the_content" filter) rather than the global
         the_content() call, so nothing that happened in the
         sidebar loop above can ever affect it.
    ===================================================== -->
    <div class="abcv-info-section">
        <h1 class="abcv-video-title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>

        <div class="abcv-video-meta">
            <span class="abcv-video-cat">▶ एबीसी भिडियो</span>
            <span class="abcv-byline"><?php echo esc_html( nyt_byline( $post_id ) ); ?></span>
            <span class="abcv-readtime"><?php echo esc_html( get_the_date( 'j M Y, H:i', $post_id ) ); ?></span>
        </div>

        <div class="abcv-video-desc">
            <?php
            $video_description_html = $post_obj ? apply_filters( 'the_content', $post_obj->post_content ) : '';
            if ( trim( wp_strip_all_tags( $video_description_html ) ) !== '' ) {
                echo $video_description_html; // phpcs:ignore WordPress.Security.EscapeOutput -- already filtered/sanitized by the_content filters
            } else {
                echo '<p style="color:#999;">यो भिडियोको लागि विवरण थपिएको छैन।</p>';
            }
            ?>
        </div>
    </div>

<?php else : ?>

    <!-- =====================================================
         FALLBACK — not an abc-video post (or no YouTube URL):
         normal post layout with featured image + text content
    ===================================================== -->
    <article class="abcv-normal-post">
        <?php if ( has_post_thumbnail( $post_id ) ) : ?>
            <div class="abcv-featured-img">
                <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
            </div>
        <?php endif; ?>

        <h1><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>

        <div class="abcv-video-meta">
            <span class="abcv-byline"><?php echo esc_html( nyt_byline( $post_id ) ); ?></span>
            <span class="abcv-readtime"><?php echo esc_html( nyt_read_time( $post_id ) ); ?></span>
        </div>

        <div class="abcv-content">
            <?php the_content(); ?>
        </div>
    </article>

<?php endif; ?>

<!-- =====================================================
     LOWER SECTION — other category listings, 4-up boxes,
     same pattern as index.php bands
===================================================== -->
<div class="abcv-lower-sections">
    <?php
    if ( function_exists( 'nyt_render_band' ) ) {
        nyt_render_band( array(
            'label' => 'मुख्यसमाचार',
            'cat'   => 'news',
            'link'  => home_url( '/mainnews/' ),
        ) );
        nyt_render_band( array(
            'label' => 'राजनीति',
            'cat'   => 'politics',
            'link'  => home_url( '/politics/' ),
        ) );
        nyt_render_band( array(
            'label' => 'अर्थ',
            'cat'   => 'business',
            'link'  => home_url( '/artha/' ),
        ) );
        nyt_render_band( array(
            'label' => 'खेलकुद',
            'cat'   => 'sports',
            'link'  => home_url( '/sports/' ),
        ) );
    }
    if ( function_exists( 'nyt_render_video_band' ) ) {
        nyt_render_video_band( array(
            'label' => 'एबीसी भिडियो',
            'cat'   => 'abc-video',
            'link'  => home_url( '/abc-videos/' ),
        ) );
    }
    ?>
</div>

</div><!-- /abcv-wrap -->

<?php get_footer(); ?>