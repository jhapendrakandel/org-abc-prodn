<?php
/*
 * Single Post Template — ABC Nepal TV
 * Layout: full-width article (left) + right sidebar (latest news)
 */
get_header();
?>

<style>
/* ================================================
   ABC Nepal TV — Single Post Styles
   Prefix: sp- (single post)
================================================ */

/* ── Ticker / Breaking bar ── */
.sp-ticker {
    background: #c0392b;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 9px 0;
    margin-bottom: 0;
}
.sp-ticker-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 16px;
    display: flex;
    align-items: center;
    gap: 0;
    overflow: hidden;
}
.sp-ticker-label {
    background: rgba(0,0,0,.25);
    padding: 2px 14px 2px 0;
    white-space: nowrap;
    flex-shrink: 0;
    margin-right: 16px;
    border-right: 2px solid rgba(255,255,255,.35);
    font-size: 12px;
    letter-spacing: .4px;
}
.sp-ticker-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-family: 'Hind Siliguri', sans-serif;
}

/* ── Outer wrap ── */
.sp-wrap {
    max-width: 1240px;
    margin: 0 auto;
    padding: 28px 16px 60px;
    font-family: 'Hind Siliguri', sans-serif;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 36px;
    align-items: start;
}

/* ================================================
   MAIN ARTICLE COLUMN
================================================ */
.sp-article {}

/* ── Category tag ── */
.sp-cat-tag {
    display: inline-block;
    background: #c0392b;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 2px;
    letter-spacing: .5px;
    text-transform: uppercase;
    text-decoration: none;
    margin-bottom: 14px;
    transition: background .2s;
}
.sp-cat-tag:hover { background: #a93226; }

/* ── Post title ── */
.sp-title {
    font-size: 30px;
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.4;
    margin: 0 0 18px;
}

/* ── Meta row ── */
.sp-meta {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
    padding-bottom: 14px;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}
.sp-meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #888;
    font-family: sans-serif;
}
.sp-meta-item svg {
    width: 13px;
    height: 13px;
    opacity: .55;
    flex-shrink: 0;
}
.sp-meta-author {
    font-weight: 700;
    color: #444;
}

/* ── Featured image ── */
.sp-thumb {
    margin-bottom: 20px;
    border-radius: 4px;
    overflow: hidden;
}
.sp-thumb img {
    width: 100%;
    height: auto;
    display: block;
    max-height: 500px;
    object-fit: cover;
}
.sp-thumb-caption {
    font-size: 12px;
    color: #999;
    font-family: sans-serif;
    padding: 6px 0 0;
    font-style: italic;
}

/* ── Article body ── */
.sp-content {
    font-size: 16px;
    line-height: 1.85;
    color: #222;
}
.sp-content p {
    margin: 0 0 18px;
}
.sp-content h2 {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 28px 0 12px;
    padding-left: 12px;
    border-left: 4px solid #c0392b;
}
.sp-content h3 {
    font-size: 17px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 22px 0 10px;
}
.sp-content a {
    color: #c0392b;
    text-decoration: none;
}
.sp-content a:hover { text-decoration: underline; }
.sp-content blockquote {
    border-left: 4px solid #c0392b;
    margin: 20px 0;
    padding: 14px 20px;
    background: #fdf5f5;
    font-style: italic;
    color: #555;
    border-radius: 0 4px 4px 0;
}
.sp-content img {
    max-width: 100%;
    height: auto;
    border-radius: 3px;
    margin: 8px 0;
}

