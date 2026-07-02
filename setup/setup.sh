#!/bin/sh
# ============================================================
#  ABC Nepal TV — WordPress Auto-Setup Script
#  Runs via WP-CLI inside the wp_setup container.
#  Idempotent: safe to run multiple times.
# ============================================================

set -e

WP="wp --path=/var/www/html --allow-root"
SITE_URL="http://localhost:8080"
ADMIN_USER="admin"
ADMIN_PASS="admin123"
ADMIN_EMAIL="admin@abcnepal.local"
SITE_TITLE="ABC Nepal TV"
THEME="abctvnepal"

echo ""
echo "=========================================="
echo "  ABC Nepal TV — WordPress Auto-Setup"
echo "=========================================="

# ── Wait for WordPress to be ready ─────────────────────────
echo "[1/9] Waiting for WordPress & DB to be ready..."
MAX_TRIES=30
TRIES=0
until $WP core is-installed 2>/dev/null || [ $TRIES -eq $MAX_TRIES ]; do
  sleep 5
  TRIES=$((TRIES+1))
  echo "  ... waiting ($TRIES/$MAX_TRIES)"
done

# ── Install WordPress core if not installed ─────────────────
if ! $WP core is-installed 2>/dev/null; then
  echo "[1/9] Installing WordPress core..."
  $WP core install \
    --url="$SITE_URL" \
    --title="$SITE_TITLE" \
    --admin_user="$ADMIN_USER" \
    --admin_password="$ADMIN_PASS" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email
  echo "  ✓ WordPress installed"
else
  echo "  ✓ WordPress already installed — skipping core install"
fi

# ── Activate Theme ──────────────────────────────────────────
echo "[2/9] Activating theme: $THEME..."
$WP theme activate "$THEME" 2>/dev/null || echo "  ⚠ Theme '$THEME' not found — make sure ./theme/ folder is mounted"

# ── General Settings ────────────────────────────────────────
echo "[3/9] Configuring WordPress settings..."
$WP option update blogname "ABC Nepal TV"
$WP option update blogdescription "सत्य, सन्तुलित र विश्वसनीय समाचार"
$WP option update permalink_structure "/%postname%/"
$WP option update timezone_string "Asia/Kathmandu"
$WP option update date_format "Y-m-d"
$WP option update time_format "H:i"
$WP option update posts_per_page 10
$WP option update default_comment_status "closed"
$WP option update default_ping_status "closed"
$WP rewrite flush
echo "  ✓ Settings saved"

# ── Install & Activate Required Plugins ─────────────────────
echo "[4/9] Installing plugins..."

# Nepali Date Converter (for [ndc-today-date] shortcode in header)
$WP plugin install nepali-date-converter --activate 2>/dev/null || echo "  ⚠ nepali-date-converter not found in repo — install manually"

# Classic Editor (easier for non-Gutenberg workflow)
$WP plugin install classic-editor --activate 2>/dev/null && echo "  ✓ Classic Editor installed" || true

echo "  ✓ Plugin setup complete"

# ── Create Categories ────────────────────────────────────────
echo "[5/9] Creating categories..."

create_cat() {
  NAME="$1"
  SLUG="$2"
  PARENT="$3"

  EXISTS=$($WP term get category --by=slug "$SLUG" --field=term_id 2>/dev/null || echo "")
  if [ -z "$EXISTS" ]; then
    if [ -n "$PARENT" ]; then
      PARENT_ID=$($WP term get category --by=slug "$PARENT" --field=term_id 2>/dev/null || echo "0")
      $WP term create category "$NAME" --slug="$SLUG" --parent="$PARENT_ID" --porcelain > /dev/null
    else
      $WP term create category "$NAME" --slug="$SLUG" --porcelain > /dev/null
    fi
    echo "  ✓ Created: $NAME ($SLUG)"
  else
    echo "  · Exists:  $NAME ($SLUG)"
  fi
}

