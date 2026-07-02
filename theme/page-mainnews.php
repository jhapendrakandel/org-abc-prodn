<?php
/**
 * Template Name: Main News
 *
 * ABC Nepal TV — Main News Page (Synchronized Layout with Global UI)
 * Category: 'news'
 *
 * Layout:
 *   1. Breaking banner
 *   2. Hero post (pinned via _abcnt_homepage_hero, else latest 'news')
 *   3. Side list  — 8 posts excluding hero
 *   4. Grid       — next 8 posts excluding hero + side IDs
 *   5. Ad slot
 *   6. Pagination on grid
 */

get_header();

/* ════════════════════════════════════════════════
   RESOLVE HERO
   _abcnt_homepage_hero = 1  →  pinned
   else                       →  latest in 'news'
════════════════════════════════════════════════ */
$hero_id        = 0;
$hero_is_pinned = false;

if ( function_exists( 'abcnt_get_hero_post' ) ) {
    $pinned = abcnt_get_hero_post();
    if ( $pinned ) {
        $hero_id        = (int) $pinned->ID;
        $hero_is_pinned = true;
    }
}

// Fallback: grab latest 'news' post
if ( ! $hero_id ) {
    $fallback = get_posts( array(
        'numberposts'  => 1,
        'category_name'=> 'news',
        'post_status'  => 'publish',
    ) );
    if ( ! empty( $fallback ) ) {
        $hero_id = (int) $fallback[0]->ID;
    }
}

$paged = max( 1, get_query_var('paged') );

// Retrieve the global section layout specifications for translation metrics
$config = function_exists('abcnepal_section_config') ? abcnepal_section_config('mainnews') : array(
    'breaking'      => 'मुख्य समाचार : राष्ट्रिय राजनीति, अर्थतन्त्र, समाज र खेलकुदका प्रमुख समाचार',
    'section_title' => 'मुख्य समाचार',
    'sidebar_title' => 'ताजा मुख्य समाचार'
);
?>

