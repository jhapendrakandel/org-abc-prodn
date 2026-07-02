<?php
/*
Template Name: sahitiya
*/
get_header();
?>

<div class="container">

<div class="breaking-news">
    <span>💰 अर्थ अपडेट</span>
</div>

<?php

$featured = new WP_Query(array(
    'posts_per_page' => 1,
    'category_name' => 'artha'
));

if($featured->have_posts()) :

while($featured->have_posts()) :

$featured->the_post();

?>

<h1 class="main-headline">
    <?php the_title(); ?>
</h1>

<div class="news-grid">

<div class="main-news">

<a href="<?php the_permalink(); ?>">

<?php

if(has_post_thumbnail()){

    the_post_thumbnail('large');

}else{

    echo '<img src="https://picsum.photos/900/500?random=50">';

}

?>

</a>

<p class="featured-excerpt">
<?php echo wp_trim_words(get_the_excerpt(),30); ?>
</p>

</div>

<div class="side-news">

<h3>ताजा अर्थ समाचार</h3>

<ul>

<?php

$latest = new WP_Query(array(
    'posts_per_page' => 8,
    'offset' => 1,
    'category_name' => 'artha'
));

while($latest->have_posts()) :

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

<?php

endwhile;
wp_reset_postdata();

endif;

?>

<div class="category-section">

<h2>अर्थ विशेष</h2>

<div class="category-grid">

<?php

$artha = new WP_Query(array(
    'posts_per_page' => 8,
    'category_name' => 'artha'
));

while($artha->have_posts()) :

$artha->the_post();

?>

<article>

<a href="<?php the_permalink(); ?>">

<?php

if(has_post_thumbnail()){

    the_post_thumbnail('medium');

}else{

    echo '<img src="https://picsum.photos/400/250?random='.rand(1,100).'">';
}

?>

<h3><?php the_title(); ?></h3>

</a>

</article>

<?php endwhile; wp_reset_postdata(); ?>

</div>

</div>

<div class="ad-slot">

<img src="https://picsum.photos/1200/150?random=77" class="ad-image">

</div>

</div>

<?php get_footer(); ?>