# Root categories
create_cat "मुख्य समाचार"      "news"               ""
create_cat "राजनीति"           "politics"           ""
create_cat "अर्थ वाणिज्य"     "artha"              ""
create_cat "विचार"             "opinion"            ""
create_cat "अन्तर्राष्ट्रिय"  "international"      ""
create_cat "खेलकुद"            "sports"             ""
create_cat "मनोरञ्जन"          "entertainment"      ""
create_cat "कूटनीति"           "kutniti"            ""
create_cat "अर्थतन्त्र"        "economics"          ""
create_cat "English"           "english"            ""
create_cat "एबीसी भिडियो"     "abc-video"          ""
create_cat "ब्रेकिङ"           "breaking"           ""
create_cat "अन्तर्राष्ट्रिय समाचार" "international_news" ""
create_cat "अंग्रेजी विशेष"   "english-special"    ""
create_cat "व्यापार"           "business"           ""
create_cat "साहित्य"           "literature"         ""
create_cat "Live Blog"         "live-blog"          ""

# Province (parent + 7 sub-provinces)
create_cat "प्रदेश"            "province"           ""
create_cat "कोशी"              "provincial_koshi"   "province"
create_cat "मधेश"              "provincial_madesh"  "province"
create_cat "बागमती"            "provincial_bagmati" "province"
create_cat "गण्डकी"            "provincial_gandaki" "province"
create_cat "लुम्बिनी"          "provincial_lumbini" "province"
create_cat "कर्णाली"           "provincial_karnali" "province"
create_cat "सुदूरपश्चिम"       "provincial_sudurpashchim" "province"

echo "  ✓ All categories created"

# ── Remove Default "Uncategorized" content ──────────────────
$WP term update category 1 --name="सामान्य" --slug="general" 2>/dev/null || true

# ── Create Pages & Assign Templates ─────────────────────────
echo "[6/9] Creating pages..."

create_page() {
  TITLE="$1"
  SLUG="$2"
  TEMPLATE="$3"

  EXISTS=$($WP post list --post_type=page --name="$SLUG" --field=ID --format=ids 2>/dev/null | head -1)
  if [ -z "$EXISTS" ]; then
    PAGE_ID=$($WP post create \
      --post_type=page \
      --post_status=publish \
      --post_title="$TITLE" \
      --post_name="$SLUG" \
      --porcelain)
    if [ -n "$TEMPLATE" ]; then
      $WP post meta set "$PAGE_ID" _wp_page_template "$TEMPLATE"
    fi
    echo "  ✓ Created page: $TITLE (ID: $PAGE_ID, template: ${TEMPLATE:-default})"
  else
    echo "  · Exists:  $TITLE ($SLUG)"
    # Update template if page exists but template not set
    if [ -n "$TEMPLATE" ]; then
      $WP post meta update "$EXISTS" _wp_page_template "$TEMPLATE" 2>/dev/null || true
    fi
  fi
}

create_page "मुख्य समाचार"       "mainnews"      "page-mainnews.php"
create_page "राजनीति"            "politics"      "page-politics.php"
create_page "अर्थ वाणिज्य"      "artha"         "page-artha-pahe-php.php"
create_page "विचार"              "opinion"       "page-opinion.php"
create_page "अन्तर्राष्ट्रिय"   "international" "page-international.php"
create_page "खेलकुद"             "sports"        "page-sports.php"
create_page "मनोरञ्जन"           "entertainment" "page-entertainment.php"
create_page "कूटनीति"            "diplomacy"     "page-diplomacy.php"
create_page "अर्थतन्त्र"         "economics"     "page-economics.php"
create_page "English"            "english"       "page-english.php"
create_page "एबीसी भिडियो"      "abc-videos"    "page-abc_videos.php"
create_page "लाइभ अपडेट"        "liveupdate"    "page-live-update.php"
create_page "अर्थ बाणिज्य जय"   "arthabadijaya" "page-arthabadijaya.php"
create_page "Privacy Policy"     "privacy-policy" ""
create_page "Terms of Service"   "terms-of-service" ""
create_page "Contact"            "contact"        ""

echo "  ✓ All pages created"

# ── Set Static Homepage ──────────────────────────────────────
echo "[7/9] Setting homepage to 'मुख्य समाचार' (index.php style — latest posts)..."
# Keep as "latest posts" so index.php auto-serves the homepage ribbon layout
$WP option update show_on_front "posts"
echo "  ✓ Homepage set to latest posts (index.php)"

# ── Create Navigation Menu ───────────────────────────────────
echo "[8/9] Creating navigation menu..."

MENU_NAME="Main Navigation"
MENU_EXISTS=$($WP menu list --field=name 2>/dev/null | grep -c "^${MENU_NAME}$" || echo "0")

if [ "$MENU_EXISTS" = "0" ]; then
  MENU_ID=$($WP menu create "$MENU_NAME" --porcelain)
  echo "  ✓ Menu created (ID: $MENU_ID)"