<main class="container news-section news-section-mainnews">

    <?php /* ── Admin badges (editor only) ── */ ?>
    <?php if ( current_user_can('edit_posts') ) : ?>
    <div class="mn-admin-badges" style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; flex-wrap: wrap;">
        <?php if ( $hero_is_pinned ) : ?>
            <span class="mn-admin-badge hero" style="font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; font-family: sans-serif; background: #e8f0fe; color: #1a73e8;">🏠 Hero: Pinned</span>
        <?php else : ?>
            <span class="mn-admin-badge auto" style="font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; font-family: sans-serif; background: #f0f0f0; color: #888;">🏠 Hero: Auto (latest)</span>
        <?php endif; ?>
        <?php
        $f_count = function_exists('abcnt_count_flagged') ? abcnt_count_flagged('_abcnt_featured') : 0;
        $b_count = function_exists('abcnt_count_flagged') ? abcnt_count_flagged('_abcnt_breaking') : 0;
        ?>
        <span class="mn-admin-badge featured" style="font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; font-family: sans-serif; background: #fff8e1; color: #f59c00;">⭐ Featured: <?php echo (int)$f_count; ?> active</span>
        <span class="mn-admin-badge breaking" style="font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; font-family: sans-serif; background: #fde8e8; color: #c0392b;">🔴 Breaking: <?php echo (int)$b_count; ?> active</span>
    </div>
    <?php endif; ?>

    <?php /* ── Breaking banner ── */ ?>
    <div class="breaking-news">
        <span><?php echo esc_html($config['breaking']); ?></span>
    </div>

    <?php
    /* ════════════════════════════════════════════════
       HERO BLOCK
       ════════════════════════════════════════════════ */
    if ( $hero_id ) :
        $hero_title    = get_the_title( $hero_id );
        $hero_link     = get_permalink( $hero_id );
        $hero_excerpt  = wp_trim_words( get_post_field( 'post_excerpt', $hero_id ) ?: get_post_field( 'post_content', $hero_id ), 32 );
        $hero_thumb    = get_the_post_thumbnail( $hero_id, 'large' );
    ?>

    <!-- ── Hero title aligned identically to Politics Layout ── -->
    <h1 class="main-headline">
        <a href="<?php echo esc_url( $hero_link ); ?>" style="color: inherit; text-decoration: none;"><?php echo esc_html( $hero_title ); ?></a>
    </h1>

    <!-- ── Two-column structure using your core CSS grids ── -->
    <div class="news-grid">

        <article class="main-news">
            <a href="<?php echo esc_url( $hero_link ); ?>">
                <?php if ( $hero_thumb ) : ?>
                    <?php echo $hero_thumb; ?>
                <?php else : ?>
                    <?php if(function_exists('abcnepal_render_sample_image')) {
                        abcnepal_render_sample_image(crc32('mainnewsfeatured'));
                    } ?>
                <?php endif; ?>
            </a>

            <?php if ( $hero_excerpt ) : ?>
                <p class="featured-excerpt"><?php echo esc_html( $hero_excerpt ); ?></p>
            <?php endif; ?>
        </article>

        <!-- ── Sidebar list matching the Politics page exactly ── -->
        <aside class="side-news">
            <h3><?php echo esc_html($config['sidebar_title']); ?></h3>
            <?php
            $side_query = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => 8,
                'category_name'  => 'news',
                'post__not_in'   => array( $hero_id ),
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ) );
            $side_ids = array( $hero_id ); // tracker index array for grid filtration logic
            ?>
            <ul>
            <?php
            if ( $side_query->have_posts() ) :
                while ( $side_query->have_posts() ) : $side_query->the_post();
                    $side_ids[] = get_the_ID();
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                <?php endwhile; 
            endif;
            wp_reset_postdata(); 
            ?>
            </ul>
        </aside>

    </div><!-- /news-grid -->

    <?php endif; // End check for hero_id ?>

    <!-- ── Lower Feed Grid Layout ── -->
    <div class="category-section">
        <h2><?php echo esc_html($config['section_title']); ?></h2>
        <div class="category-grid">
        <?php
        $grid_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 8,
            'paged'          => $paged,
            'category_name'  => 'news',
            'post__not_in'   => $side_ids,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        if ( $grid_query->have_posts() ) :
            while ( $grid_query->have_posts() ) : $grid_query->the_post();
                $thumb = get_the_post_thumbnail( get_the_ID(), 'medium' );
        ?>
            <article>
                <a href="<?php the_permalink(); ?>">
                    <?php if ( $thumb ) : ?>
                        <?php echo $thumb; ?>
                    <?php else : ?>
                        <?php if(function_exists('abcnepal_render_sample_image')) {
                            abcnepal_render_sample_image(crc32('mainnewsgrid' . get_the_ID()), 'medium');
                        } ?>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                </a>
            </article>
        <?php
            endwhile;
        else :
            echo '<p style="color:#999; font-family:sans-serif; font-size:14px; padding:10px 0;">थप समाचार उपलब्ध छैन।</p>';
        endif;

        $grid_max_pages = $grid_query->max_num_pages;
        wp_reset_postdata();
        ?>
        </div>
    </div>

    <!-- ── Ad Block Integration ── -->
    <div class="ad-slot">
        <img src="<?php echo esc_url('https://picsum.photos/1200/150?random=' . absint(crc32('mainnewsad'))); ?>" class="ad-image" alt="">
    </div>

    <!-- ── Pagination Block ── -->
    <?php if ( ! empty( $grid_max_pages ) && $grid_max_pages > 1 ) : ?>
    <div class="mn-pagination" style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 20px 0 10px;">
        <?php
        echo paginate_links( array(
            'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $grid_max_pages,
            'prev_text' => '‹ अघिल्लो',
            'next_text' => 'अर्को ›',
            'type'      => 'plain',
        ) );
        ?>
    </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>