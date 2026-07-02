<?php
/*
Template Name: Artha Banijya Page
*/
get_header();

abcnepal_render_news_section(is_page('economics') ? 'economics' : 'artha');

get_footer();
