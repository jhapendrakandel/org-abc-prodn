<?php
/**
 * ABC Nepal TV — header.php
 *
 * ─── SETUP: add to functions.php ─────────────────────────────────────────
 *
 * function abc_enqueue_header_assets() {
 *     wp_enqueue_style(
 *         'abc-nav',
 *         get_template_directory_uri() . '/css/header-nav.css',
 *         array(), '1.2'
 *     );
 *     wp_enqueue_style(
 *         'abc-date-bar',
 *         get_template_directory_uri() . '/css/date-bar.css',
 *         array( 'abc-nav' ), '1.0'
 *     );
 *     wp_enqueue_script(
 *         'abc-nav',
 *         get_template_directory_uri() . '/js/header-nav.js',
 *         array(), '1.2',
 *         true   // <-- load in footer so DOM exists
 *     );
 *     wp_enqueue_script(
 *         'abc-ticker-marquee',
 *         get_template_directory_uri() . '/js/ticker-marquee.js',
 *         array( 'abc-nav' ), '1.0',
 *         true
 *     );
 * }
 * add_action( 'wp_enqueue_scripts', 'abc_enqueue_header_assets' );
 *
 * ALSO: require_once get_template_directory() . '/inc/ticker-cpt.php';
 * near the top of functions.php to register the "Ticker News" admin screen.
 *
 * ─────────────────────────────────────────────────────────────────────────
 *
 * FILE PLACEMENT:
 *   header.php       → /wp-content/themes/abctvnepal/header.php
 *   header-nav.css   → /wp-content/themes/abctvnepal/css/header-nav.css
 *   header-nav.js    → /wp-content/themes/abctvnepal/js/header-nav.js
 *   date-bar.css     → /wp-content/themes/abctvnepal/css/date-bar.css
 *   ticker-marquee.js→ /wp-content/themes/abctvnepal/js/ticker-marquee.js
 *   ticker-cpt.php   → /wp-content/themes/abctvnepal/inc/ticker-cpt.php
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/8ad2fdf1ca.js" crossorigin="anonymous"></script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- =====================================================
     SITE HEADER
===================================================== -->
<header class="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo -->
        <div class="site-branding">
            <a href="<?php echo esc_url( home_url('/') ); ?>"
               aria-label="<?php esc_attr_e( 'ABC Nepal TV — होमपेज', 'abcnepal-tv' ); ?>">
                <img src="http://localhost:8080/wp-content/uploads/2026/06/logo.png"
                     alt="<?php esc_attr_e( 'ABC Nepal TV', 'abcnepal-tv' ); ?>"
                     height="42"
                     width="auto">
            </a>
        </div>

        <!-- Hamburger (visible ≤ 900px via CSS) -->
        <button
            id="abc-hamburger"
            class="hamburger-btn"
            type="button"
            aria-controls="abc-main-nav"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'मेनु खोल्नुहोस्', 'abcnepal-tv' ); ?>"
        >
            <span class="hb-box" aria-hidden="true">
                <span class="hb-line"></span>
                <span class="hb-line"></span>
                <span class="hb-line"></span>
            </span>
        </button>

        <!-- Primary navigation -->
        <nav id="abc-main-nav"
             class="main-navigation"
             aria-label="<?php esc_attr_e( 'मुख्य नेभिगेसन', 'abcnepal-tv' ); ?>">

            <!-- Mobile-only drawer label (hidden on desktop via CSS) -->
            <div class="drawer-label" aria-hidden="true">समाचार मेनु</div>

            <?php
            if ( has_nav_menu('main-menu') ) {
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'menu_class'     => 'main-menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ));
            } else {
                ?>
                <ul class="main-menu" role="list">
                    <li><a href="<?php echo esc_url( home_url('/') ); ?>"><i class="fa-solid fa-house"></i> होमपेज</a></li>
                    <li><a href="<?php echo esc_url( home_url('/mainnews/') ); ?>"><i class="fa-solid fa-newspaper"></i> मुख्य समाचार</a></li>
                    <li><a href="<?php echo esc_url( home_url('/politics/') ); ?>"><i class="fa-solid fa-building-columns"></i> राजनीति</a></li>
                    <li><a href="<?php echo esc_url( home_url('/economics/') ); ?>"><i class="fa-solid fa-chart-line"></i> अर्थ</a></li>
                    <li><a href="<?php echo esc_url( home_url('/opinion/') ); ?>"><i class="fa-solid fa-comments"></i> विचार</a></li>
                    <li><a href="<?php echo esc_url( home_url('/international/') ); ?>"><i class="fa-solid fa-earth-americas"></i> अन्तर्राष्ट्रिय</a></li>
                    <li><a href="<?php echo esc_url( home_url('/diplomacy/') ); ?>"><i class="fa-solid fa-handshake"></i> कूटनीति</a></li>
                    <li><a href="<?php echo esc_url( home_url('/sports/') ); ?>"><i class="fa-solid fa-trophy"></i> खेलकुद</a></li>
                    <li><a href="<?php echo esc_url( home_url('/abc-videos/') ); ?>"><i class="fa-solid fa-video"></i> एबीसी भिडियो</a></li>
                    <li><a href="<?php echo esc_url( home_url('/province/') ); ?>"><i class="fa-solid fa-map-location-dot"></i> प्रदेश</a></li>
                    <li><a href="<?php echo esc_url( home_url('/liveupdate/') ); ?>"><i class="fa-solid fa-circle-dot fa-beat" style="color: #ff0000;"></i> लाइभ अपडेट</a></li>
                    <li><a class="menu-highlight" href="<?php echo esc_url( home_url('/english/') ); ?>"><i class="fa-solid fa-language"></i> ENGLISH</a></li>
                </ul>
                <?php
            }
            ?>
        </nav>

    </div><!-- /header-inner -->
</header>

<!-- Backdrop overlay — sits behind drawer, above page content -->
<div id="abc-nav-overlay"
     class="nav-overlay"
     aria-hidden="true"
     style="display:none;"></div>

<!-- =====================================================
     DATE BAR — Date | Marquee ticker | Social icons
===================================================== -->
<div class="abc-date-bar">

    <!-- Nepali date -->
    <div class="nepali-date-box nep-to-eng nepali-date-converter"
         aria-label="<?php esc_attr_e( 'आजको मिति', 'abcnepal-tv' ); ?>">
        <?php echo do_shortcode('[ndc-today-date]'); ?>
    </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.nepali-date-box').forEach(function (box) {
                    // Loop through direct child nodes and remove the "Date" text node
                    box.childNodes.forEach(function (node) {
                        if (node.nodeType === 3 && node.textContent.trim() === 'Date') {
                            node.textContent = '';
                        }
                    });
                });
            });
    </script>

    <!-- Marquee ticker -->
    <?php
    $abc_ticker_items = function_exists( 'abc_get_ticker_items' ) ? abc_get_ticker_items() : array();
    $abc_ticker_count = count( $abc_ticker_items );

    /**
     * FIX: with very few items (1-3), simply duplicating once made
     * the repeat obvious because the whole loop was short. We now
     * first repeat the item set enough times to comfortably fill a
     * wide screen (min 6 "slots"), THEN duplicate that padded set
     * once for the seamless -50% wrap-around loop.
     */
    $abc_min_slots = 6;
    $abc_repeat    = $abc_ticker_count > 0 ? max( 1, (int) ceil( $abc_min_slots / $abc_ticker_count ) ) : 1;
    ?>
    <div class="abc-ticker-wrap" role="region" aria-label="<?php esc_attr_e( 'ताजा अपडेट', 'abcnepal-tv' ); ?>">
        <?php if ( ! empty( $abc_ticker_items ) ) : ?>
            <span class="abc-ticker-label"><?php _e( 'ताजा अपडेट', 'abcnepal-tv' ); ?></span>
            <div class="abc-ticker-track">
                <div class="abc-ticker-content" id="abc-ticker-content">
                    <?php
                    // Render the padded set TWICE total (for the seamless -50% loop).
                    for ( $pass = 0; $pass < 2; $pass++ ) :
                        for ( $r = 0; $r < $abc_repeat; $r++ ) :
                            foreach ( $abc_ticker_items as $item ) :
                                $link   = get_post_meta( $item->ID, '_abc_ticker_link', true );
                                $tag    = $link ? 'a' : 'span';
                                $hidden = ( $pass === 1 ) ? ' aria-hidden="true"' : '';
                            ?>
                                <<?php echo $tag; ?> class="abc-ticker-item"<?php echo $hidden; ?>
                                    <?php if ( $link ) : ?>href="<?php echo esc_url( $link ); ?>"<?php endif; ?>>
                                    <?php echo esc_html( get_the_title( $item ) ); ?>
                                </<?php echo $tag; ?>>
                                <span class="abc-ticker-sep" aria-hidden="true">●</span>
                            <?php endforeach;
                        endfor;
                    endfor;
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Social icons -->
    <div class="abc-social-icons">
        <a href="https://youtube.com/@yourchannel" target="_blank" rel="noopener" aria-label="YouTube" class="abc-social yt">
            <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://facebook.com/yourpage" target="_blank" rel="noopener" aria-label="Facebook" class="abc-social fb">
            <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://x.com/yourhandle" target="_blank" rel="noopener" aria-label="X" class="abc-social x">
            <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a href="mailto:news@abcnepaltv.com" aria-label="Email" class="abc-social mail">
            <i class="fa-solid fa-envelope"></i>
        </a>
    </div>

</div><!-- /abc-date-bar -->

<?php do_action('abcs_after_header'); ?>