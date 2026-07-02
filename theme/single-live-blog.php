<?php
get_header();

abcnepal_render_news_section('Live-blog');

get_footer();

<?php
$updates = new WP_Query([
    'post_type' => 'live_update',
    'posts_per_page' => 50,
    'orderby' => 'date',
    'order' => 'DESC',
    // Add meta_query for specific live event if needed
]);

if ($updates->have_posts()) :
    echo '<div class="live-feed">';
    while ($updates->have_posts()) : $updates->the_post(); ?>
        <div class="update-entry" id="update-<?php the_ID(); ?>">
            <time><?php the_time('H:i'); ?></time>
            <h3><?php the_title(); ?></h3>
            <div class="content"><?php the_content(); ?></div>
        </div>
    <?php endwhile;
    echo '</div>';
endif;
wp_reset_postdata();
?>


<div class="live-feed">
    <!-- Updates will be loaded here via AJAX + initial PHP loop -->
</div>