else
  MENU_ID=$($WP menu list --field=term_id --name="$MENU_NAME" 2>/dev/null | head -1)
  echo "  · Menu exists (ID: $MENU_ID)"
fi

# Helper: add page to menu if not already there
add_menu_page() {
  LABEL="$1"
  PAGE_SLUG="$2"
  CSS_CLASS="$3"

  PAGE_ID=$($WP post list --post_type=page --name="$PAGE_SLUG" --field=ID --format=ids 2>/dev/null | head -1)
  if [ -n "$PAGE_ID" ]; then
    ITEM_ID=$($WP menu item add-post "$MENU_ID" "$PAGE_ID" --title="$LABEL" --porcelain 2>/dev/null)
    if [ -n "$CSS_CLASS" ] && [ -n "$ITEM_ID" ]; then
      $WP post meta set "$ITEM_ID" _menu_item_classes "a:1:{i:0;s:${#CSS_CLASS}:\"$CSS_CLASS\";}" 2>/dev/null || true
    fi
    echo "  ✓ Menu: $LABEL"
  fi
}

add_menu_page "होमपेज"            "mainnews"      ""
add_menu_page "मुख्य समाचार"      "mainnews"      ""
add_menu_page "राजनीति"           "politics"      ""
add_menu_page "अर्थ वाणिज्य"     "artha"         ""
add_menu_page "विचार"             "opinion"       ""
add_menu_page "अन्तर्राष्ट्रिय"  "international" ""
add_menu_page "खेलकुद"            "sports"        ""
add_menu_page "लाइभ अपडेट"       "liveupdate"    ""
add_menu_page "ENGLISH"           "english"       "menu-highlight"

# Assign menu to theme location
$WP menu location assign "$MENU_ID" main-menu 2>/dev/null && echo "  ✓ Menu assigned to 'main-menu' location" || echo "  ⚠ Could not assign menu location (theme may not be active yet)"

# ── Create Sample Posts ──────────────────────────────────────
echo "[9/9] Creating sample posts..."

create_sample_post() {
  TITLE="$1"
  CATEGORY="$2"
  CONTENT="$3"

  COUNT=$($WP post list --post_type=post --category_name="$CATEGORY" --format=count 2>/dev/null || echo "0")
  if [ "$COUNT" = "0" ]; then
    $WP post create \
      --post_type=post \
      --post_status=publish \
      --post_title="$TITLE" \
      --post_content="$CONTENT" \
      --post_category="$($WP term get category --by=slug "$CATEGORY" --field=term_id 2>/dev/null || echo "")" \
      --porcelain > /dev/null 2>&1 && echo "  ✓ Sample post: $TITLE" || true
  fi
}

create_sample_post \
  "नेपालमा नयाँ सरकारको गठन सम्पन्न" \
  "news" \
  "नयाँ सरकारको गठनपछि देशमा राजनीतिक स्थिरताको अपेक्षा बढेको छ। प्रधानमन्त्रीले आफ्नो पहिलो सार्वजनिक सम्बोधनमा आर्थिक विकास र सुशासनलाई प्राथमिकता दिने बताए।"

create_sample_post \
  "राजनीतिक दलहरूबीच नयाँ सहमतिको प्रयास" \
  "politics" \
  "प्रमुख राजनीतिक दलहरूका नेताहरू आगामी निर्वाचनको तयारीमा आन्तरिक छलफलमा व्यस्त छन्। गठबन्धनको सम्भावनाबारे विभिन्न स्तरमा कुराकानी भइरहेको बताइएको छ।"

create_sample_post \
  "सेयर बजारमा सुधारको संकेत, लगानीकर्ता उत्साहित" \
  "artha" \
  "नेपाल स्टक एक्सचेञ्जमा आजको कारोबारमा सकारात्मक सुधार देखिएको छ। विश्लेषकहरूले यो प्रवृत्ति केही समय जारी रहने अपेक्षा गरेका छन्।"

create_sample_post \
  "नेपाली क्रिकेट टोलीले एसिया कपका लागि तयारी थाल्यो" \
  "sports" \
  "राष्ट्रिय क्रिकेट टोलीको बन्द शिविर सुरु भएको छ। प्रशिक्षकले युवा खेलाडीहरूको प्रदर्शनबाट सन्तुष्ट रहेको बताए।"

