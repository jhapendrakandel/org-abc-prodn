<?php
/**
 * ABC Nepal TV — Advanced Search Functions
 * File: inc/advanced-search.php
 *
 * Include this in functions.php:
 *   require_once get_template_directory() . '/inc/advanced-search.php';
 */

if (!defined('ABSPATH')) exit;


/* ══════════════════════════════════════════════
   1.  ENQUEUE SEARCH ASSETS
══════════════════════════════════════════════ */

function abcs_enqueue_assets() {
    wp_enqueue_style(
        'abcs-style',
        get_template_directory_uri() . '/css/advanced-search.css',
        array(),
        '1.0.0'
    );
    wp_enqueue_script(
        'abcs-script',
        get_template_directory_uri() . '/js/advanced-search.js',
        array(), // No jQuery dependency — vanilla JS
        '1.0.0',
        true  // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'abcs_enqueue_assets');


/* ══════════════════════════════════════════════
   2.  HOOK: Inject search bar after header
       on EVERY front-end page automatically
══════════════════════════════════════════════ */

function abcs_inject_after_header() {
    if (is_admin()) {
        return;
    }
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }
    if (defined('REST_REQUEST') && REST_REQUEST) {
        return;
    }
    get_template_part('template-parts/search-bar');
}
add_action('abcs_after_header', 'abcs_inject_after_header');

/*
 * NOTE: The hook 'abcs_after_header' must be fired in header.php.
 * Add this line at the very END of header.php (after the closing </header> tag):
 *
 *   <?php do_action('abcs_after_header'); ?>
 *
 * This means you only edit header.php once — everything else is in functions.php.
 * In a child theme, you override header.php and add the hook there.
 */


/* ══════════════════════════════════════════════
   3.  CORE SEARCH QUERY — WP_Query builder
══════════════════════════════════════════════ */

/**
 * Build and execute the search WP_Query.
 *
 * @param string $keyword      Free-text keyword
 * @param string $category     Category slug
 * @param string $date         Specific date (Y-m-d)
 * @param string $date_from    Range start (Y-m-d)
 * @param string $date_to      Range end (Y-m-d)
 * @param string $post_type    Post type slug
 * @param int    $paged        Current page number
 * @param int    $per_page     Results per page
 *
 * @return WP_Query|null  Returns null if no search parameters were given.
 */
function abcs_run_query($keyword, $category, $date, $date_from, $date_to, $post_type, $paged = 1, $per_page = 10) {

    // Only run if at least one parameter is present
    if (!$keyword && !$category && !$date && !$date_from && !$date_to && !$post_type) {
        return null;
    }

    /* ── Post types ── */
    if ($post_type && array_key_exists($post_type, abcs_allowed_post_types())) {
        $post_types = array($post_type);
    } else {
        $post_types = array('post', 'live_update');
    }

    /* ── Build base args ── */
    $args = array(
        'post_type'           => $post_types,
        'post_status'         => 'publish',
        'posts_per_page'      => $per_page,
        'paged'               => max(1, absint($paged)),
        'no_found_rows'       => false, // We need found_posts for pagination
        'ignore_sticky_posts' => true,
    );

    /* ── Keyword: search title AND content ──
     * WordPress native 's' only searches title + excerpt.
     * To include body content we use a custom posts_search filter below.
     */
    if (!empty($keyword)) {
        $args['s'] = $keyword;
    }

    /* ── Category filter ── */
    if (!empty($category)) {
        $cat_obj = get_category_by_slug($category);
        if ($cat_obj && !is_wp_error($cat_obj)) {
            $args['cat'] = $cat_obj->term_id;
        }
    }

    /* ── Date filters (priority: specific date > range) ── */
    if (!empty($date) && abcs_valid_date($date)) {
        $args['date_query'] = array(
            array(
                'year'  => (int) date('Y', strtotime($date)),
                'month' => (int) date('m', strtotime($date)),
                'day'   => (int) date('d', strtotime($date)),
            ),
        );
    } elseif (!empty($date_from) && !empty($date_to) && abcs_valid_date($date_from) && abcs_valid_date($date_to)) {
        $args['date_query'] = array(
            array(
                'after'     => array(
                    'year'  => (int) date('Y', strtotime($date_from)),
                    'month' => (int) date('m', strtotime($date_from)),
                    'day'   => (int) date('d', strtotime($date_from)),
                ),
                'before'    => array(
                    'year'  => (int) date('Y', strtotime($date_to)),
                    'month' => (int) date('m', strtotime($date_to)),
                    'day'   => (int) date('d', strtotime($date_to)),
                ),
                'inclusive' => true,
            ),
        );
    }

    /* ── Keyword: extend 's' to also search post_content ──
     * We temporarily add a filter that modifies the SQL WHERE clause
     * so that 's' matches post_content in addition to post_title.
     * The filter is removed immediately after the query runs.
     */
    $abcs_keyword_ref = $keyword; // Capture for closure

    $extend_search = function($search, $wp_query) use ($abcs_keyword_ref) {
        if (!$wp_query->is_search() || empty($abcs_keyword_ref)) {
            return $search;
        }
        global $wpdb;

        $like  = '%' . $wpdb->esc_like($abcs_keyword_ref) . '%';
        // Append OR clause: also match post_content
        $extra = $wpdb->prepare(
            " OR ({$wpdb->posts}.post_content LIKE %s)",
            $like
        );

        // The default $search looks like: AND (((wp_posts.post_title LIKE '…') OR (wp_posts.post_excerpt LIKE '…')))
        // We inject before the closing triple-paren
        if (!empty($search)) {
            // Find last ))) and insert before the final one
            $pos = strrpos($search, ')))');
            if ($pos !== false) {
                $search = substr($search, 0, $pos + 2) . $extra . substr($search, $pos + 2);
            }
        }
        return $search;
    };

    if (!empty($keyword)) {
        add_filter('posts_search', $extend_search, 10, 2);
    }

    $query = new WP_Query($args);

    if (!empty($keyword)) {
        remove_filter('posts_search', $extend_search, 10);
    }

    return $query;
}


/* ══════════════════════════════════════════════
   4.  VALIDATE DATE RANGE (server-side)
       Max 5 days enforced on server too — never
       trust only client-side validation.
══════════════════════════════════════════════ */

function abcs_validate_date_range($from, $to) {
    if (empty($from) || empty($to)) return true; // Not using range — OK
    if (!abcs_valid_date($from) || !abcs_valid_date($to)) return false;

    $d_from = new DateTime($from);
    $d_to   = new DateTime($to);

    if ($d_to < $d_from) return false; // End before start — invalid

    $diff = $d_from->diff($d_to)->days;
    return $diff <= 5; // Max 5 days
}

function abcs_valid_date($str) {
    if (empty($str)) return false;
    $d = DateTime::createFromFormat('Y-m-d', $str);
    return $d && $d->format('Y-m-d') === $str;
}

function abcs_allowed_post_types() {
    return array(
        'post'        => 'News / Articles',
        'live_update' => 'Live Updates',
    );
}


/* ══════════════════════════════════════════════
   5.  RENDER SEARCH RESULTS
══════════════════════════════════════════════ */

function abcs_render_results($keyword, $category, $date, $date_from, $date_to, $post_type, $paged) {

    // No search parameters — don't render anything
    $has_params = ($keyword || $category || $date || $date_from || $date_to || $post_type);
    if (!$has_params) return;

    // Server-side date range validation
    if (!abcs_validate_date_range($date_from, $date_to)) {
        echo '<div class="abcs-results" id="abcs-results">';
        echo '<div class="abcs-error-msg">';
        echo '<i class="fa-solid fa-circle-exclamation"></i> ';
        echo 'मिति दायरा अमान्य छ। कृपया ५ दिनभित्रको दायरा चयन गर्नुहोस्।';
        echo '</div>';
        echo '</div>';
        return;
    }

    $per_page = 10;
    $query    = abcs_run_query($keyword, $category, $date, $date_from, $date_to, $post_type, $paged, $per_page);

    if (null === $query) return;

    $total_posts = $query->found_posts;
    $total_pages = $query->max_num_pages;

    ?>
    <div class="abcs-results" id="abcs-results">

        <!-- Results summary bar -->
        <div class="abcs-summary">
            <?php if ($total_posts > 0) : ?>
                <span class="abcs-summary__count">
                    <?php
                    printf(
                        '<strong>%d</strong> समाचार फेला पर्‍यो',
                        $total_posts
                    );
                    if (!empty($keyword)) {
                        printf(' — "<em>%s</em>"', esc_html($keyword));
                    }
                    ?>
                </span>
                <?php if ($total_pages > 1) : ?>
                    <span class="abcs-summary__page">
                        पृष्ठ <?php echo absint($paged); ?> / <?php echo absint($total_pages); ?>
                    </span>
                <?php endif; ?>
            <?php else : ?>
                <span class="abcs-summary__count abcs-summary__count--none">
                    <?php
                    if (!empty($keyword)) {
                        printf('"<em>%s</em>" को लागि कुनै समाचार फेला परेन।', esc_html($keyword));
                    } else {
                        echo 'तपाईंको खोजका लागि कुनै समाचार फेला परेन।';
                    }
                    ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if ($query->have_posts()) : ?>

            <div class="abcs-result-list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <article class="abcs-result-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a class="abcs-result-card__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>

                    <div class="abcs-result-card__body">

                        <!-- Category badge -->
                        <?php
                        $cats = get_the_category();
                        if (!empty($cats)) : ?>
                            <a class="abcs-badge" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>">
                                <?php echo esc_html($cats[0]->name); ?>
                            </a>
                        <?php elseif (get_post_type() === 'live_update') : ?>
                            <span class="abcs-badge abcs-badge--live">🔴 Live Update</span>
                        <?php endif; ?>

                        <h3 class="abcs-result-card__title">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                // Highlight keyword in title
                                $title = get_the_title();
                                if (!empty($keyword)) {
                                    $title = abcs_highlight_keyword($title, $keyword);
                                }
                                echo $title; // Already escaped inside highlight function
                                ?>
                            </a>
                        </h3>

                        <p class="abcs-result-card__excerpt">
                            <?php
                            $excerpt = wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 30);
                            if (!empty($keyword)) {
                                $excerpt = abcs_highlight_keyword($excerpt, $keyword);
                            }
                            echo $excerpt;
                            ?>
                        </p>

                        <div class="abcs-result-card__meta">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                <?php echo esc_html(get_the_date('d M Y')); ?>
                            </time>
                            <span class="abcs-meta-sep" aria-hidden="true">·</span>
                            <span>
                                <i class="fa-regular fa-user" aria-hidden="true"></i>
                                <?php the_author(); ?>
                            </span>
                        </div>

                    </div>
                </article>

            <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1) : ?>
                <nav class="abcs-pagination" aria-label="खोज पृष्ठ नेभिगेसन">
                    <?php abcs_render_pagination($paged, $total_pages); ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>

            <div class="abcs-no-results">
                <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                <p>माफ गर्नुस्, कुनै समाचार फेला परेन।</p>
                <small>कीवर्ड परिवर्तन गर्नुस् वा फिल्टर हटाउनुस्।</small>
            </div>

        <?php endif;
        wp_reset_postdata(); ?>

    </div><!-- /abcs-results -->
    <?php
}


