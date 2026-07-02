# Website Details — ABC Nepal TV Theme

Generated: 2025-07-02

---

## Page Slugs (from page-*.php template filenames)

| Slug | Type | Template File | Notes |
|------|------|---------------|-------|
| mainnews | Page | page-mainnews.php | Template: "Main News (NYT-Style Layout)"; uses pinned hero + grid |
| liveupdate / live-update | Page | page-live-update.php | Template: "Live Update Page"; custom rewrite via `abcnepal_is_live_update_path()` |
| politics | Page | page-politics.php | Template — calls `abcnepal_render_news_section('politics')` |
| diplomacy / kutniti | Page | page-diplomacy.php | Template — calls `abcnepal_render_news_section('kutniti')` |
| economics | Page | page-economics.php | Template — calls `abcnepal_render_news_section('economics')` |
| entertainment | Page | page-entertainment.php | Template — calls `abcnepal_render_news_section('entertainment')` |
| international | Page | page-international.php | Template — calls `abcnepal_render_news_section('international')` |
| opinion | Page | page-opinion.php | Template — calls `abcnepal_render_news_section('opinion')` |
| english | Page | page-english.php | Template — calls `abcnepal_render_news_section('english')` |
| sports | Page | page-sports.php | Template — calls `abcnepal_render_news_section('sports')` |
| abc-videos | Page | page-abc-videos.php | Template — calls `abcnepal_render_news_section('abc_video')` |
| artha | Page | page-artha-pahe-php.php | Template — calls `abcnepal_render_news_section('artha')` |
| artha-badijaya | Page | page-arthabadijaya.php | Template — conditional: `is_page('economics') ? 'economics' : 'artha'` |
| province | Page | page-province.php | Template: "Province" — **misconfigured** (uses 'province' cat, config has 'pradesh') |
| rajniti | Page | page-rajniti.php | Duplicate of politics — calls `abcnepal_render_news_section('politics')` |
| kutniti-page-php | Page | page-kutniti-page-php.php | Duplicate of diplomacy — calls `abcnepal_render_news_section('kutniti')` |
| abcspecila | Page | page-abcspecila.php | Template: "ABC Special" — **empty file (0 bytes)** |
| sahitaya | Page | page-sahitaya.php | Template: "sahitiya" — **misconfigured** (hardcodes 'artha' category) |

---

## Category / Sub-Category Slugs (from `abcnepal_section_config()` and WP_Query args)

