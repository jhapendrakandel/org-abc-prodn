<?php
/**
 * ABC Nepal TV — Advanced News Search Bar (v2 — floating results, fixed filters)
 * Template Part: template-parts/search-bar.php
 */

$search_categories = get_categories(array(
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => true,
));

$search_post_types = array(
    'post'        => 'News / Articles',
    'live_update' => 'Live Updates',
);

$cur_keyword   = isset($_GET['abcs_q'])        ? sanitize_text_field($_GET['abcs_q'])        : '';
$cur_cat       = isset($_GET['abcs_cat'])       ? sanitize_text_field($_GET['abcs_cat'])       : '';
$cur_date      = isset($_GET['abcs_date'])      ? sanitize_text_field($_GET['abcs_date'])      : '';
$cur_date_from = isset($_GET['abcs_from'])      ? sanitize_text_field($_GET['abcs_from'])      : '';
$cur_date_to   = isset($_GET['abcs_to'])        ? sanitize_text_field($_GET['abcs_to'])        : '';
$cur_post_type = isset($_GET['abcs_post_type']) ? sanitize_text_field($_GET['abcs_post_type']) : '';
$cur_page      = isset($_GET['abcs_paged'])     ? max(1, absint($_GET['abcs_paged']))           : 1;

$has_active_filters = ($cur_cat || $cur_date || $cur_date_from || $cur_date_to || $cur_post_type);
$search_nonce = wp_create_nonce('abcs_search_nonce');
?>

<section class="abcs-wrap" id="abcs-search-section" aria-label="समाचार खोज्नुहोस्">
    <div class="abcs-inner">

        <form
            class="abcs-form"
            id="abcs-form"
            method="GET"
            action="<?php echo esc_url(home_url('/')); ?>"
            role="search"
            aria-label="Advanced News Search"
            novalidate
        >
            <input type="hidden" name="abcs_nonce" value="<?php echo esc_attr($search_nonce); ?>">
            <input type="hidden" name="abcs_paged" value="1" id="abcs-paged-input">

            <div class="abcs-keyword-row">
                <div class="abcs-field abcs-field--keyword">
                    <svg class="abcs-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input
                        type="search"
                        id="abcs-q"
                        name="abcs_q"
                        class="abcs-input abcs-input--keyword"
                        placeholder="शीर्षक वा सामग्री खोज्नुहोस्…"
                        value="<?php echo esc_attr($cur_keyword); ?>"
                        autocomplete="off"
                    >
                </div>

                <button type="button" class="abcs-toggle-filters" id="abcs-toggle-filters" aria-expanded="<?php echo $has_active_filters ? 'true' : 'false'; ?>">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" width="16" height="16">
                        <line x1="4" y1="6" x2="20" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <line x1="4" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <line x1="4" y1="18" x2="20" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="9" cy="6" r="2" fill="#1a1a2e" stroke="currentColor" stroke-width="2"/>
                        <circle cx="15" cy="12" r="2" fill="#1a1a2e" stroke="currentColor" stroke-width="2"/>
                        <circle cx="9" cy="18" r="2" fill="#1a1a2e" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>फिल्टर</span>
                    <svg class="abcs-chevron" viewBox="0 0 24 24" fill="none" width="14" height="14" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <button type="submit" class="abcs-btn abcs-btn--search" id="abcs-submit">
                    खोज्नुहोस्
                </button>
            </div>

            <div class="abcs-filters" id="abcs-filters" <?php echo $has_active_filters ? '' : 'hidden'; ?>>

                <div class="abcs-field">
                    <label for="abcs-cat" class="abcs-label">वर्ग</label>
                    <select id="abcs-cat" name="abcs_cat" class="abcs-select">
                        <option value="">— सबै वर्ग —</option>
                        <?php foreach ($search_categories as $cat) : ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($cur_cat, $cat->slug); ?>>
                                <?php echo esc_html($cat->name); ?> (<?php echo absint($cat->count); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="abcs-field">
                    <label for="abcs-post-type" class="abcs-label">पोस्ट प्रकार</label>
                    <select id="abcs-post-type" name="abcs_post_type" class="abcs-select">
                        <option value="">— सबै प्रकार —</option>
                        <?php foreach ($search_post_types as $pt_slug => $pt_label) : ?>
                            <option value="<?php echo esc_attr($pt_slug); ?>" <?php selected($cur_post_type, $pt_slug); ?>>
                                <?php echo esc_html($pt_label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="abcs-field">
                    <label for="abcs-date" class="abcs-label">निश्चित मिति</label>
                    <input
                        type="date"
                        id="abcs-date"
                        name="abcs_date"
                        class="abcs-input"
                        value="<?php echo esc_attr($cur_date); ?>"
                        max="<?php echo esc_attr(date('Y-m-d')); ?>"
                    >
                </div>

                <div class="abcs-field abcs-field--range">
                    <label class="abcs-label">मिति दायरा (अधिकतम ५ दिन)</label>
                    <div class="abcs-range-inputs">
                        <input type="date" id="abcs-from" name="abcs_from" class="abcs-input"
                               value="<?php echo esc_attr($cur_date_from); ?>"
                               max="<?php echo esc_attr(date('Y-m-d')); ?>" aria-label="मिति देखि">
                        <span class="abcs-range-sep" aria-hidden="true">—</span>
                        <input type="date" id="abcs-to" name="abcs_to" class="abcs-input"
                               value="<?php echo esc_attr($cur_date_to); ?>"
                               max="<?php echo esc_attr(date('Y-m-d')); ?>" aria-label="मिति सम्म">
                    </div>
                    <p class="abcs-range-error" id="abcs-range-error" role="alert" aria-live="assertive" hidden>
                        मिति दायरा ५ दिनभन्दा बढी हुन सक्दैन।
                    </p>
                </div>

                <div class="abcs-field abcs-field--clear">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="abcs-btn abcs-btn--clear" id="abcs-clear">
                        हटाउनुहोस्
                    </a>
                </div>

            </div>

        </form>

    </div>

    <?php
    // ── Results render in a FLOATING overlay panel, not inline page flow ──
    $has_params = ($cur_keyword || $cur_cat || $cur_date || $cur_date_from || $cur_date_to || $cur_post_type);
    if ($has_params) :
    ?>
    <div class="abcs-results-overlay" id="abcs-results-overlay">
        <div class="abcs-results-panel">
            <button type="button" class="abcs-results-close" id="abcs-results-close" aria-label="बन्द गर्नुहोस्">
                <svg viewBox="0 0 24 24" fill="none" width="18" height="18">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <?php abcs_render_results($cur_keyword, $cur_cat, $cur_date, $cur_date_from, $cur_date_to, $cur_post_type, $cur_page); ?>
        </div>
    </div>
    <?php endif; ?>

</section>
<?php