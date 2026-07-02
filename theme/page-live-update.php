<?php
/**
 * Template Name: Live Update Page
 */
get_header();
?>
<div class="live-update-page">

<div class="live-feed-container">

    <div class="live-header">
        <h1 class="live-main-title">
            <span class="live-dot"></span> Live Updates
        </h1>
        <div class="live-meta">
            <span class="live-status" id="live-status" data-state="ok">Live</span>
            <span class="live-count" id="live-count"></span>
        </div>
    </div>

    <div class="live-feed" id="live-feed">
        <?php
        $updates = new WP_Query([
            'post_type'      => 'live_update',
            'posts_per_page' => 30,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        $newest_id = 0;

        if ($updates->have_posts()) :
            while ($updates->have_posts()) : $updates->the_post();

                $post_id       = get_the_ID();
                $post_time     = get_post_time('U');
                $iso_time      = get_post_time('c');
                $display_time  = get_post_time('H:i');
                $word_count    = str_word_count(wp_strip_all_tags(get_the_content()));

                if ($post_id > $newest_id) {
                    $newest_id = $post_id;
                }
                ?>
                <div class="update-entry" data-id="<?php echo esc_attr($post_id); ?>">

                    <div class="update-header">
                       
                        <span class="update-clock"><?php echo esc_html($display_time); ?></span>
                    </div>

                    <h3 class="update-title"><?php the_title(); ?></h3>

                    <div class="update-content">
                        <?php the_content(); ?>
                    </div>

                    <?php if ($word_count > 40) : ?>
                        <button class="show-more-btn" aria-expanded="false">Show more</button>
                    <?php endif; ?>

                </div>
            <?php endwhile;
        else : ?>
            <p class="no-updates">No updates yet.</p>
        <?php endif;
        wp_reset_postdata();
        ?>
    </div><!-- /.live-feed -->

    <!-- Tracks the highest post ID seen; JS reads this for incremental polling -->
    <meta id="live-last-id" content="<?php echo esc_attr($newest_id); ?>">

</div><!-- /.live-feed-container -->
</div><!-- /.live-update-page -->

<?php get_footer(); ?>