| Section Key | Category Slug | Breaking Label | Section Title | Sidebar Title | Used By |
|-------------|---------------|----------------|---------------|---------------|---------|
| mainnews | *(empty — all posts)* | मुख्य समाचार : राष्ट्रिय राजनीति, अर्थतन्त्र, समाज र खेलकुदका प्रमुख समाचार | मुख्य समाचार | ताजा मुख्य समाचार | page-mainnews.php, functions.php default |
| politics | politics | राजनीति अपडेट : दलहरूबीच संवाद, संसद र सरकारका पछिल्ला गतिविधि | राजनीति विशेष | ताजा राजनीतिक समाचार | page-politics.php, page-rajniti.php |
| kutniti | kutniti | कूटनीति अपडेट : छिमेक, सहायता र अन्तर्राष्ट्रिय सम्बन्धका खबर | कूटनीति विशेष | ताजा कूटनीति समाचार | page-diplomacy.php, page-kutniti-page-php.php |
| pradesh | pradesh | प्रदेश अपडेट : सातै प्रदेशका नीति, विकास र जनसरोकारका खबर | प्रदेश विशेष | ताजा प्रदेश समाचार | *(config exists but no page uses 'pradesh' key)* |
| artha | artha | अर्थ अपडेट : बजार, बैंकिङ, उद्योग र व्यापारका खबर | अर्थ विशेष | ताजा अर्थ समाचार | page-artha-pahe-php.php, page-arthabadijaya.php (fallback) |
| entertainment | entertainment | मनोरञ्जन अपडेट : चलचित्र, संगीत, कला र सेलिब्रेटी खबर | मनोरञ्जन विशेष | ताजा मनोरञ्जन समाचार | page-entertainment.php, Entertainment.php |
| abc_video | abc-video | एबीसी भिडियो अपडेट : अन्तर्वार्ता, रिपोर्ट र विशेष भिडियो | एबीसी भिडियो विशेष | ताजा भिडियो | page-abc-videos.php, abc_video.php |
| english | english | अंग्रेजी संस्करण अपडेट : नेपालका प्रमुख खबरको संक्षिप्त प्रस्तुति | अंग्रेजी संस्करण विशेष | ताजा अंग्रेजी संस्करण | page-english.php, english.php |
| international | international | अन्तर्राष्ट्रिय अपडेट : विश्व राजनीति, अर्थतन्त्र र दक्षिण एसियाका खबर | अन्तर्राष्ट्रिय विशेष | ताजा अन्तर्राष्ट्रिय समाचार | page-international.php, international.php |
| opinion | opinion | विचार अपडेट : विश्लेषण, टिप्पणी र सम्पादकीय दृष्टिकोण | विचार विशेष | ताजा विचार | page-opinion.php, opinion.php |
| literature | literature | साहित्य अपडेट : कथा, कविता, समीक्षा र सांस्कृतिक लेखन | साहित्य विशेष | ताजा साहित्य | *(config exists but no page uses 'literature' key)* |
| economics | economics | अर्थतन्त्र अपडेट : उत्पादन, रोजगारी, बजार र नीतिका मुख्य खबर | अर्थतन्त्र विशेष | ताजा अर्थतन्त्र समाचार | page-economics.php, economics.php, page-arthabadijaya.php (when is_page('economics')) |
| sports | sports | खेलकुद अपडेट : क्रिकेट, फुटबल र राष्ट्रिय खेलका खबर | खेलकुद विशेष | ताजा खेलकुद समाचार | page-sports.php, sports.php |

**Note**: The `page-arthabadijaya.php` conditionally uses `'economics'` if `is_page('economics')` else `'artha'`.

**Additional category slugs from WP setup (setup.sh)**:
- `breaking` — Breaking News category (used by legacy fallback in breaking-banner.php)
- `province`, `provincial_koshi`, `provincial_madhesh`, `provincial_bagmati`, `provincial_gandaki`, `provincial_lumbini`, `provincial_karnali`, `provincial_sudurpashchim` — Province sub-categories

---

## Custom Post Types

| CPT Slug | Labels | Public | Supports | Has Archive | Show in REST | Registered By |
|----------|--------|--------|----------|-------------|--------------|---------------|
| live_update | Live Updates / Live Update | true | title, editor, thumbnail, author, excerpt | false | true | `register_live_update_cpt()` in functions.php |
| abc_ticker | Ticker News / Ticker Item | false | title | false | false | `abc_register_ticker_cpt()` in inc/ticker-cpt.php |

---

## Custom REST API Routes (from `rest_api_init` in functions.php)

| Route | Method | Description | Permission |
|-------|--------|-------------|------------|
| `/wp-json/abcnt/v1/breaking` | GET | Returns single active breaking post (title, permalink, excerpt, thumbnail, date) | Public (`__return_true`) |
| `/wp-json/abcnt/v1/hero` | GET | Returns single active homepage hero post (title, permalink, excerpt, thumbnail, date) | Public |
| `/wp-json/abcnt/v1/featured` | GET | Returns array of featured posts (limit param, max 20) with title, permalink, thumbnail, date | Public |

**Namespace**: `abcnt/v1`

**Used by**: Frontend JavaScript (if any) consuming breaking/hero/featured data via REST.

---

## Custom Rewrite / Path Handling

| Path Pattern | Handler | Purpose |
|--------------|---------|---------|
| `/liveupdate` or `/live-update` | `abcnepal_is_live_update_path()` + `template_redirect` + `template_include` | Routes to `page-live-update.php` without needing a WP Page; fixes 404 status |