/* ── Share bar ── */
.sp-share {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding: 18px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    margin: 28px 0;
}
.sp-share-label {
    font-size: 12px;
    font-weight: 700;
    color: #888;
    font-family: sans-serif;
    text-transform: uppercase;
    letter-spacing: .4px;
    flex-shrink: 0;
}
.sp-share-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
    font-family: sans-serif;
    transition: opacity .2s;
}
.sp-share-btn:hover { opacity: .85; }
.sp-share-fb   { background: #1877f2; }
.sp-share-tw   { background: #1da1f2; }
.sp-share-wa   { background: #25d366; }
.sp-share-viber { background: #7360f2; }

/* ── Related posts ── */
.sp-related {
    margin-top: 36px;
}
.sp-related-head {
    font-size: 16px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0 0 14px;
    padding-bottom: 10px;
    border-bottom: 3px solid #c0392b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sp-related-head .bar {
    width: 4px;
    height: 18px;
    background: #c0392b;
    border-radius: 2px;
    display: inline-block;
}
.sp-related-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
.sp-related-card {
    display: block;
    text-decoration: none;
    color: inherit;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    transition: box-shadow .2s;
}
.sp-related-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,.08); }
.sp-related-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    display: block;
}
.sp-related-card-body {
    padding: 10px 12px 12px;
}
.sp-related-card-body h4 {
    font-size: 13px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 5px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color .2s;
}
.sp-related-card:hover h4 { color: #c0392b; }
.sp-related-card-body .mn-date {
    font-size: 11px;
    color: #bbb;
    font-family: sans-serif;
}

/* ================================================
   RIGHT SIDEBAR
================================================ */
.sp-sidebar {
    position: sticky;
    top: 20px;
}

/* ── Sidebar section head ── */
.sp-sb-head {
    font-size: 17px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0 0 0;
    padding-bottom: 12px;
    border-bottom: 3px solid #1a1a2e;
    display: block;
}

/* ── News list in sidebar ── */
.sp-sb-list {
    display: flex;
    flex-direction: column;
}
.sp-sb-item {
    display: flex;
    gap: 11px;
    align-items: flex-start;
    padding: 13px 0;
    border-bottom: 1px solid #f0f0f0;
    text-decoration: none;
    color: inherit;
    transition: background .12s;
}
.sp-sb-item:last-child { border-bottom: none; }
.sp-sb-item:hover .sp-sb-title { color: #c0392b; }
.sp-sb-num {
    font-size: 18px;
    font-weight: 800;
    color: #e0e0e0;
    font-family: sans-serif;
    min-width: 26px;
    line-height: 1;
    padding-top: 2px;
    flex-shrink: 0;
}
.sp-sb-thumb {
    width: 80px;
    height: 56px;
    border-radius: 3px;
    overflow: hidden;
    flex-shrink: 0;
    background: #eee;
}
.sp-sb-thumb img {
    width: 80px;
    height: 56px;
    object-fit: cover;
    display: block;
}
.sp-sb-info {}
.sp-sb-title {
    font-size: 13px;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.5;
    margin: 0 0 4px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color .2s;
}
.sp-sb-date {
    font-size: 11px;
    color: #bbb;
    font-family: sans-serif;
}

/* ── Sidebar ad/banner placeholder ── */
.sp-sb-banner {
    margin-top: 24px;
    background: #f4f4f4;
    border: 1px dashed #ccc;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 250px;
    color: #bbb;
    font-size: 12px;
    font-family: sans-serif;
}

/* ── Responsive ── */
@media (max-width: 960px) {
    .sp-wrap {
        grid-template-columns: 1fr;
    }
    .sp-sidebar {
        position: static;
    }
    .sp-related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .sp-title { font-size: 22px; }
}
@media (max-width: 580px) {
    .sp-related-grid {
        grid-template-columns: 1fr;
    }
    .sp-title { font-size: 19px; }
}
</style>

<?php
/* ── Ticker: latest post title from same category ── */
$cats = get_the_category();
$ticker_cat = ! empty($cats) ? $cats[0]->slug : 'news';
$ticker_q = new WP_Query(array(
    'posts_per_page' => 1,
    'category_name'  => $ticker_cat,
    'post__not_in'   => array(get_the_ID()),
));
$ticker_title = '';
if ( $ticker_q->have_posts() ) {
    $ticker_q->the_post();
    $ticker_title = get_the_title();
    wp_reset_postdata();
}
?>

<?php if ( $ticker_title ) : ?>
<div class="sp-ticker">
    <div class="sp-ticker-inner">
        <span class="sp-ticker-label">
            <?php echo esc_html( ! empty($cats) ? $cats[0]->name : 'अपडेट' ); ?> अपडेट
        </span>
        <span class="sp-ticker-text"><?php echo esc_html($ticker_title); ?></span>
    </div>
</div>
<?php endif; ?>

<div class="sp-wrap">

    <!-- ============================================
         ARTICLE
    ============================================= -->
    <article class="sp-article">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php
        /* Category tag */
        $primary_cat = ! empty($cats) ? $cats[0] : null;
        ?>
        <?php if ( $primary_cat ) : ?>
            <a class="sp-cat-tag"
               href="<?php echo esc_url( get_category_link($primary_cat->term_id) ); ?>">
                <?php echo esc_html($primary_cat->name); ?>
            </a>
        <?php endif; ?>

        <!-- Title -->
        <h1 class="sp-title"><?php the_title(); ?></h1>

        <!-- Meta -->
        <div class="sp-meta">
            <span class="sp-meta-item">
                <!-- calendar icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <?php echo get_the_date('F j, Y'); ?>
            </span>
            <span class="sp-meta-item">
                <!-- clock icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php echo get_the_time('g:i A'); ?>
            </span>
            <?php $author = get_the_author(); if ( $author ) : ?>
            <span class="sp-meta-item">
                <!-- user icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="sp-meta-author"><?php echo esc_html($author); ?></span>
            </span>
            <?php endif; ?>
        </div>

        <!-- Featured Image -->
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="sp-thumb">
            <?php the_post_thumbnail('large'); ?>
            <?php
            $caption = get_post(get_post_thumbnail_id())->post_excerpt;
            if ( $caption ) : ?>
                <p class="sp-thumb-caption"><?php echo esc_html($caption); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="sp-content">
            <?php the_content(); ?>
        </div>

        <!-- Share buttons -->
        <?php
        $share_url   = urlencode( get_permalink() );
        $share_title = urlencode( get_the_title() );
        ?>
        <div class="sp-share">
            <span class="sp-share-label">Share:</span>
            <a class="sp-share-btn sp-share-fb"
               href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"
               target="_blank" rel="noopener">
                <!-- fb icon -->
                <svg width="13" height="13" fill="#fff" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                Facebook
            </a>
            <a class="sp-share-btn sp-share-tw"
               href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>"
               target="_blank" rel="noopener">
                <svg width="13" height="13" fill="#fff" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
                Twitter
            </a>
            <a class="sp-share-btn sp-share-wa"
               href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>"
               target="_blank" rel="noopener">
                <svg width="13" height="13" fill="#fff" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                WhatsApp
            </a>
            <a class="sp-share-btn sp-share-viber"
               href="viber://forward?text=<?php echo $share_title . '%20' . $share_url; ?>"
               target="_blank" rel="noopener">
                <svg width="13" height="13" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                Viber
            </a>
        </div>

        <!-- Related posts -->
        <?php
        $related_ids = array(get_the_ID());
        $related_q = new WP_Query(array(
            'posts_per_page' => 3,
            'category_name'  => $ticker_cat,
            'post__not_in'   => $related_ids,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        if ( $related_q->have_posts() ) : ?>
        <div class="sp-related">
            <div class="sp-related-head">
                <span class="bar"></span>
                सम्बन्धित समाचार
            </div>
            <div class="sp-related-grid">
            <?php while ( $related_q->have_posts() ) : $related_q->the_post(); ?>
                <a class="sp-related-card" href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail('medium');
                    } else { ?>
                        <img src="https://placehold.co/280x120/1a1a2e/ffffff?text=ABC" alt="">
                    <?php } ?>
                    <div class="sp-related-card-body">
                        <h4><?php the_title(); ?></h4>
                        <span class="mn-date"><?php echo get_the_date('M j, Y'); ?></span>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php endwhile; endif; ?>

    </article><!-- /sp-article -->


    <!-- ============================================
         RIGHT SIDEBAR
    ============================================= -->
    <aside class="sp-sidebar">

        <span class="sp-sb-head">ताजा समाचार</span>

        <?php
        /*
         * Pull latest 10 posts from the same primary category.
         * Falls back to latest 10 across all categories.
         */
        $sb_cat   = ! empty($cats) ? $cats[0]->slug : '';
        $sb_args  = array(
            'posts_per_page' => 10,
            'post__not_in'   => array(get_the_ID()),
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        if ( $sb_cat ) {
            $sb_args['category_name'] = $sb_cat;
        }
        $sb_q = new WP_Query($sb_args);
        ?>

        <div class="sp-sb-list">
        <?php
        $idx = 1;
        if ( $sb_q->have_posts() ) :
            while ( $sb_q->have_posts() ) : $sb_q->the_post(); ?>
            <a class="sp-sb-item" href="<?php the_permalink(); ?>">
                <span class="sp-sb-num"><?php echo str_pad($idx, 2, '0', STR_PAD_LEFT); ?></span>
                <div class="sp-sb-thumb">
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail('thumbnail');
                    } else { ?>
                        <img src="https://placehold.co/80x56/1a1a2e/ffffff?text=ABC" alt="">
                    <?php } ?>
                </div>
                <div class="sp-sb-info">
                    <p class="sp-sb-title"><?php the_title(); ?></p>
                    <span class="sp-sb-date"><?php echo get_the_date('M j, Y'); ?></span>
                </div>
            </a>
            <?php
            $idx++;
            endwhile;
            wp_reset_postdata();
        else : ?>
            <p style="font-size:13px;color:#aaa;padding:16px 0;font-family:sans-serif;">
                समाचार उपलब्ध छैन।
            </p>
        <?php endif; ?>
        </div>

        <!-- Optional: ad banner slot -->
        <div class="sp-sb-banner">300 × 250 विज्ञापन</div>

    </aside><!-- /sp-sidebar -->

</div><!-- /sp-wrap -->

<?php get_footer(); ?>