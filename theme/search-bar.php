<?php
/**
 * ABC Nepal TV — Advanced News Search Bar
 * Template Part: template-parts/search-bar.php
 *
 * Usage: get_template_part('template-parts/search-bar');
 * Drop after get_header() in any template, or hook via functions.php.
 */

// Gather available categories (exclude empty ones)
$search_categories = get_categories(array(
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => true,
));

// Available public post types relevant for news
$search_post_types = array(
    'post'        => 'News / Articles',
    'live_update' => 'Live Updates',
);

// Read current filter values so they persist after search
$cur_keyword   = isset($_GET['abcs_q'])        ? sanitize_text_field($_GET['abcs_q'])        : '';
$cur_cat       = isset($_GET['abcs_cat'])       ? sanitize_text_field($_GET['abcs_cat'])       : '';
$cur_date      = isset($_GET['abcs_date'])      ? sanitize_text_field($_GET['abcs_date'])      : '';
$cur_date_from = isset($_GET['abcs_from'])      ? sanitize_text_field($_GET['abcs_from'])      : '';
$cur_date_to   = isset($_GET['abcs_to'])        ? sanitize_text_field($_GET['abcs_to'])        : '';
$cur_post_type = isset($_GET['abcs_post_type']) ? sanitize_text_field($_GET['abcs_post_type']) : '';
$cur_page      = isset($_GET['abcs_paged'])     ? max(1, absint($_GET['abcs_paged']))           : 1;

// Nonce for AJAX-free form safety
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

            <!-- ── Row 1: Keyword ── -->
            <div class="abcs-keyword-row">
                <div class="abcs-field abcs-field--keyword">
                    <label for="abcs-q" class="abcs-label">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        कीवर्ड खोज्नुहोस्
                    </label>
                    <input
                        type="search"
                        id="abcs-q"
                        name="abcs_q"
                        class="abcs-input"
                        placeholder="शीर्षक वा सामग्री खोज्नुहोस्…"
                        value="<?php echo esc_attr($cur_keyword); ?>"
                        autocomplete="off"
                    >
                </div>

                <button type="submit" class="abcs-btn abcs-btn--search" id="abcs-submit">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    खोज्नुहोस्
                </button>
            </div>

            <!-- ── Row 2: Filters (collapsible on mobile) ── -->
            <button type="button" class="abcs-toggle-filters" id="abcs-toggle-filters" aria-expanded="false">
                <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                उन्नत फिल्टर
                <i class="fa-solid fa-chevron-down abcs-chevron" aria-hidden="true"></i>
            </button>

            <div class="abcs-filters" id="abcs-filters" <?php echo ($cur_cat || $cur_date || $cur_date_from || $cur_date_to || $cur_post_type) ? '' : 'hidden'; ?>>

                <!-- Category -->
                <div class="abcs-field">
                    <label for="abcs-cat" class="abcs-label">
                        <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                        वर्ग (Category)
                    </label>
                    <select id="abcs-cat" name="abcs_cat" class="abcs-select">
                        <option value="">— सबै वर्ग —</option>
                        <?php foreach ($search_categories as $cat) : ?>
                            <option
                                value="<?php echo esc_attr($cat->slug); ?>"
                                <?php selected($cur_cat, $cat->slug); ?>
                            >
                                <?php echo esc_html($cat->name); ?>
                                (<?php echo absint($cat->count); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Post Type -->
                <div class="abcs-field">
                    <label for="abcs-post-type" class="abcs-label">
                        <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                        पोस्ट प्रकार
                    </label>
                    <select id="abcs-post-type" name="abcs_post_type" class="abcs-select">
                        <option value="">— सबै प्रकार —</option>
                        <?php foreach ($search_post_types as $pt_slug => $pt_label) : ?>
                            <option
                                value="<?php echo esc_attr($pt_slug); ?>"
                                <?php selected($cur_post_type, $pt_slug); ?>
                            >
                                <?php echo esc_html($pt_label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Specific Date -->
                <div class="abcs-field">
                    <label for="abcs-date" class="abcs-label">
                        <i class="fa-solid fa-calendar-day" aria-hidden="true"></i>
                        निश्चित मिति
                    </label>
                    <input
                        type="date"
                        id="abcs-date"
                        name="abcs_date"
                        class="abcs-input"
                        value="<?php echo esc_attr($cur_date); ?>"
                        max="<?php echo esc_attr(date('Y-m-d')); ?>"
                    >
                </div>

                <!-- Date Range -->
                <div class="abcs-field abcs-field--range">
                    <label class="abcs-label">
                        <i class="fa-solid fa-calendar-range" aria-hidden="true"></i>
                        मिति दायरा <small>(अधिकतम ५ दिन)</small>
                    </label>
                    <div class="abcs-range-inputs">
                        <input
                            type="date"
                            id="abcs-from"
                            name="abcs_from"
                            class="abcs-input"
                            placeholder="देखि"
                            value="<?php echo esc_attr($cur_date_from); ?>"
                            max="<?php echo esc_attr(date('Y-m-d')); ?>"
                            aria-label="मिति देखि"
                        >
                        <span class="abcs-range-sep" aria-hidden="true">—</span>
                        <input
                            type="date"
                            id="abcs-to"
                            name="abcs_to"
                            class="abcs-input"
                            placeholder="सम्म"
                            value="<?php echo esc_attr($cur_date_to); ?>"
                            max="<?php echo esc_attr(date('Y-m-d')); ?>"
                            aria-label="मिति सम्म"
                        >
                    </div>
                    <p class="abcs-range-error" id="abcs-range-error" role="alert" aria-live="assertive" hidden>
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                        मिति दायरा ५ दिनभन्दा बढी हुन सक्दैन। कृपया मिति पुनः चयन गर्नुहोस्।
                    </p>
                </div>

                <!-- Clear Filters -->
                <div class="abcs-field abcs-field--clear">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="abcs-btn abcs-btn--clear" id="abcs-clear">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        फिल्टर हटाउनुहोस्
                    </a>
                </div>

            </div><!-- /abcs-filters -->

        </form>

        <!-- ── Search Results ── -->
        <?php abcs_render_results($cur_keyword, $cur_cat, $cur_date, $cur_date_from, $cur_date_to, $cur_post_type, $cur_page); ?>

    </div><!-- /abcs-inner -->
</section>
<?php
