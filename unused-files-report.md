# Unused Files Report — ABC Nepal TV Theme

Generated: 2025-07-02

## Summary
- **Total files in theme folder**: 50
- **Safe to delete**: 22
- **Needs manual review**: 5
- **Actively used**: 23

---

## ✅ SAFE TO DELETE — No references found

These files have no PHP includes, no `get_template_part()`, no WP template hierarchy match, no page assigned in wp_posts, and no code references.

| File | Reason |
|------|--------|
| `english.php` | Duplicate of `page-english.php`; no template name, not assigned to any page |
| `international.php` | Duplicate of `page-international.php`; no template name |
| `opinion.php` | Duplicate of `page-opinion.php`; no template name |
| `sports.php` | Duplicate of `page-sports.php`; no template name |
| `economics.php` | Duplicate of `page-economics.php`; no template name |
| `Entertainment.php` | Duplicate of `page-entertainment.php`; no template name (case-insensitive FS) |
| `abc_video.php` | Duplicate of `page-abc-videos.php`; no template name |
| `updates.php` | No template name, no references, not in WP hierarchy |
| `page-rajniti.php` | Duplicate of `page-politics.php` (both use `abcnepal_render_news_section('politics')`); no unique purpose |
| `page-kutniti-page-php.php` | Duplicate of `page-diplomacy.php` (both use `abcnepal_render_news_section('kutniti')`); no unique purpose |
| `page-abcspecila.php` | Template name "ABC Special" but file is empty (0 bytes); no page uses it |
| `search-bar.php` (root) | Duplicate of `template-parts/search-bar.php`; the latter is loaded via `get_template_part('template-parts/search-bar')` in advanced-search.php |
| `footer.css` | Empty file (0 bytes); footer.php embeds its own CSS inline |
| `data.xml` | Not a PHP template; appears to be WP export/import data |
| `abc-video sub cataorgy` | Invalid filename (spaces); appears to be a directory artifact, not a template |
| `old.txt` | Text notes file, not executable code |
| `function.php` | **DANGEROUS** — duplicate of `functions.php` with lowercase 'f'; causes fatal error if loaded (per README) |
| `page-live-update-old.php` | Old version per README; not referenced anywhere |
| `js/live-updates.js` | Not enqueued anywhere; no references in PHP/JS |
| `js/ticker-marquee.js` | Not enqueued; `abc_enqueue_header_assets` only loads `header-nav.js`; header.php has inline ticker JS |
| `css/date-bar.css` | Not enqueued; header.php comment suggests it should be but `abc_enqueue_header_assets` doesn't load it |
| `page-main_news.php` | Referenced in README as deletable; file does not exist in current theme |

---

## ⚠️ REVIEW NEEDED — Referenced but uncertain

These files are referenced in code or have template names, but usage is ambiguous, broken, or potentially deprecated.

| File | References Found | Concern |
|------|------------------|---------|
| `page-sahitaya.php` | Template Name: "sahitiya"; calls `abcnepal_render_news_section` internally (not via functions.php) | Hardcodes 'artha' category but breaking text says "अर्थ अपडेट"; template name mismatch ("sahitiya" vs "sahitaya"); appears misconfigured per README |
| `page-province.php` | Template Name: "Province"; uses `abcnepal_render_news_section` internally | Contains hardcoded iframe (embed.st); uses 'province' category but `abcnepal_section_config` has 'pradesh' config; offset=9 in grid query skips posts oddly; README says "misconfigured" |
| `single-live-blog.php` | Calls `abcnepal_render_news_section('Live-blog')` | 'Live-blog' not in `abcnepal_section_config` (falls back to 'mainnews'); broken syntax per README; likely deprecated in favor of `page-live-update.php` + CPT |
| `abc.png` | Referenced in `footer.php` fallback logo | Only used if no custom logo set in Customizer; keep as fallback |
| `template-parts/search-bar.php` | Loaded via `get_template_part('template-parts/search-bar')` in `inc/advanced-search.php` (hooked to `abcs_after_header`) | Hook `abcs_after_header` fires in `header.php` line 226; search bar appears on ALL pages automatically — confirm this is intended |

---

## ✅ ACTIVELY USED — Keep

| File | Usage |
|------|-------|
| `functions.php` | Core theme functions, hooks, CPTs, REST routes |
| `index.php` | Homepage template (NYT-style layout with inline CSS) |
| `style.css` | Main stylesheet (enqueued via `abcnepal_styles`) |
| `header.php` | Site header, nav, date bar, ticker, social icons |
| `footer.php` | Fat footer with ticker, social, contact, team |
| `single.php` | Single post template with sidebar |
| `breaking-banner.php` | Included in `index.php` and `page-mainnews.php` |
| `header-nav.css` | Enqueued by `abc_enqueue_header_assets` |
| `header-nav.js` | Enqueued by `abc_enqueue_header_assets` |
| `page-mainnews.php` | Template "Main News" — uses pinned hero + grid |
| `page-live-update.php` | Template "Live Update Page" — live_update CPT feed |
| `page-politics.php` | Template — `abcnepal_render_news_section('politics')` |
| `page-opinion.php` | Template — `abcnepal_render_news_section('opinion')` |
| `page-entertainment.php` | Template — `abcnepal_render_news_section('entertainment')` |
| `page-international.php` | Template — `abcnepal_render_news_section('international')` |
| `page-diplomacy.php` | Template — `abcnepal_render_news_section('kutniti')` |
| `page-economics.php` | Template — `abcnepal_render_news_section('economics')` |
| `page-english.php` | Template — `abcnepal_render_news_section('english')` |
| `page-sports.php` | Template — `abcnepal_render_news_section('sports')` |
| `page-abc-videos.php` | Template — `abcnepal_render_news_section('abc_video')` |
| `page-artha-pahe-php.php` | Template — `abcnepal_render_news_section('artha')` |
| `page-arthabadijaya.php` | Template — conditional `is_page('economics') ? 'economics' : 'artha'` |
| `inc/news-toggles.php` | Required in `functions.php` line 3 — post meta boxes |
| `inc/advanced-search.php` | Required in `functions.php` line 5 — search bar + REST |
| `inc/ticker-cpt.php` | Required in `functions.php` line 7 — ticker CPT |
| `js/advanced-search.js` | Enqueued by `abcs_enqueue_assets` |
| `js/live-update.js` | Enqueued by `abcnepal_styles` for live update pages |
| `css/advanced-search.css` | Enqueued by `abcs_enqueue_assets` |

---

## Notes

1. **README.md explicitly lists deletable files** (lines 190–212) — most match this audit.
2. **Template duplicates**: The `page-*.php` files are the canonical templates (assigned via WP admin). The root-level `*.php` files (english.php, sports.php, etc.) are leftovers from before template naming convention.
3. **`page-abcspecila.php`** is 0 bytes — safe to delete.
4. **`single-live-blog.php`** calls a non-existent section config (`Live-blog`) — falls back to mainnews config. Likely replaced by `page-live-update.php` + `live_update` CPT.
5. **Search bar** appears on every page via `abcs_after_header` hook — if this is not desired, remove the `add_action('abcs_after_header', 'abcs_inject_after_header')` in `inc/advanced-search.php`.
6. **`css/date-bar.css` and `js/ticker-marquee.js`** are referenced in header.php comments but not enqueued — either enqueue them or remove the comments.