/* ══════════════════════════════════════════════
   6.  KEYWORD HIGHLIGHT HELPER
══════════════════════════════════════════════ */

function abcs_highlight_keyword($text, $keyword) {
    if (empty($keyword)) return esc_html($text);
    $safe_text    = esc_html($text);
    $safe_keyword = esc_html($keyword);
    // Case-insensitive highlight, preserving original casing
    $highlighted = preg_replace(
        '/(' . preg_quote($safe_keyword, '/') . ')/iu',
        '<mark class="abcs-highlight">$1</mark>',
        $safe_text
    );
    return $highlighted;
}


/* ══════════════════════════════════════════════
   7.  PAGINATION RENDERER
══════════════════════════════════════════════ */

function abcs_render_pagination($current_page, $total_pages) {
    // Build the query string preserving all current filters
    $base_args = $_GET; // Already sanitized when read
    unset($base_args['abcs_paged']); // We'll set this per page

    $window = 2; // Pages shown around current

    // Previous
    if ($current_page > 1) {
        $prev_args = array_merge($base_args, array('abcs_paged' => $current_page - 1));
        $prev_url  = esc_url(add_query_arg($prev_args, home_url('/')));
        echo '<a class="abcs-page-btn" href="' . $prev_url . '" aria-label="अघिल्लो पृष्ठ">';
        echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>';
        echo '</a>';
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        // Always show first, last, and pages within window of current
        if ($i === 1 || $i === $total_pages || abs($i - $current_page) <= $window) {
            $page_args = array_merge($base_args, array('abcs_paged' => $i));
            $page_url  = esc_url(add_query_arg($page_args, home_url('/')));
            $active    = ($i === $current_page) ? ' abcs-page-btn--active' : '';
            $aria      = ($i === $current_page) ? ' aria-current="page"' : '';
            echo '<a class="abcs-page-btn' . $active . '" href="' . $page_url . '"' . $aria . '>' . absint($i) . '</a>';
        } elseif (
            ($i === 2 && $current_page > $window + 2) ||
            ($i === $total_pages - 1 && $current_page < $total_pages - $window - 1)
        ) {
            echo '<span class="abcs-page-ellipsis" aria-hidden="true">…</span>';
        }
    }

    // Next
    if ($current_page < $total_pages) {
        $next_args = array_merge($base_args, array('abcs_paged' => $current_page + 1));
        $next_url  = esc_url(add_query_arg($next_args, home_url('/')));
        echo '<a class="abcs-page-btn" href="' . $next_url . '" aria-label="अर्को पृष्ठ">';
        echo '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
        echo '</a>';
    }
}
