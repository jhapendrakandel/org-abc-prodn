# ABC Nepal TV — Local WordPress Environment

One-click Docker setup for the ABC Nepal TV WordPress theme.

---

## Folder Structure

```
abc-nepal-wp/
├── docker-compose.yml     ← Main compose file
├── setup/
│   └── setup.sh           ← Auto-config script (WP-CLI)
├── theme/                 ← PUT YOUR THEME FILES HERE
│   ├── functions.php
│   ├── index.php
│   ├── style.css
│   ├── header.php
│   ├── footer.php
│   ├── single.php
│   ├── breaking-banner.php
│   ├── header-nav.css
│   ├── header-nav.js
│   ├── page-mainnews.php
│   ├── page-live-update.php
│   ├── page-politics.php
│   ├── page-opinion.php
│   ├── page-sports.php
│   ├── page-entertainment.php
│   ├── page-international.php
│   ├── page-diplomacy.php
│   ├── page-economics.php
│   ├── page-english.php
│   ├── page-abc_videos.php
│   ├── page-artha-pahe-php.php
│   ├── page-arthabadijaya.php
│   ├── abc.png            ← Your logo file
│   └── inc/               ← Auto-created by setup.sh
│       └── news-toggles.php
└── README.md
```

---

## Quick Start

### Step 1 — Copy your theme files

```bash
# From your existing theme folder, copy everything into ./theme/
cp -r /path/to/your/theme/files/* ./theme/
```

### Step 2 — Start everything

```bash
docker compose up -d
```

First run takes about **60–90 seconds**. The `wp_setup` container runs automatically and:
- Installs WordPress
- Creates all categories
- Creates all pages with correct templates assigned
- Sets up the navigation menu
- Creates sample posts in each category
- Creates the `inc/news-toggles.php` stub

### Step 3 — Open the site

| URL | What |
|---|---|
| http://localhost:8080 | Your site |
| http://localhost:8080/wp-admin | WordPress Admin |
| http://localhost:8081 | phpMyAdmin (DB GUI) |

**Admin credentials:**
- Username: `admin`
- Password: `admin123`

---

## After First Boot

### Check setup ran OK

```bash
docker logs abc_nepal_setup
```

You should see `✅ ABC Nepal TV Setup Complete!` at the bottom.

### Re-run setup if needed

```bash
docker compose run --rm wp_setup
```

### Stop everything

```bash
docker compose down
```

### Stop and wipe all data (full reset)

```bash
docker compose down -v
```

---

## Admin: What Was Auto-Configured

### Categories Created

| Nepali Name | Slug |
|---|---|
| मुख्य समाचार | `news` |
| राजनीति | `politics` |
| अर्थ | `artha` |
| विचार | `opinion` |
| अन्तर्राष्ट्रिय | `international` |
| खेलकुद | `sports` |
| मनोरञ्जन | `entertainment` |
| कूटनीति | `kutniti` |
| अर्थतन्त्र | `economics` |
| English | `english` |
| एबीसी भिडियो | `abc-video` |
| ब्रेकिङ | `breaking` |
| प्रदेश + 7 sub-provinces | `province`, `provincial_koshi`, etc. |

### Pages Created (with templates)

| Page | Template File |
|---|---|
| मुख्य समाचार | `page-mainnews.php` |
| लाइभ अपडेट | `page-live-update.php` |
| राजनीति | `page-politics.php` |
| ... and all others | (see setup.sh) |

### Post Flags (Meta Boxes)

In WP Admin, edit any post → sidebar box **"📌 ABC Nepal — Post Flags"**:

- 🏠 **Homepage Hero** — pins post as the large hero on main news page
- ⭐ **Featured** — pins post in sub-hero slots (up to 2)
- 🔴 **Breaking News** — adds post to breaking banner (up to 5)

---

## Troubleshooting

**Theme not showing / white screen:**
```bash
docker exec abc_nepal_wp wp --allow-root theme activate abctvnepal
```

**Setup didn't run:**
```bash
docker compose run --rm wp_setup
```

**Permission errors on theme files:**
```bash
docker exec abc_nepal_wp chown -R www-data:www-data /var/www/html/wp-content/themes/abctvnepal
```

**`[ndc-today-date]` showing raw shortcode:**
- Go to WP Admin → Plugins → search "Nepali Date Converter" → Install & Activate

**`inc/news-toggles.php` missing fatal error:**
- The setup script auto-creates this stub file. If you see the error, run setup again:
  ```bash
  docker compose run --rm wp_setup
  ```

---

## Connecting to an Existing WordPress (not Docker)

If you want to attach this theme to an existing WP installation instead of Docker:

1. Copy the `theme/` folder contents to `wp-content/themes/abctvnepal/`
2. Run the WP-CLI commands from `setup/setup.sh` manually on your server
3. Go to **Appearance → Themes → Activate** "ABC Nepal TV"
4. The `inc/news-toggles.php` stub is created by setup.sh — make sure it exists

---

## Files You Can Delete From Theme Folder

These are redundant and safe to remove before copying to `./theme/`:

```
function.php          ← duplicate of functions.php (DANGEROUS — causes fatal error)
footer.css            ← empty file
page-live-update-old.php
single-live-blog.php  ← broken syntax
sports.php
international.php
opinion.php
english.php
economics.php
Entertainment.php
abc_video.php
updates.php
page-rajniti.php
page-kutniti-page-php.php
page-main_news.php
page-sahitaya.php     ← misconfigured
page-province.php     ← misconfigured
```

------------------------------------------

==========================================

-----------------------------------------

