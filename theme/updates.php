<?php
/* Template Name: Latest News Page */
get_header(); ?>

<div class="container">
    <h1 class="section-title">ताजा समाचार (Latest News)</h1>
    
    <div class="news-list-container">
        <?php
        $latest_news = new WP_Query(array(
            'posts_per_page' => 15,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));

        if($latest_news->have_posts()) :
            while($latest_news->have_posts()) : $latest_news->the_post();
        ?>
        
        <article class="news-item-row">
            <div class="news-item-img">
                <a href="<?php the_permalink(); ?>">
                    <?php if(has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } else {
                        echo '<img src="https://placehold.co/300x200" alt="Placeholder">';
                    } ?>
                </a>
            </div>
            <div class="news-item-content">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="meta">
                    लेखक: <?php the_author(); ?> | मिति: <?php echo get_the_date('Y-m-d'); ?>
                </p>
                <div class="excerpt">
                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                </div>
            </div>
        </article>

        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>अहिले कुनै समाचार उपलब्ध छैन।</p>';
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>