create_sample_post \
  "नयाँ नेपाली चलचित्र अन्तर्राष्ट्रिय महोत्सवमा छनोट" \
  "entertainment" \
  "एक युवा निर्देशकको पहिलो फिल्म अन्तर्राष्ट्रिय चलचित्र महोत्सवमा प्रतिस्पर्धाका लागि छनोट भएको छ। यो नेपाली सिनेमाका लागि गर्वको विषय मानिएको छ।"

create_sample_post \
  "Nepal and India Strengthen Bilateral Trade Relations" \
  "english" \
  "Nepal and India have agreed to enhance bilateral trade and economic cooperation through a new framework signed during the recent high-level meeting in Kathmandu."

create_sample_post \
  "दक्षिण एसियामा नयाँ आर्थिक सहकार्यको प्रस्ताव" \
  "international" \
  "सार्क सदस्य राष्ट्रहरूबीच क्षेत्रीय व्यापार र आर्थिक एकीकरणलाई गति दिन नयाँ प्रस्ताव पेश गरिएको छ।"

create_sample_post \
  "नेपालको कूटनीतिक प्रयासले नयाँ आयाम पाउँदै" \
  "kutniti" \
  "विदेश मन्त्रालयले छिमेकी मुलुकहरूसँग सम्बन्ध सुदृढ गर्न नयाँ कूटनीतिक पहल अघि बढाएको छ।"

create_sample_post \
  "अर्थतन्त्र सुदृढ गर्न उत्पादनमुखी नीति आवश्यक" \
  "opinion" \
  "नेपालको अर्थतन्त्रलाई दीर्घकालीन रूपमा बलियो बनाउन आयात प्रतिस्थापन र निर्यात प्रवर्द्धनमा ध्यान दिनुपर्ने विज्ञहरूको सुझाव छ।"

# ── Create sample Live Update post ───────────────────────────
LIVE_COUNT=$($WP post list --post_type=live_update --format=count 2>/dev/null || echo "0")
if [ "$LIVE_COUNT" = "0" ]; then
  $WP post create \
    --post_type=live_update \
    --post_status=publish \
    --post_title="लाइभ: संसद बैठक सुरु भयो" \
    --post_content="<p>आज दिउँसो २ बजेदेखि संसद बैठक सुरु भएको छ। एजेन्डामा बजेट कार्यान्वयन र जनजीविकाका विषयहरू छन्।</p>" \
    --porcelain > /dev/null 2>&1 && echo "  ✓ Sample live update post created" || true
fi

# ── Create stub inc/news-toggles.php if missing ─────────────
TOGGLES_FILE="/var/www/html/wp-content/themes/$THEME/inc/news-toggles.php"
if [ ! -f "$TOGGLES_FILE" ]; then
  mkdir -p "/var/www/html/wp-content/themes/$THEME/inc"
  cat > "$TOGGLES_FILE" << 'PHPEOF'
<?php
/**
 * ABC Nepal TV — News Toggle Stubs
 * Auto-generated by setup.sh
 * Replace with full news-toggles.php for Hero/Featured/Breaking admin meta boxes.
 */

function abcnt_get_breaking_posts( $limit = 5 ) {
    return get_posts( array(
        'posts_per_page' => $limit,
        'category_name'  => 'breaking',
        'post_status'    => 'publish',
    ) );
}

function abcnt_get_breaking_post() {
    $posts = abcnt_get_breaking_posts( 1 );
    return ! empty( $posts ) ? $posts[0] : null;
}

function abcnt_get_hero_post() {
    $pinned = get_posts( array(
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_key'       => '_abcnt_homepage_hero',
        'meta_value'     => '1',
    ) );
    if ( ! empty( $pinned ) ) return $pinned[0];
    // Fallback: latest post
    $latest = get_posts( array( 'posts_per_page' => 1, 'category_name' => 'news' ) );
    return ! empty( $latest ) ? $latest[0] : null;
}

function abcnt_get_featured_posts( $limit = 5, $exclude = array() ) {
    return get_posts( array(
        'posts_per_page' => $limit,
        'post__not_in'   => $exclude,
        'post_status'    => 'publish',
        'meta_key'       => '_abcnt_featured',
        'meta_value'     => '1',
    ) );
}

function abcnt_count_flagged( $meta_key ) {
    global $wpdb;
    return (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = '1'",
            $meta_key
        )
    );
}

/**
 * Admin meta box: set any post as Hero / Featured / Breaking
 */
