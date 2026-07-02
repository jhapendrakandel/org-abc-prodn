<?php
get_header();
?>

<div class="container abc-videos-page">
    <?php echo do_shortcode( '[abc_video_carousel count="10" cat="abc-video" show_desc="true"]' ); ?>
</div>

<?php get_footer(); ?>