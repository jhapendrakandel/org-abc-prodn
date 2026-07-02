<?php
/*
Template Name: Province
*/
get_header();
?>

<div class="container">

    <div class="breaking-news">
        <span>📰 प्रदेश अपडेट</span>
    </div>

    <?php
    // Featured Politics Post
    $featured = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'category_name'  => 'province'
    ));

    if ($featured->have_posts()) :
        while ($featured->have_posts()) :
            $featured->the_post();
    ?>

    <h1 class="main-headline">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h1>

    <div class="news-grid">

        <div class="main-news">

            <a href="<?php the_permalink(); ?>">

                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('large');
                } else {
                    echo '<img src="https://picsum.photos/900/500?random=50" alt="">';
                }
                ?>

            </a>

            <p class="featured-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
            </p>

        </div>

        <div class="side-news">

            <h3>ताजा प्रदेश समाचार</h3>

            <ul>

                <?php
                $latest = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 8,
                    'offset'         => 1,
                    'category_name'  => 'province'
                ));

                while ($latest->have_posts()) :
                    $latest->the_post();
                ?>

                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>

                <?php endwhile; ?>

            </ul>

        </div>

    </div>

    <iframe title="England vs DR Congo Player" marginheight="0" marginwidth="0" src="https://embed.st/embed/echo/england-vs-congo-dr-football-1567307/1" scrolling="no" allowfullscreen="yes" allow="encrypted-media; picture-in-picture;" width="100%" height="100%" frameborder="0"></iframe>

    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <div class="category-section">

        <h2>प्रदेश विशेष</h2>

        <div class="category-grid">

            <?php

            $politics = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 8,
                'offset'         => 9,
                'category_name'  => 'province'
            ));

            while ($politics->have_posts()) :
                $politics->the_post();
            ?>

                <article>

                    <a href="<?php the_permalink(); ?>">

                        <?php

                        if (has_post_thumbnail()) {

                            the_post_thumbnail('medium');

                        } else {

                            echo '<img src="https://picsum.photos/400/250?random=' . rand(1, 100) . '" alt="">';

                        }

                        ?>

                        <h3><?php the_title(); ?></h3>

                    </a>

                </article>

            <?php endwhile;
            wp_reset_postdata();
            ?>

        </div>

    </div>

    <div class="ad-slot">

        <img src="https://picsum.photos/1200/150?random=77" class="ad-image" alt="Advertisement">

    </div>

</div>

<?php get_footer(); ?>