function abcnt_register_toggle_meta_boxes() {
    $post_types = array( 'post', 'live_update' );
    foreach ( $post_types as $pt ) {
        add_meta_box(
            'abcnt_toggles',
            '📌 ABC Nepal — Post Flags',
            'abcnt_render_toggle_meta_box',
            $pt,
            'side',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'abcnt_register_toggle_meta_boxes' );

function abcnt_render_toggle_meta_box( $post ) {
    wp_nonce_field( 'abcnt_save_toggles', 'abcnt_toggles_nonce' );
    $hero     = get_post_meta( $post->ID, '_abcnt_homepage_hero', true );
    $featured = get_post_meta( $post->ID, '_abcnt_featured', true );
    $breaking = get_post_meta( $post->ID, '_abcnt_breaking', true );
    ?>
    <p>
      <label>
        <input type="checkbox" name="abcnt_homepage_hero" value="1" <?php checked( $hero, '1' ); ?>>
        🏠 <strong>Homepage Hero</strong>
      </label>
    </p>
    <p>
      <label>
        <input type="checkbox" name="abcnt_featured" value="1" <?php checked( $featured, '1' ); ?>>
        ⭐ <strong>Featured (Sub-hero)</strong>
      </label>
    </p>
    <p>
      <label>
        <input type="checkbox" name="abcnt_breaking" value="1" <?php checked( $breaking, '1' ); ?>>
        🔴 <strong>Breaking News</strong>
      </label>
    </p>
    <p style="font-size:11px;color:#999;margin-top:8px;">
      Breaking: max 5 active at once.<br>
      Hero: only 1 effective (latest wins).
    </p>
    <?php
}

function abcnt_save_toggle_meta( $post_id ) {
    if ( ! isset( $_POST['abcnt_toggles_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['abcnt_toggles_nonce'], 'abcnt_save_toggles' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array(
        'abcnt_homepage_hero' => '_abcnt_homepage_hero',
        'abcnt_featured'      => '_abcnt_featured',
        'abcnt_breaking'      => '_abcnt_breaking',
    );

    foreach ( $fields as $input => $meta_key ) {
        if ( isset( $_POST[ $input ] ) && $_POST[ $input ] === '1' ) {
            update_post_meta( $post_id, $meta_key, '1' );
        } else {
            delete_post_meta( $post_id, $meta_key );
        }
    }
}
add_action( 'save_post', 'abcnt_save_toggle_meta' );
PHPEOF
  echo "  ✓ inc/news-toggles.php stub created"
else
  echo "  · inc/news-toggles.php already exists"
fi

# ── abc.png placeholder if missing ──────────────────────────
ABC_PNG="/var/www/html/wp-content/themes/$THEME/abc.png"
if [ ! -f "$ABC_PNG" ]; then
  # Download a placeholder or create a tiny valid PNG
  printf '\x89PNG\r\n\x1a\n\x00\x00\x00\rIHDR\x00\x00\x00\x01\x00\x00\x00\x01\x08\x02\x00\x00\x00\x90wS\xde\x00\x00\x00\x0cIDATx\x9cc\xf8\x0f\x00\x00\x01\x01\x00\x05\x18\xd8N\x00\x00\x00\x00IEND\xaeB`\x82' > "$ABC_PNG" 2>/dev/null || true
  echo "  · abc.png placeholder created (replace with real logo)"
fi

# ── Final flush ──────────────────────────────────────────────
$WP rewrite flush --hard 2>/dev/null || true
$WP cache flush 2>/dev/null || true

echo ""
echo "=========================================="
echo "  ✅ ABC Nepal TV Setup Complete!"
echo "=========================================="
echo ""
echo "  🌐 Site:     http://localhost:8080"
echo "  🔧 WP Admin: http://localhost:8080/wp-admin"
echo "  👤 User:     $ADMIN_USER"
echo "  🔑 Pass:     $ADMIN_PASS"
echo "  🗄  DB GUI:   http://localhost:8081"
echo ""
echo "  Next steps:"
echo "  1. Upload your real abc.png logo to theme root"
echo "  2. Install Nepali Date Converter plugin if [ndc-today-date] not working"
echo "  3. In WP Admin → Posts → add posts to 'breaking' category for banner"
echo "  4. Edit any post and use '📌 ABC Nepal — Post Flags' meta box"
echo "     to set Hero / Featured / Breaking toggles"
echo ""
