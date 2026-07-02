<?php
/*
Template Name: Province
Description: Full province page with tabbed sub-categories
*/
get_header();

// Re-use the province rendering function from index.php
// We'll define it here if not already available
if ( ! function_exists( 'abc_render_province_page' ) ) {
    function abc_render_province_page() {
        $provinces = array(
            'koshi'        => array( 'label' => 'कोशी',        'slug' => 'provincial_koshi' ),
            'madhesh'      => array( 'label' => 'मधेश',        'slug' => 'provincial_madhesh' ),
            'bagmati'      => array( 'label' => 'बागमती',      'slug' => 'provincial_bagmati' ),
            'gandaki'      => array( 'label' => 'गण्डकी',      'slug' => 'provincial_gandaki' ),
            'lumbini'      => array( 'label' => 'लुम्बिनी',    'slug' => 'provincial_lumbini' ),
            'karnali'      => array( 'label' => 'कर्णाली',     'slug' => 'provincial_karnali' ),
            'sudurpaschim' => array( 'label' => 'सुदूरपश्चिम', 'slug' => 'provincial_sudurpaschim' ),
        );

        $featured_count = 1;
        $list_count     = 8;
        $parent_slug    = 'province';
        $parent_term    = get_category_by_slug( $parent_slug );
        ?>
        <div class="nyt-wrap province-page-wrap">
            <div class="nyt-band nyt-province-section">
                <div class="nyt-band-head">
                    <h2>प्रदेश</h2>
                    <a class="nyt-view-all" href="<?php echo esc_url( home_url( '/province/' ) ); ?>">थप समाचार &rsaquo;</a>
                </div>

                <div class="nyt-province-tabs" role="tablist" aria-label="प्रदेशहरू">
                    <button type="button" class="nyt-ptab active" data-ptab="home" role="tab" aria-selected="true" aria-controls="panel-home" aria-label="सबै प्रदेश">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M3 11L12 3L21 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5 10V20C5 20.5523 5.44772 21 6 21H9C9.55228 21 10 20.5523 10 20V15C10 14.4477 10.4477 14 11 14H13C13.5523 14 14 14.4477 14 15V20C14 20.5523 14.4477 21 15 21H18C18.5523 21 19 20.5523 19 20V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>सबै</span>
                    </button>
                    <?php foreach ( $provinces as $key => $p ) : ?>
                        <button type="button" class="nyt-ptab" data-ptab="<?php echo esc_attr( $key ); ?>" role="tab" aria-selected="false" aria-controls="panel-<?php echo esc_attr( $key ); ?>">
                            <?php echo esc_html( $p['label'] ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php
                // ── HOME panel: latest posts across the whole province tree ──
                $home_args = array(
                    'posts_per_page' => $featured_count + $list_count,
                );
                if ( $parent_term && ! is_wp_error( $parent_term ) ) {
                    $home_args['cat'] = $parent_term->term_id;
                } else {
                    $home_args['category_name'] = $parent_slug;
                }
                $home_query = new WP_Query( $home_args );
                $home_posts = $home_query->posts;
                wp_reset_postdata();
                abc_render_province_panel( 'home', $home_posts, $featured_count, 'सबै प्रदेशका समाचार' );

                // ── One panel per province sub-category ──
                foreach ( $provinces as $key => $p ) {
                    $pq = new WP_Query( array(
                        'posts_per_page' => $featured_count + $list_count,
                        'category_name'  => $p['slug'],
                    ) );
                    $p_posts = $pq->posts;
                    wp_reset_postdata();
                    abc_render_province_panel( $key, $p_posts, $featured_count, $p['label'] );
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'abc_render_province_panel' ) ) {
    function abc_render_province_panel( $key, $posts, $featured_count = 1, $title = '' ) {
        $active_class = ( 'home' === $key ) ? ' active' : '';
        $panel_id     = 'panel-' . esc_attr( $key );
        ?>
        <div class="nyt-province-panel<?php echo esc_attr( $active_class ); ?>" id="<?php echo $panel_id; ?>" data-ptab="<?php echo esc_attr( $key ); ?>" role="tabpanel" <?php echo ( 'home' === $key ) ? 'aria-hidden="false"' : 'aria-hidden="true"'; ?>>
            <?php if ( empty( $posts ) ) : ?>
                <p class="nyt-empty"><?php echo esc_html( $title ?: 'यस प्रदेशका समाचार' ); ?> छिट्टै थपिनेछन्।</p>
            <?php else :
                $featured = array_slice( $posts, 0, $featured_count );
                $rest     = array_slice( $posts, $featured_count );
                ?>
                <div class="nyt-province-grid">
                    ="nyt-province-featured">
                        <?php foreach ( $featured as $fp ) : $fp_id = $fp->ID; ?>
                            ="nyt-province-feature-card">
                                ="nyt-province-feature-media">
                                    ="<?php echo esc_url( get_permalink( $fp_id ) ); ?>">
                                        <?php if ( has_post_thumbnail( $fp_id ) ) {
                                            echo get_the_post_thumbnail( $fp_id, 'large' );
                                        } else { ?>
                                            ="https://placehold.co/700x480/eeeeee/999999?text=Photo" alt="">
                                        <?php } ?>
                                    </a>
                                </div>
                                <h3><a href="<?php echo esc_url( get_permalink( $fp_id ) ); ?>"><?php echo esc_html( get_the_title( $fp_id ) ); ?></a></h3>
                                <p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $fp_id ), 26 ) ); ?></p>
                                <div class="nyt-byline-row">
                                    <span class="nyt-byline"><?php echo esc_html( abc_get_byline( $fp_id ) ); ?></span>
                                    <span class="nyt-readtime"><?php echo esc_html( abc_get_read_time( $fp_id ) ); ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if ( ! empty( $rest ) ) : ?>
                        <ul class="nyt-province-list">
                            <?php foreach ( $rest as $rp ) : $rp_id = $rp->ID; ?>
                                ="nyt-province-list-item">
                                    ="nyt-province-list-media" href="<?php echo esc_url( get_permalink( $rp_id ) ); ?>">
                                        <?php if ( has_post_thumbnail( $rp_id ) ) {
                                            echo get_the_post_thumbnail( $rp_id, 'thumbnail' );
                                        } else { ?>
                                            ="https://placehold.co/120x90/eeeeee/999999?text=+" alt="">
                                        <?php } ?>
                                    </a>
                                    <div class="nyt-province-list-text">
                                        <h4><a href="<?php echo esc_url( get_permalink( $rp_id ) ); ?>"><?php echo esc_html( get_the_title( $rp_id ) ); ?></a></h4>
                                        <span class="nyt-province-list-time"><?php echo esc_html( abc_get_read_time( $rp_id ) ); ?></span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

// Helper functions
if ( ! function_exists( 'abc_get_read_time' ) ) {
    function abc_get_read_time( $post_id ) {
        $content = get_post_field( 'post_content', $post_id );
        $words   = str_word_count( wp_strip_all_tags( $content ) );
        $minutes = max( 1, (int) ceil( $words / 200 ) );
        return $minutes . ' MIN READ';
    }
}

if ( ! function_exists( 'abc_get_byline' ) ) {
    function abc_get_byline( $post_id ) {
        $author_id = get_post_field( 'post_author', $post_id );
        $name      = get_the_author_meta( 'display_name', $author_id );
        return 'By ' . $name;
    }
}

// ── Page Output ──
abc_render_province_page();

get_footer();