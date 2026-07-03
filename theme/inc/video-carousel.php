<?php
/* ================================================
   ABC VIDEO PLAYER + THUMBNAIL STRIP
   Replaces the old "VIDEO CAROUSEL" block in functions.php
   Include this file with:
       require_once get_template_directory() . '/inc/video-carousel.php';
   and DELETE the old abc_video_* functions from functions.php
   (abc_video_add_meta_box, abc_video_meta_box_html, abc_video_save,
   abc_get_youtube_id, abc_get_youtube_thumbnail, abc_video_carousel_shortcode,
   abc_video_enqueue_styles, abc_video_load_more_handler and its two add_action calls)
================================================ */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ── Meta box: YouTube URL on post edit screen ── */
function abc_video_add_meta_box() {
    add_meta_box( 'abc_video_youtube_url', '🎬 YouTube Video URL', 'abc_video_meta_box_html', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'abc_video_add_meta_box' );

function abc_video_meta_box_html( $post ) {
    wp_nonce_field( 'abc_video_save', 'abc_video_nonce' );
    $yt_url = get_post_meta( $post->ID, '_abc_youtube_url', true );
    ?>
    <p>
        <label for="abc_youtube_url"><strong>YouTube Video URL</strong></label><br>
        <input type="url" id="abc_youtube_url" name="abc_youtube_url"
               value="<?php echo esc_attr( $yt_url ); ?>"
               style="width:100%;" placeholder="https://www.youtube.com/watch?v=VIDEO_ID" />
        <span class="description">Enter full YouTube URL. Used by the video player + thumbnail strip.</span>
    </p>
    <?php
}

function abc_video_save( $post_id ) {
    if ( ! isset( $_POST['abc_video_nonce'] ) || ! wp_verify_nonce( $_POST['abc_video_nonce'], 'abc_video_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['abc_youtube_url'] ) ) {
        update_post_meta( $post_id, '_abc_youtube_url', sanitize_url( $_POST['abc_youtube_url'] ) );
    }
}
add_action( 'save_post_post', 'abc_video_save' );

/* ── Helpers ── */
function abc_get_youtube_id( $url ) {
    if ( empty( $url ) ) return '';
    $patterns = array(
        '/youtu\.be\/([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
    );
    foreach ( $patterns as $pattern ) {
        if ( preg_match( $pattern, $url, $matches ) ) return $matches[1];
    }
    return '';
}

function abc_get_youtube_thumbnail( $video_id, $quality = 'hqdefault' ) {
    if ( empty( $video_id ) ) return '';
    return "https://img.youtube.com/vi/{$video_id}/{$quality}.jpg";
}

/**
 * Build a plain-array video list (used by shortcode + AJAX "load more")
 */
function abc_get_video_list( $cat, $count, $offset = 0 ) {
    $query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => $count,
        'offset'         => $offset,
        'category_name'  => $cat,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    $items = array();
    while ( $query->have_posts() ) {
        $query->the_post();
        $post_id   = get_the_ID();
        $yt_url    = get_post_meta( $post_id, '_abc_youtube_url', true );
        $video_id  = abc_get_youtube_id( $yt_url );
        $thumb_url = $video_id
            ? abc_get_youtube_thumbnail( $video_id, 'mqdefault' )
            : get_the_post_thumbnail_url( $post_id, 'medium' );
        if ( empty( $thumb_url ) ) {
            $thumb_url = 'https://placehold.co/336x189/eeeeee/999999?text=Video';
        }

        $items[] = array(
            'id'        => $post_id,
            'video_id'  => $video_id,
            'title'     => get_the_title(),
            'excerpt'   => wp_trim_words( get_the_excerpt() ?: get_the_content(), 30 ),
            'permalink' => get_permalink(),
            'thumb'     => $thumb_url,
            'date'      => get_the_date( 'M j, Y' ),
        );
    }
    wp_reset_postdata();
    return $items;
}

/**
 * Shortcode: [abc_video_carousel count="20" cat="abc-video" show_desc="true"]
 * Renders: big main player on top + scrollable thumbnail strip below.
 */
function abc_video_carousel_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'count'     => 20,   // how many videos to show in the strip (15-20 recommended)
        'cat'       => 'abc-video',
        'show_desc' => 'true',
    ), $atts );

    $count = max( 1, min( 30, (int) $atts['count'] ) );
    $items = abc_get_video_list( $atts['cat'], $count );

    if ( empty( $items ) ) {
        return '<p class="abc-video-empty">कोई भिडियो उपलब्ध छैन।</p>';
    }

    $first = $items[0];

    ob_start();
    ?>
    <div class="abc-video-player-block" data-cat="<?php echo esc_attr( $atts['cat'] ); ?>">

        <!-- ── Main Player ── -->
        <div class="abc-main-player" id="abc-main-player" data-video-id="<?php echo esc_attr( $first['video_id'] ); ?>">
            <div class="abc-main-player-media" id="abc-main-player-media">
                <?php if ( $first['video_id'] ) : ?>
                    <img class="abc-main-player-thumb" src="<?php echo esc_url( abc_get_youtube_thumbnail( $first['video_id'], 'maxresdefault' ) ); ?>" alt="<?php echo esc_attr( $first['title'] ); ?>">
                    <button class="abc-main-play-btn" aria-label="Play video">
                        <svg width="72" height="72" viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                <?php else : ?>
                    <img class="abc-main-player-thumb" src="<?php echo esc_url( $first['thumb'] ); ?>" alt="<?php echo esc_attr( $first['title'] ); ?>">
                <?php endif; ?>
            </div>
            <div class="abc-main-player-info">
                <h2 class="abc-main-player-title" id="abc-main-player-title">
                    <a href="<?php echo esc_url( $first['permalink'] ); ?>" id="abc-main-player-link"><?php echo esc_html( $first['title'] ); ?></a>
                </h2>
                <?php if ( 'true' === $atts['show_desc'] ) : ?>
                    <p class="abc-main-player-desc" id="abc-main-player-desc"><?php echo esc_html( $first['excerpt'] ); ?></p>
                <?php endif; ?>
                <time class="abc-main-player-date" id="abc-main-player-date"><?php echo esc_html( $first['date'] ); ?></time>
            </div>
        </div>

        <!-- ── Thumbnail Strip ── -->
        <div class="abc-video-strip-wrap">
            <h3 class="abc-video-strip-title">थप भिडियोहरू</h3>
            <div class="abc-video-strip-viewport">
                <button class="abc-strip-nav abc-strip-prev" aria-label="Scroll left">‹</button>
                <div class="abc-video-strip" id="abc-video-strip">
                    <?php foreach ( $items as $i => $item ) : ?>
                        <button
                            class="abc-strip-item<?php echo 0 === $i ? ' active' : ''; ?>"
                            data-video-id="<?php echo esc_attr( $item['video_id'] ); ?>"
                            data-thumb="<?php echo esc_url( abc_get_youtube_thumbnail( $item['video_id'], 'maxresdefault' ) ); ?>"
                            data-title="<?php echo esc_attr( $item['title'] ); ?>"
                            data-desc="<?php echo esc_attr( $item['excerpt'] ); ?>"
                            data-date="<?php echo esc_attr( $item['date'] ); ?>"
                            data-link="<?php echo esc_url( $item['permalink'] ); ?>"
                        >
                            <img src="<?php echo esc_url( $item['thumb'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
                            <span class="abc-strip-item-title"><?php echo esc_html( wp_trim_words( $item['title'], 8 ) ); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <button class="abc-strip-nav abc-strip-next" aria-label="Scroll right">›</button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'abc_video_carousel', 'abc_video_carousel_shortcode' );

/* ── Enqueue assets ── */
function abc_video_enqueue_styles() {
    if ( is_page_template( 'page-abc-videos.php' ) || is_page( 'abc-videos' ) || is_front_page() || is_home() ) {
        wp_enqueue_style( 'abc-video-carousel', get_template_directory_uri() . '/css/video-carousel.css', array(), '2.0.0' );
        wp_enqueue_script( 'abc-video-carousel-js', get_template_directory_uri() . '/js/video-carousel.js', array(), '2.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'abc_video_enqueue_styles' );