---

## AJAX Endpoints (admin-ajax.php)

| Action | Handler | Access | Purpose |
|--------|---------|--------|---------|
| `get_live_updates` | `abcnepal_get_live_updates` | Public + Private | Polls for new `live_update` posts since `last_id` |
| `abcnepal_lqp_publish` | `abcnepal_lqp_publish_handler` | Authenticated (publish_posts) | Quick-publish live update from admin bar |

---

## Admin Bar / Admin Hooks

| Hook | Function | Purpose |
|------|----------|---------|
| `admin_bar_menu` (priority 999) | `abcnt_breaking_admin_bar_node` | Shows breaking news count + per-post remove links in admin bar |
| `admin_init` | `abcnt_handle_clear_breaking` | Processes "Remove from Breaking" clicks from admin bar |
| `admin_notices` | `abcnepal_live_update_quick_publish` | Renders Quick Publish box on live_update edit.php screen |
| `manage_live_update_posts_columns` | `abcnepal_live_update_admin_columns` | Custom columns: Reporter, Posted, Time Ago |
| `manage_live_update_posts_custom_column` | `abcnepal_live_update_column_content` | Renders custom column content |
| `manage_edit-live_update_sortable_columns` | `abcnepal_live_update_sortable_columns` | Makes "Posted" sortable |
| `add_meta_boxes` | `abcnt_register_toggle_metabox` | Adds "News Toggles" meta box to post editor |
| `save_post_post` | `abcnt_save_toggles` | Saves Breaking/Featured/Hero flags with limits |
| `manage_posts_columns` | `abcnt_add_toggle_columns` | Adds Breaking/Featured/Hero columns to posts list |
| `manage_posts_custom_column` | `abcnt_toggle_column_content` | Renders toggle column icons |
| `manage_posts_sortable_columns` | `abcnt_sortable_toggle_columns` | Makes toggle columns sortable |

---

## Enqueued Assets

| Handle | Type | Source | Dependencies | Condition |
|--------|------|--------|--------------|-----------|
| abc-style | CSS | style.css | — | All pages |
| abc-live-update | JS | js/live-update.js | jquery | Live update pages only |
| abc-header-nav | CSS | header-nav.css | — | All pages |
| abc-header-nav | JS | header-nav.js | — | All pages (footer) |
| abcs-style | CSS | css/advanced-search.css | — | All pages |
| abcs-script | JS | js/advanced-search.js | — | All pages (footer) |

**Localized script data**: `abcLiveUpdate` object with `ajaxUrl` and `nonce` for `abc-live-update` script.

---

## Post Meta Keys (News Toggles)

| Meta Key | Type | Limit | Auto-clear Others | Used By |
|----------|------|-------|-------------------|---------|
| `_abcnt_breaking` | Checkbox | 5 max | No | Breaking banner, REST `/breaking`, admin bar |
| `_abcnt_featured` | Checkbox | Unlimited | No | REST `/featured`, mainnews sub-hero |
| `_abcnt_homepage_hero` | Checkbox | 1 | Yes (auto-clears others) | Mainnews hero, REST `/hero` |

---

## Navigation Menu Translation Map (from `abcnepal_translate_menu_title`)

| English Key | Nepali Label |
|-------------|--------------|
| mainnews / main news | मुख्य समाचार |
| rajneeti / rajniti | राजनीति |
| kutni / kutniti | कूटनीति |
| artha | अर्थ |
| entertainment | मनोरञ्जन |
| abc_videos / abc videos | एबीसी भिडियो |
| english | अंग्रेजी |
| international | अन्तर्राष्ट्रिय |
| opinion | विचार |
| economics | अर्थतन्त्र |
| sports | खेलकुद |
| liveupdate / live update / live updates | लाइभ अपडेट |

Applied via `nav_menu_item_title` filter — affects `wp_nav_menu()` output.