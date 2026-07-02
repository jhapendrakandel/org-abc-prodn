<?php
/**
 * Footer Template - ABC NEWS NEPAL
 * Cleaned & Compact Fat Footer Design
 */
?>

<style>
/* ============================================
   ABC NEWS NEPAL - COMPACT FOOTER CSS
   ============================================ */

/* Footer Ticker Bar */
.footer-ticker {
    background: #cc0000;
    padding: 6px 0;
    overflow: hidden;
    white-space: nowrap;
}
.footer-ticker .ticker-label {
    display: inline-block;
    background: #1a1a6e;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 10px;
    margin-right: 15px;
    vertical-align: middle;
    text-transform: uppercase;
    border-radius: 3px;
}
.footer-ticker .ticker-content {
    display: inline-block;
    animation: ticker 30s linear infinite;
    font-size: 12.5px;
    color: #fff;
    font-weight: 600;
    vertical-align: middle;
}

/* Footer Social Bar */
.footer-social-bar {
    background: #f8f8f8;
    border-top: 3px solid #cc0000;
    border-bottom: 1px solid #e0e0e0;
    padding: 12px 0;
}
.footer-social-bar .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}
.footer-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}
.footer-brand img {
    width: 60px;
    height: 60px;
    object-fit: contain;
}
.footer-brand-text {
    display: flex;
    flex-direction: column;
}
.footer-brand-text .brand-name {
    font-size: 18px;
    font-weight: 900;
    color: #1a1a6e;
    line-height: 1.1;
    font-family: 'Mukta', sans-serif;
}
.footer-brand-text .brand-tagline {
    font-size: 12px;
    color: #cc0000;
    font-weight: 600;
}
.footer-social-icons {
    display: flex;
    align-items: center;
    gap: 8px;
}
.footer-social-icons a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    transition: all 0.2s ease;
}
.footer-social-icons a.fb { background: #1877f2; }
.footer-social-icons a.tw { background: #1da1f2; }
.footer-social-icons a.yt { background: #ff0000; }
.footer-social-icons a.ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.footer-social-icons a.wa { background: #25d366; }
.footer-social-icons a.yt-tv {
    background: #cc0000;
    font-size: 11px;
    font-weight: 800;
    padding: 0 10px;
    width: auto;
}
.footer-social-icons a:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

/* Main Footer Body */
.site-footer-main {
    background: #0d0d2b;
    padding: 35px 0 20px;
    color: #ccc;
}
.site-footer-main .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1fr 1fr;
    gap: 30px;
}
.footer-col h3.footer-col-title {
    font-size: 15px;
    font-weight: 800;
    color: #e8b800;
    margin: 0 0 12px 0;
    padding-bottom: 6px;
    border-bottom: 2px solid #cc0000;
    text-transform: uppercase;
    font-family: 'Mukta', sans-serif;
}
.footer-reg-info {
    background: rgba(255,255,255,0.04);
    border-left: 3px solid #cc0000;
    padding: 8px 12px;
    border-radius: 0 4px 4px 0;
    margin-bottom: 12px;
    font-size: 12.5px;
    color: #b0b0c8;
}
.footer-contact-block h4 {
    font-size: 13.5px;
    font-weight: 800;
    color: #e8b800;
    margin: 12px 0 6px 0;
}
.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-bottom: 6px;
    font-size: 13px;
    color: #b0b0c8;
}
.footer-contact-item a {
    color: #b0b0c8;
    text-decoration: none;
}
.footer-contact-item a:hover { color: #e8b800; }

/* Ads block */
.footer-advert-block {
    background: rgba(204,0,0,0.08);
    border: 1px solid rgba(204,0,0,0.2);
    border-radius: 6px;
    padding: 10px 12px;
}
.footer-advert-block .phone-number a {
    font-size: 14.5px;
    font-weight: 800;
    color: #e8b800;
    text-decoration: none;
    display: block;
    margin-bottom: 2px;
}

/* Nav grids & lists */
.footer-nav-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4px 10px;
}
.footer-nav-grid a {
    color: #b0b0c8;
    text-decoration: none;
    font-size: 13px;
    padding: 4px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-family: 'Mukta', sans-serif;
}
.footer-nav-grid a:hover { color: #e8b800; padding-left: 4px; transition: all 0.2s; }

.footer-team-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.footer-team-list li {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 13px;
}
.footer-team-list .role { color: #cc0000; font-weight: 700; font-size: 11px; }
.footer-team-list .name { color: #e8e8ff; font-weight: 600; font-family: 'Mukta', sans-serif; }

/* Bottom Bar */
.footer-divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,0.06);
    margin: 20px 0;
}
.footer-bottom-bar {
    background: #07071a;
    padding: 12px 0;
}
.footer-bottom-bar .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.footer-copyright { font-size: 12px; color: #7070a0; }
.footer-bottom-links { display: flex; gap: 15px; }
.footer-bottom-links a { font-size: 12px; color: #7070a0; text-decoration: none; }
.footer-bottom-links a:hover { color: #e8b800; }

@keyframes ticker {
    0% { transform: translateX(100vw); }
    100% { transform: translateX(-100%); }
}

/* Responsive fixes */
@media (max-width: 1024px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 768px) {
    .footer-social-bar .container, .footer-bottom-bar .container { flex-direction: column; align-items: center; text-align: center; }
    .footer-grid { grid-template-columns: 1fr; gap: 20px; }
    .footer-team-list li { flex-direction: column; align-items: center; }
}
</style>

<!-- TICKER BAR -->
<div class="footer-ticker">
    <span class="ticker-label">&#x1F534; LIVE</span>
    <span class="ticker-content">
        ABC NEWS NEPAL | No.1 News Channel of Nepal | सत्य, सन्तुलित र विश्वसनीय समाचार | Lazimpat, Ranibari, Kathmandu
    </span>
</div>

<!-- SOCIAL BAR -->
<div class="footer-social-bar">
    <div class="container">
        <div class="footer-brand">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo): ?>
                <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" />
            <?php else: ?>
<img src="<?php echo esc_url(get_template_directory_uri() . '/abc.png'); ?>" alt="<?php esc_attr_e('ABC Nepal TV', 'abcnepal-tv'); ?>">
            <?php endif; ?>
            <div class="footer-brand-text">
                <span class="brand-name">ABC NEWS NEPAL</span>
                <span class="brand-tagline">सत्य, सन्तुलित र विश्वसनीय समाचार</span>
            </div>
        </div>

        <div class="footer-social-icons">
            <a href="https://www.facebook.com/abctvnepal" target="_blank" rel="noopener" class="fb" title="Facebook">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://twitter.com/abctvnepal" target="_blank" rel="noopener" class="tw" title="Twitter/X">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <a href="https://www.youtube.com/c/ABCNewsNepal" target="_blank" rel="noopener" class="yt" title="YouTube">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
            <a href="https://www.instagram.com/abctvnepal" target="_blank" rel="noopener" class="ig" title="Instagram">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="https://wa.me/9779802082541" target="_blank" rel="noopener" class="wa" title="WhatsApp">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
            </a>
            <a href="https://www.youtube.com/c/ABCNewsNepal/live" target="_blank" rel="noopener" class="yt-tv" title="Watch Live">
                &#x1F534; LIVE TV
            </a>
        </div>
    </div>
</div>

<!-- MAIN FOOTER -->
<footer class="site-footer-main">
    <div class="container">
        <div class="footer-grid">

            <!-- COLUMN 1: About -->
            <div class="footer-col">
                <h3 class="footer-col-title">एबीसी मिडिया ग्रुप प्रा.लि.</h3>
                <div class="footer-reg-info">
                    <strong>&#x1F4CB; सूचना विभाग दर्ता नं.:</strong> २००१।०७७–०७८
                </div>
                <div class="footer-contact-block">
                    <div class="footer-contact-item">
                        <span>&#x1F4CD;</span>
                        <span>Ranibari, Lazimpat, Kathmandu</span>
                    </div>
                    <div class="footer-contact-item">
                        <span>&#x260E;</span>
                        <div>
                            <a href="tel:+97714240666">+977-1-4240666</a> / 
                            <a href="tel:+977014011122">4011122</a>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <span>&#x1F4E7;</span>
                        <a href="mailto:abctvnepal.tvnews@gmail.com">abctvnepal.tvnews@gmail.com</a>
                    </div>
                </div>
            </div>

            <!-- COLUMN 2: Ads & Nav -->
            <div class="footer-col">
                <h3 class="footer-col-title">विज्ञापन सम्पर्क</h3>
                <div class="footer-advert-block">
                    <span class="phone-number"><a href="tel:+9779802082541">+977 9802082541</a></span>
                    <span class="phone-number"><a href="tel:+9779802060000">9802060000</a></span>
                </div>
                <h3 class="footer-col-title" style="margin-top:15px;">नेभिगेसन</h3>
                <div class="footer-nav-grid">
                    <a href="<?php echo home_url('/'); ?>">गृहपृष्ठ</a>
                    <a href="<?php echo home_url('/category/samachar'); ?>">समाचार</a>
                    <a href="<?php echo home_url('/category/antarvarti'); ?>">अन्तर्वार्ता</a>
                    <a href="<?php echo home_url('/category/abc-biz'); ?>">एबीसी बिज</a>
                </div>
            </div>

            <!-- COLUMN 3: Categories -->
            <div class="footer-col">
                <h3 class="footer-col-title">समाचार श्रेणी</h3>
                <div class="footer-nav-grid" style="grid-template-columns: 1fr;">
                    <?php
                    $uncategorized = get_category_by_slug('uncategorized');
                    $exclude_id = $uncategorized ? $uncategorized->term_id : 0;

                    $categories = get_categories(array(
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'number'     => 6, /* Lowered to keep things compact */
                        'hide_empty' => true,
                        'exclude'    => $exclude_id,
                    ));

                    if ($categories) {
                        foreach ($categories as $cat) {
                            echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">';
                            echo '&#x25B6; ' . esc_html($cat->name) . ' <span style="opacity:0.6; font-size:11px;">(' . $cat->count . ')</span>';
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- COLUMN 4: Team -->
            <div class="footer-col">
                <h3 class="footer-col-title">हाम्रो टिम</h3>
                <ul class="footer-team-list">
                    <li>
                        <span class="role">अध्यक्ष / सम्पादक</span>
                        <span class="name">शुभशंकर कँдेल</span>
                    </li>
                    <li>
                        <span class="role">प्रबन्ध निर्देशक</span>
                        <span class="name">शारदा शर्मा</span>
                    </li>
                    <li>
                        <span class="role">सम्पादक</span>
                        <span class="name">डण्ड गुरुङ</span>
                    </li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider">
    </div>
</footer>

<!-- BOTTOM BAR -->
<div class="footer-bottom-bar">
    <div class="container">
        <div class="footer-copyright">
            &copy; <?php echo date('Y'); ?> <strong>ABC NEWS NEPAL</strong> | Website by <a href="https://appharu.com" target="_blank" rel="noopener">ABCNewsNepal</a>
        </div>
        <div class="footer-bottom-links">
            <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy</a>
            <a href="<?php echo home_url('/terms-of-service'); ?>">Terms</a>
            <a href="<?php echo home_url('/contact'); ?>">Contact</a>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>