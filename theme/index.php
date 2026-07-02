<?php
/*
Template Name: Main News (NYT-Style Layout)
*/
get_header();
?>
<?php include( get_template_directory() . '/breaking-banner.php' ); ?>
<style>
/* ================================================
   ABC Nepal TV — NYT-Style Homepage
   Hero story + byline/read-time rows + story grid
   Uses .nyt- prefix to avoid conflicts with theme
================================================ */
.nyt-wrap {
max-width: 1200px;
margin: 0 auto;
padding: 0 20px 60px;
font-family: Georgia, 'Times New Roman', serif;
color: #121212;
}
/* ── Top masthead rule ── */
.nyt-top-rule {
border-top: 1px solid #121212;
border-bottom: 1px solid #121212;
padding: 10px 0;
margin-bottom: 28px;
display: flex;
justify-content: space-between;
font-family: Arial, sans-serif;
font-size: 12px;
color: #555;
}
/* ── Hero story ── */
.nyt-hero {
display: grid;
grid-template-columns: 1.4fr 1fr;
gap: 32px;
padding-bottom: 32px;
border-bottom: 1px solid #e2e2e2;
margin-bottom: 32px;
}
.nyt-hero-media a { display: block; }
.nyt-hero-media img {
width: 100%;
height: 420px;
object-fit: cover;
display: block;
background: #ddd;
}
.nyt-hero-caption {
font-family: Arial, sans-serif;
font-size: 12px;
color: #727272;
margin-top: 6px;
line-height: 1.4;
}
.nyt-hero-text { padding-top: 4px; }
.nyt-kicker {
font-family: Arial, sans-serif;
font-size: 12px;
font-weight: 700;
text-transform: uppercase;
letter-spacing: .4px;
color: #c4170c;
margin-bottom: 10px;
display: inline-block;
}
.nyt-hero-text h1 {
font-size: 34px;
line-height: 1.18;
font-weight: 700;
margin: 0 0 14px;
}
.nyt-hero-text h1 a {
color: #121212;
text-decoration: none;
}
.nyt-hero-text h1 a:hover { text-decoration: underline; }
.nyt-hero-dek {
font-size: 17px;
line-height: 1.5;
color: #333;
margin: 0 0 16px;
font-family: Georgia, serif;
}
.nyt-byline-row {
font-family: Arial, sans-serif;
font-size: 12.5px;
color: #727272;
display: flex;
align-items: center;
gap: 6px;
flex-wrap: wrap;
}
.nyt-byline-row .nyt-readtime::before {
content: "•";
margin-right: 6px;
color: #ccc;
}
/* ── Banner section: stacked, ONE full-width banner per row ── */
.nyt-banner-stack {
display: flex;
flex-direction: column;
gap: 0;
margin-bottom: 8px;
}
.nyt-banner-row {
width: 100%;
display: grid;
grid-template-columns: 1.4fr 1fr;
gap: 32px;
padding: 28px 0;
border-bottom: 1px solid #e2e2e2;
}
.nyt-banner-row:first-child { padding-top: 0; }
.nyt-banner-media {
width: 100%;
}
.nyt-banner-media a { display: block; }
.nyt-banner-media img {
width: 100%;
height: 420px;
object-fit: cover;
display: block;
background: #ddd;
}
.nyt-banner-text { padding-top: 4px; }
.nyt-banner-text h2 {
font-size: 32px;
line-height: 1.18;
font-weight: 700;
margin: 0 0 14px;
}
.nyt-banner-text h2 a {
color: #121212;
text-decoration: none;
}
.nyt-banner-text h2 a:hover { text-decoration: underline; }
.nyt-banner-text .nyt-dek {
font-size: 16px;
line-height: 1.55;
color: #333;
margin: 0 0 16px;
}
@media (max-width: 900px) {
.nyt-banner-row { grid-template-columns: 1fr; }
.nyt-banner-media img { height: 280px; }
.nyt-banner-text h2 { font-size: 24px; }
}
/* ── Secondary grid (3-up) ── */
.nyt-grid {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 28px;
padding-bottom: 32px;
border-bottom: 1px solid #e2e2e2;
margin-bottom: 32px;
}
.nyt-story {
display: flex;
flex-direction: column;
}
.nyt-story-media a { display: block; }
.nyt-story-media img {
width: 100%;
height: 170px;
object-fit: cover;
display: block;
background: #ddd;
margin-bottom: 10px;
}
.nyt-story h3 {
font-size: 18px;
line-height: 1.3;
font-weight: 700;
margin: 0 0 8px;
}
.nyt-story h3 a {
color: #121212;
text-decoration: none;
}
.nyt-story h3 a:hover { text-decoration: underline; }
.nyt-story p.nyt-dek {
font-size: 14px;
color: #444;
line-height: 1.45;
margin: 0 0 8px;
}
.nyt-story .nyt-byline-row { margin-top: auto; }
.nyt-kicker-small {
font-family: Arial, sans-serif;
font-size: 11px;
font-weight: 700;
text-transform: uppercase;
letter-spacing: .4px;
color: #c4170c;
display: block;
margin-bottom: 6px;
}
/* ── Generic section title (used above list/split sections) ── */
.nyt-section-title {
font-family: Arial, sans-serif;
font-size: 13px;
font-weight: 700;
text-transform: uppercase;
letter-spacing: .4px;
color: #121212;
border-bottom: 2px solid #121212;
padding-bottom: 8px;
margin: 0 0 18px;
}
/* ── थप मुख्य समाचार split section: 3/4 story-card grid + 1/4 "ताजा मुख्य समाचार" list ── */
.nyt-split-section {
padding-bottom: 32px;
border-bottom: 1px solid #e2e2e2;
margin-bottom: 32px;
}
.nyt-split-grid {
display: grid;
grid-template-columns: 3fr 1fr;
gap: 32px;
align-items: start;
}
.nyt-split-main-grid {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 28px;
}
.nyt-split-side {
border-left: 1px solid #e2e2e2;
padding-left: 24px;
font-family: Arial, sans-serif;
}
.nyt-split-side h3 {
font-size: 15px;
font-weight: 700;
margin: 0 0 14px;
padding-bottom: 10px;
border-bottom: 2px solid #121212;
text-transform: uppercase;
letter-spacing: .4px;
}
.nyt-split-side ul {
list-style: none;
margin: 0;
padding: 0;
}
.nyt-split-side li {
padding: 10px 0;
border-bottom: 1px solid #f0f0f0;
font-size: 14.5px;
line-height: 1.4;
font-family: Georgia, serif;
}
.nyt-split-side li:last-child { border-bottom: none; }
.nyt-split-side li a {
color: #121212;
text-decoration: none;
font-weight: 600;
}
.nyt-split-side li a:hover { text-decoration: underline; }
@media (max-width: 900px) {
.nyt-split-grid { grid-template-columns: 1fr; }
.nyt-split-main-grid { grid-template-columns: repeat(2, 1fr); }
.nyt-split-side {
border-left: none;
border-top: 1px solid #e2e2e2;
padding-left: 0;
padding-top: 20px;
margin-top: 8px;
    }
}
@media (max-width: 580px) {
.nyt-split-main-grid { grid-template-columns: 1fr; }
}
/* ── Category band (4-up cards) ── */
.nyt-band {
margin-bottom: 32px;
}
.nyt-band-head {
display: flex;
align-items: center;
justify-content: space-between;
border-bottom: 2px solid #121212;
padding-bottom: 8px;
margin-bottom: 18px;
}
.nyt-band-head h2 {
font-family: Arial, sans-serif;
font-size: 13px;
font-weight: 700;
text-transform: uppercase;
letter-spacing: .4px;
margin: 0;
}
.nyt-band-head a.nyt-view-all {
font-family: Arial, sans-serif;
font-size: 12px;
font-weight: 600;
color: #c4170c;
text-decoration: none;
}
.nyt-band-head a.nyt-view-all:hover { text-decoration: underline; }
.nyt-band-grid {
display: grid;
grid-template-columns: repeat(4, 1fr);
gap: 24px;
}
.nyt-band-grid .nyt-story-media img { height: 130px; }
.nyt-band-grid .nyt-story h3 { font-size: 15px; }
/* ── Split band head: two headings, each with its own underline,
     aligned to the same 4-col grid as the cards below (e.g. 3+1) ── */
.nyt-band-head-split {
display: grid;
grid-template-columns: repeat(4, 1fr);
gap: 24px;
margin-bottom: 18px;
}
.nyt-band-head-col { position: relative; }
.nyt-band-head-col.primary { grid-column: span 3; }
.nyt-band-head-col.secondary { grid-column: span 1; }
.nyt-band-head-col h2 {
font-family: Arial, sans-serif;
font-size: 13px;
font-weight: 700;
text-transform: uppercase;
letter-spacing: .4px;
margin: 0;
padding-bottom: 8px;
border-bottom: 2px solid #121212;
}

.nyt-band-head-col.primary { grid-column: span 3; }
.nyt-band-head-col.secondary { grid-column: span 1; }

/* ── 2+2 split variant (used for कुटनीति + सूचना-प्रविधि) ── */
.nyt-band-head-split.split-2-2 .nyt-band-head-col.primary { grid-column: span 2; }
.nyt-band-head-split.split-2-2 .nyt-band-head-col.secondary { grid-column: span 2; }

.nyt-band-head-col .nyt-view-all {
position: absolute;
right: 0;
top: 0;
font-family: Arial, sans-serif;
font-size: 12px;
font-weight: 600;
color: #c4170c;
text-decoration: none;
}
.nyt-band-head-col .nyt-view-all:hover { text-decoration: underline; }
/* ── Newsletter strip ── */
.nyt-newsletter {
background: #f7f7f7;
border: 1px solid #e2e2e2;
border-radius: 4px;
padding: 32px 36px;
display: flex;
align-items: center;
justify-content: space-between;
gap: 24px;
flex-wrap: wrap;
font-family: Arial, sans-serif;
}
.nyt-newsletter h2 {
font-family: Georgia, serif;
font-size: 20px;
font-weight: 700;
margin: 0 0 4px;
}
.nyt-newsletter p {
font-size: 13px;
color: #555;
margin: 0;
}
.nyt-newsletter-form { display: flex; gap: 0; flex-shrink: 0; }
.nyt-newsletter-form input[type="email"] {
padding: 11px 16px;
border: 1px solid #ccc;
border-right: none;
border-radius: 3px 0 0 3px;
font-size: 13px;
width: 230px;
outline: none;
font-family: Arial, sans-serif;
}
.nyt-newsletter-form button {
padding: 11px 20px;
background: #121212;
color: #fff;
border: none;
border-radius: 0 3px 3px 0;
font-size: 13px;
font-weight: 700;
cursor: pointer;
font-family: Arial, sans-serif;
white-space: nowrap;
}
.nyt-newsletter-form button:hover { background: #333; }
/* ── Empty / placeholder cell ── */
.nyt-empty {
font-family: Arial, sans-serif;
font-size: 13px;
color: #999;
padding: 20px 0;
}
/* ── Responsive ── */
@media (max-width: 900px) {
.nyt-hero { grid-template-columns: 1fr; }
.nyt-hero-media img { height: 280px; }
.nyt-hero-text h1 { font-size: 26px; }
.nyt-grid { grid-template-columns: repeat(2, 1fr); }
.nyt-band-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 580px) {
.nyt-grid { grid-template-columns: 1fr; }
.nyt-band-grid { grid-template-columns: 1fr; }
.nyt-newsletter { flex-direction: column; align-items: flex-start; padding: 24px 20px; }
.nyt-newsletter-form { width: 100%; }
.nyt-newsletter-form input[type="email"] { flex: 1; width: auto; }
}
/* ── प्रदेश tabbed section ── */
.nyt-province-section .nyt-province-tabs {
display: flex;
flex-wrap: wrap;
gap: 8px;
margin-bottom: 22px;
font-family: Arial, sans-serif;
}
.nyt-ptab {
background: #fff;
border: 1px solid #d8d8d8;
border-radius: 4px;
padding: 9px 16px;
font-size: 13.5px;
font-weight: 600;
color: #333;
cursor: pointer;
display: inline-flex;
align-items: center;
justify-content: center;
transition: all .15s ease;
}
.nyt-ptab:first-child { padding: 9px 12px; color: #555; }
.nyt-ptab:hover { border-color: #c4170c; color: #c4170c; }
.nyt-ptab.active {
background: #121212;
border-color: #121212;
color: #fff;
}
.nyt-ptab.active:hover { color: #fff; }
.nyt-province-panel { display: none; }
.nyt-province-panel.active { display: block; }
.nyt-province-grid {
display: grid;
grid-template-columns: 1.6fr 1fr;
gap: 36px;
align-items: start;
}
.nyt-province-feature-media a { display: block; }
.nyt-province-feature-media img {
width: 100%;
height: 460px;
object-fit: cover;
display: block;
background: #ddd;
margin-bottom: 16px;
}
.nyt-province-feature-card h3 {
font-size: 26px;
line-height: 1.22;
font-weight: 700;
margin: 0 0 12px;
}
.nyt-province-feature-card h3 a { color: #121212; text-decoration: none; }
.nyt-province-feature-card h3 a:hover { text-decoration: underline; }
.nyt-province-feature-card .nyt-dek {
font-size: 15.5px;
line-height: 1.55;
color: #333;
margin: 0 0 14px;
}
.nyt-province-list {
list-style: none;
margin: 0;
padding: 0;
border-top: 1px solid #eee;
}
.nyt-province-list-item {
display: flex;
gap: 14px;
padding: 14px 0;
border-bottom: 1px solid #eee;
}
.nyt-province-list-media { flex-shrink: 0; display: block; }
.nyt-province-list-media img {
width: 96px;
height: 72px;
object-fit: cover;
display: block;
background: #ddd;
}
.nyt-province-list-text h4 {
font-size: 15px;
line-height: 1.35;
font-weight: 700;
margin: 0 0 6px;
font-family: Georgia, serif;
}
.nyt-province-list-text h4 a { color: #121212; text-decoration: none; }
.nyt-province-list-text h4 a:hover { text-decoration: underline; }
.nyt-province-list-time {
font-family: Arial, sans-serif;
font-size: 11.5px;
color: #888;
}
@media (max-width: 900px) {
.nyt-province-grid { grid-template-columns: 1fr; }
.nyt-province-feature-media img { height: 300px; }
}
@media (max-width: 580px) {
.nyt-ptab { padding: 8px 12px; font-size: 12.5px; }
}

/* ── विशेष कभरेज (Special Coverage) band ── */
.nyt-special-band {
    border: 1px solid #c4170c;
    border-radius: 4px;
    padding: 20px 24px 24px;
    background: #fff8f7;
}

/* ── विशेष कभरेज: 50/50 split — left = featured (image), right = headline bullets ── */
.nyt-special-split-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 36px;
    align-items: start;
}
.nyt-special-feature-media a { display: block; }
.nyt-special-feature-media img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    display: block;
    background: #ddd;
    margin-bottom: 14px;
}
.nyt-special-feature h3 {
    font-size: 24px;
    line-height: 1.22;
    font-weight: 700;
    margin: 0 0 10px;
    font-family: Georgia, serif;
}
.nyt-special-feature h3 a { color: #121212; text-decoration: none; }
.nyt-special-feature h3 a:hover { text-decoration: underline; }
.nyt-special-feature .nyt-dek {
    font-size: 15px;
    line-height: 1.55;
    color: #333;
    margin: 0 0 12px;
}
.nyt-special-list-wrap {
    border-left: 1px solid #f0d6d3;
    padding-left: 24px;
    /* no fixed height — grows naturally with headline count */
}
.nyt-special-list-wrap h4 {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: #c4170c;
    margin: 0 0 12px;
}
.nyt-special-list {
    list-style: disc;
    margin: 0;
    padding-left: 18px;
}
.nyt-special-list li {
    padding: 10px 0;
    border-bottom: 1px solid #f0d6d3;
    font-size: 15px;
    line-height: 1.45;
    font-family: Georgia, serif;
}
.nyt-special-list li:last-child { border-bottom: none; }
.nyt-special-list li a {
    color: #121212;
    text-decoration: none;
    font-weight: 600;
}
.nyt-special-list li a:hover { text-decoration: underline; color: #c4170c; }
@media (max-width: 900px) {
    .nyt-special-split-grid { grid-template-columns: 1fr; }
    .nyt-special-list-wrap {
        border-left: none;
        padding-left: 0;
        border-top: 1px solid #f0d6d3;
        padding-top: 16px;
        margin-top: 8px;
    }
}

.nyt-special-head {
    border-bottom: 2px solid #c4170c;
}
.nyt-special-head h2 {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #c4170c;
}
.nyt-special-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #c4170c;
    display: inline-block;
    animation: nyt-pulse 1.4s infinite;
}
@keyframes nyt-pulse {
    0%   { opacity: 1; }
    50%  { opacity: .3; }
    100% { opacity: 1; }
}

/*======================================
Entertainment / Lifestyle Split
======================================*/

.nyt-feature-split{
display:grid;
grid-template-columns:1fr 1fr;
gap:35px;
margin:45px 0;
}

.nyt-feature-column{
display:flex;
flex-direction:column;
}

.nyt-feature-heading{
border-bottom:2px solid #111;
margin-bottom:18px;
}

.nyt-feature-heading h2{
margin:0;
padding-bottom:8px;
font-size:18px;
font-weight:700;
}

.nyt-feature-image img{
width:100%;
height:320px;
object-fit:cover;
display:block;
}

.nyt-feature-column h3{
font-size:28px;
line-height:1.2;
margin:18px 0 10px;
}

.nyt-feature-column h3 a{
text-decoration:none;
color:#111;
}

.nyt-feature-column h3 a:hover{
text-decoration:underline;
}

.nyt-feature-column p{
font-size:16px;
line-height:1.6;
color:#444;
margin-bottom:15px;
}

@media(max-width:900px){
.nyt-feature-split{
grid-template-columns:1fr;
}
.nyt-feature-image img{
height:250px;
}
}

/*======================================
Split Feature + Bullet List (2 columns)
Each column: 1 featured post (image+title+dek) + bullet list below
======================================*/
.nyt-split-feature-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:36px;
}
.nyt-split-feature-col{
display:flex;
flex-direction:column;
}
.nyt-split-feature-head{
display:flex;
align-items:center;
justify-content:space-between;
border-bottom:2px solid #121212;
padding-bottom:8px;
margin-bottom:18px;
font-family:Arial, sans-serif;
}
.nyt-split-feature-head h2{
font-size:13px;
font-weight:700;
text-transform:uppercase;
letter-spacing:.4px;
margin:0;
}
.nyt-split-feature-head .nyt-view-all{
font-size:12px;
font-weight:600;
color:#c4170c;
text-decoration:none;
}
.nyt-split-feature-head .nyt-view-all:hover{ text-decoration:underline; }

/* Featured post (image + title + dek + byline) */
.nyt-split-feature-card{
margin-bottom:20px;
padding-bottom:20px;
border-bottom:1px solid #e2e2e2;
}
.nyt-split-feature-media a{ display:block; }
.nyt-split-feature-media img{
width:100%;
height:220px;
object-fit:cover;
display:block;
background:#ddd;
margin-bottom:14px;
}
.nyt-split-feature-card h3{
font-size:20px;
line-height:1.25;
font-weight:700;
margin:0 0 8px;
font-family:Georgia, serif;
}
.nyt-split-feature-card h3 a{ color:#121212; text-decoration:none; }
.nyt-split-feature-card h3 a:hover{ text-decoration:underline; }
.nyt-split-feature-card .nyt-dek{
font-size:14.5px;
line-height:1.5;
color:#333;
margin:0 0 10px;
}

/* Bullet list — title only, no image */
.nyt-split-feature-list{
list-style:disc;
margin:0;
padding-left:18px;
}
.nyt-split-feature-list li{
padding:10px 0;
border-bottom:1px solid #f0f0f0;
font-size:15px;
line-height:1.4;
font-family:Georgia, serif;
}
.nyt-split-feature-list li:last-child{ border-bottom:none; }
.nyt-split-feature-list li a{
color:#121212;
text-decoration:none;
font-weight:600;
}
.nyt-split-feature-list li a:hover{ text-decoration:underline; color:#c4170c; }

@media (max-width:900px){
.nyt-split-feature-grid{ grid-template-columns:1fr; }
.nyt-split-feature-media img{ height:220px; }
}


/* ── International 30/30/40 split ── */
.nyt-intl-split-grid {
    display: grid;
    grid-template-columns: 3fr 3fr 4fr;  /* 30% | 30% | 40% */
    gap: 28px;
    align-items: start;
}

.nyt-intl-feature {
    display: flex;
    flex-direction: column;
}

.nyt-intl-feature-media a { display: block; }
.nyt-intl-feature-media img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    background: #ddd;
    margin-bottom: 14px;
}

.nyt-intl-feature h3 {
    font-size: 19px;
    line-height: 1.26;
    font-weight: 700;
    margin: 0 0 8px;
    font-family: Georgia, serif;
}
.nyt-intl-feature h3 a { color: #121212; text-decoration: none; }
.nyt-intl-feature h3 a:hover { text-decoration: underline; }

.nyt-intl-feature .nyt-dek {
    font-size: 14.5px;
    line-height: 1.5;
    color: #333;
    margin: 0 0 10px;
}

/* Right column: bullets only */
.nyt-intl-bullets {
    border-left: 1px solid #e2e2e2;
    padding-left: 22px;
}
.nyt-intl-bullets ul {
    list-style: disc;
    margin: 0;
    padding-left: 18px;
}
.nyt-intl-bullets li {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14.5px;
    line-height: 1.4;
    font-family: Georgia, serif;
}
.nyt-intl-bullets li:last-child { border-bottom: none; }
.nyt-intl-bullets li a {
    color: #121212;
    text-decoration: none;
    font-weight: 600;
}
.nyt-intl-bullets li a:hover { text-decoration: underline; color: #c4170c; }

/* Responsive */
@media (max-width: 900px) {
    .nyt-intl-split-grid {
        grid-template-columns: 1fr 1fr;
    }
    .nyt-intl-bullets {
        grid-column: span 2;
        border-left: none;
        border-top: 1px solid #e2e2e2;
        padding-left: 0;
        padding-top: 16px;
        margin-top: 8px;
    }
}
@media (max-width: 580px) {
    .nyt-intl-split-grid { grid-template-columns: 1fr; }
    .nyt-intl-bullets { grid-column: span 1; }
    .nyt-intl-feature-media img { height: 180px; }
}
</style>
<div class="nyt-wrap">



<?php
/* =====================================================
   HELPERS
===================================================== */
// Estimate read time from word count (~200 wpm), min 1
function nyt_read_time( $post_id ) {
$content = get_post_field( 'post_content', $post_id );
$words   = str_word_count( wp_strip_all_tags( $content ) );
$minutes = max( 1, (int) ceil( $words / 200 ) );
return $minutes . ' MIN READ';
}
// Byline string from post author(s)
function nyt_byline( $post_id ) {
$author_id = get_post_field( 'post_author', $post_id );
$name      = get_the_author_meta( 'display_name', $author_id );
return 'By ' . $name;
}
// Render a single story card (image + title + dek + byline row)
// $kicker: optional small red label shown above the title (e.g. "सम्पादकीय")
function nyt_render_story_card( $post_id, $show_dek = true, $kicker = '' ) {
?>
<article class="nyt-story">
<div class="nyt-story-media">
<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
<?php if ( has_post_thumbnail( $post_id ) ) {
echo get_the_post_thumbnail( $post_id, 'medium_large' );
                } else { ?>
<img src="https://placehold.co/400x230/eeeeee/999999?text=Photo" alt="">
<?php } ?>
</a>
</div>
<?php if ( $kicker ) : ?>
<span class="nyt-kicker-small"><?php echo esc_html( $kicker ); ?></span>
<?php endif; ?>
<h3><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
<?php if ( $show_dek ) : ?>
<p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post_id ), 18 ) ); ?></p>
<?php endif; ?>
<div class="nyt-byline-row">
<span class="nyt-byline"><?php echo esc_html( nyt_byline( $post_id ) ); ?></span>
<span class="nyt-readtime"><?php echo esc_html( nyt_read_time( $post_id ) ); ?></span>
</div>
</article>
<?php
}
// Render a category band: heading + "view all" + 4-up grid
function nyt_render_band( $cfg ) {
$label = $cfg['label'];
$cat   = $cfg['cat'];
$link  = $cfg['link'];
$cols  = isset( $cfg['cols'] ) ? (int) $cfg['cols'] : 4;
$q = new WP_Query( array(
'posts_per_page' => $cols,
'category_name'  => $cat,
    ) );
if ( ! $q->have_posts() ) {
wp_reset_postdata();
return;
    }
?>
<div class="nyt-band">
<div class="nyt-band-head">
<h2><?php echo esc_html( $label ); ?></h2>
<a class="nyt-view-all" href="<?php echo esc_url( $link ); ?>">See more &rsaquo;</a>
</div>
<div class="nyt-band-grid">
<?php while ( $q->have_posts() ) : $q->the_post();
nyt_render_story_card( get_the_ID(), false );
endwhile; ?>
</div>
</div>
<?php
wp_reset_postdata();
}

// Render the विशेष कभरेज (Special Coverage) band — 50/50 split.
// Left: latest UPDATED post with feature image.
// Right: rest of updated posts from same category as bulleted headlines (no image).
// Only prints anything — heading included — if the category has posts.
function nyt_render_special_band( $cfg ) {
    $label = isset( $cfg['label'] ) ? $cfg['label'] : 'विशेष कभरेज';
    $cat   = $cfg['cat'];
    $link  = $cfg['link'];
    // total posts to pull: 1 goes to the featured cell, the rest fill the bullet list
    $total = isset( $cfg['cols'] ) ? (int) $cfg['cols'] : 6;

    $q = new WP_Query( array(
        'posts_per_page' => $total,
        'category_name'  => $cat,
        'orderby'        => 'modified', // अपडेट भएको अनुसार
        'order'          => 'ASC',
    ) );

    if ( ! $q->have_posts() ) {
        wp_reset_postdata();
        return; // no posts in abcspecial → render nothing, heading included
    }

    $posts = $q->posts;
    wp_reset_postdata();

    $featured    = array_shift( $posts ); // first/most-recently-updated post
    $rest        = $posts;                 // remaining updated posts → bullet list
    $featured_id = $featured->ID;
    ?>
    <div class="nyt-band nyt-special-band">
        <div class="nyt-band-head nyt-special-head">
            <h2><span class="nyt-special-dot"></span><?php echo esc_html( $label ); ?></h2>
            <a class="nyt-view-all" href="<?php echo esc_url( $link ); ?>">See more &rsaquo;</a>
        </div>

        <div class="nyt-special-split-grid">
            <!-- LEFT: featured, with image -->
            <div class="nyt-special-feature">
                <div class="nyt-special-feature-media">
                    <a href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>">
                        <?php if ( has_post_thumbnail( $featured_id ) ) {
                            echo get_the_post_thumbnail( $featured_id, 'large' );
                        } else { ?>
                            <img src="https://placehold.co/700x420/eeeeee/999999?text=Photo" alt="">
                        <?php } ?>
                    </a>
                </div>
                <h3><a href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>"><?php echo esc_html( get_the_title( $featured_id ) ); ?></a></h3>
                <p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $featured_id ), 26 ) ); ?></p>
                <div class="nyt-byline-row">
                    <span class="nyt-byline"><?php echo esc_html( nyt_byline( $featured_id ) ); ?></span>
                    <span class="nyt-readtime"><?php echo esc_html( nyt_read_time( $featured_id ) ); ?></span>
                </div>
            </div>

            <!-- RIGHT: headline-only bullets, no image, grows with content -->
            <div class="nyt-special-list-wrap">
                <?php if ( ! empty( $rest ) ) : ?>
                    <ul class="nyt-special-list">
                        <?php foreach ( $rest as $rp ) : ?>
                            <li><a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>"><?php echo esc_html( get_the_title( $rp->ID ) ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="nyt-empty">थप अपडेट छिट्टै थपिनेछ।</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

    // Render a "mixed" band: N posts from a primary category + M posts from a
    // secondary category, all inside the same 4-up grid. Used for "विचार" where
    // 3 boxes come from 'opinion' and the last box comes from 'सम्पादकीय' (editorial).
    function nyt_render_band_mixed( $cfg ) {
    $label         = $cfg['label'];
    $link          = $cfg['link'];
    $primary_cat   = $cfg['primary_cat'];
    $primary_n     = isset( $cfg['primary_count'] ) ? (int) $cfg['primary_count'] : 3;
    $secondary_cat   = $cfg['secondary_cat'];
    $secondary_n     = isset( $cfg['secondary_count'] ) ? (int) $cfg['secondary_count'] : 1;
    $secondary_label = isset( $cfg['secondary_label'] ) ? $cfg['secondary_label'] : '';

    $secondary_label = isset( $cfg['secondary_label'] ) ? $cfg['secondary_label'] : '';
    $split_class     = isset( $cfg['split'] ) ? ' ' . esc_attr( $cfg['split'] ) : ''; // e.g. 'split-2-2'

    $q1 = new WP_Query( array(
    'posts_per_page' => $primary_n,
    'category_name'  => $primary_cat,
        ) );
    $q1_posts = $q1->posts;
    wp_reset_postdata();
    $q2 = new WP_Query( array(
    'posts_per_page' => $secondary_n,
    'category_name'  => $secondary_cat,
    'post__not_in'   => wp_list_pluck( $q1_posts, 'ID' ), // avoid duplicate if a post is in both cats
        ) );
    $q2_posts = $q2->posts;
    wp_reset_postdata();
    if ( empty( $q1_posts ) && empty( $q2_posts ) ) {
    return;
        }

    // ── International 30/30/40 split: 2 featured posts + 5 headline bullets ──
    if ( ! function_exists( 'nyt_render_intl_split' ) ) :
// ── International 30/30/40 split: 2 featured posts + 5 headline bullets ──
function nyt_render_intl_split( $cfg ) {
    $label       = isset( $cfg['label'] ) ? $cfg['label'] : 'अन्तर्राष्ट्रिय';
    $link        = $cfg['link'];
    $cat         = $cfg['cat'];
    $featured_n  = isset( $cfg['featured_count'] ) ? (int) $cfg['featured_count'] : 2;
    $bullet_n    = isset( $cfg['bullet_count'] ) ? (int) $cfg['bullet_count'] : 5;

    $q = new WP_Query( array(
        'posts_per_page' => $featured_n + $bullet_n,
        'category_name'  => $cat,
    ) );

    if ( ! $q->have_posts() ) {
        wp_reset_postdata();
        return;
    }

    $posts    = $q->posts;
    wp_reset_postdata();
    $featured = array_slice( $posts, 0, $featured_n );
    $bullets  = array_slice( $posts, $featured_n );
    ?>
    <div class="nyt-band">
        <div class="nyt-band-head">
            <h2><?php echo esc_html( $label ); ?></h2>
            <a class="nyt-view-all" href="<?php echo esc_url( $link ); ?>">See more &rsaquo;</a>
        </div>
        <div class="nyt-intl-split-grid">
            <?php foreach ( $featured as $fp ) : $fp_id = $fp->ID; ?>
            <div class="nyt-intl-feature">
                <div class="nyt-intl-feature-media">
                    <a href="<?php echo esc_url( get_permalink( $fp_id ) ); ?>">
                        <?php if ( has_post_thumbnail( $fp_id ) ) {
                            echo get_the_post_thumbnail( $fp_id, 'large' );
                        } else { ?>
                            <img src="https://placehold.co/600x340/eeeeee/999999?text=Photo" alt="">
                        <?php } ?>
                    </a>
                </div>
                <h3><a href="<?php echo esc_url( get_permalink( $fp_id ) ); ?>"><?php echo esc_html( get_the_title( $fp_id ) ); ?></a></h3>
                <p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $fp_id ), 22 ) ); ?></p>
                <div class="nyt-byline-row">
                    <span class="nyt-byline"><?php echo esc_html( nyt_byline( $fp_id ) ); ?></span>
                    <span class="nyt-readtime"><?php echo esc_html( nyt_read_time( $fp_id ) ); ?></span>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="nyt-intl-bullets">
                <ul>
                    <?php foreach ( $bullets as $bp ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( $bp->ID ) ); ?>"><?php echo esc_html( get_the_title( $bp->ID ) ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
endif;
?>

<div class="nyt-band">
<div class="nyt-band-head-split<?php echo esc_html( $split_class ); ?>">
<div class="nyt-band-head-col primary">
<h2><?php echo esc_html( $label ); ?></h2>
</div>
<div class="nyt-band-head-col secondary">
<h2><?php echo esc_html( $secondary_label ); ?></h2>
<a class="nyt-view-all" href="<?php echo esc_url( $link ); ?>">See more &rsaquo;</a>
</div>
</div>
<div class="nyt-band-grid">
<?php
foreach ( $q1_posts as $p ) {
nyt_render_story_card( $p->ID, false );
            }
foreach ( $q2_posts as $p ) {
nyt_render_story_card( $p->ID, false );
            }
?>
</div>
</div>
<?php
}

// Renders one column: 1 featured post (image+title+dek+byline) + up to 5 bullet-only titles
function nyt_render_feature_bullet_column( $posts ) {
    if ( empty( $posts ) ) {
        return;
    }
    $posts    = array_values( $posts );
    $featured = array_shift( $posts );
    $rest     = array_slice( $posts, 0, 5 ); // up to 5 bullet titles
    $f_id     = $featured->ID;
    ?>
    <article class="nyt-split-feature-card">
        <div class="nyt-split-feature-media">
            <a href="<?php echo esc_url( get_permalink( $f_id ) ); ?>">
                <?php if ( has_post_thumbnail( $f_id ) ) {
                    echo get_the_post_thumbnail( $f_id, 'large' );
                } else { ?>
                    <img src="https://placehold.co/700x420/eeeeee/999999?text=Photo" alt="">
                <?php } ?>
            </a>
        </div>
        <h3><a href="<?php echo esc_url( get_permalink( $f_id ) ); ?>"><?php echo esc_html( get_the_title( $f_id ) ); ?></a></h3>
        <p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $f_id ), 26 ) ); ?></p>
        <div class="nyt-byline-row">
            <span class="nyt-byline"><?php echo esc_html( nyt_byline( $f_id ) ); ?></span>
            <span class="nyt-readtime"><?php echo esc_html( nyt_read_time( $f_id ) ); ?></span>
        </div>
    </article>
    <?php if ( ! empty( $rest ) ) : ?>
    <ul class="nyt-split-feature-list">
        <?php foreach ( $rest as $rp ) : ?>
            <li><a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>"><?php echo esc_html( get_the_title( $rp->ID ) ); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php endif;
}

// Renders a 2-column split: left category (featured + bullets) | right category (featured + bullets)
// Each column has its own heading. "See more" link sits on the right (secondary) column.
function nyt_render_split_feature_grid( $cfg ) {
    $label           = $cfg['label'];
    $link            = $cfg['link'];
    $primary_cat     = $cfg['primary_cat'];
    $secondary_cat   = $cfg['secondary_cat'];
    $secondary_label = isset( $cfg['secondary_label'] ) ? $cfg['secondary_label'] : '';
    // 1 featured + 5 bullets = 6 posts pulled per column by default
    $primary_total   = isset( $cfg['primary_count'] ) ? (int) $cfg['primary_count'] : 6;
    $secondary_total = isset( $cfg['secondary_count'] ) ? (int) $cfg['secondary_count'] : 6;

    $q1 = new WP_Query( array(
        'posts_per_page' => $primary_total,
        'category_name'  => $primary_cat,
    ) );
    $q1_posts = $q1->posts;
    wp_reset_postdata();

    $q2 = new WP_Query( array(
        'posts_per_page' => $secondary_total,
        'category_name'  => $secondary_cat,
        'post__not_in'   => wp_list_pluck( $q1_posts, 'ID' ),
    ) );
    $q2_posts = $q2->posts;
    wp_reset_postdata();

    if ( empty( $q1_posts ) && empty( $q2_posts ) ) {
        return;
    }
    ?>
    <div class="nyt-band">
        <div class="nyt-split-feature-grid">

            <div class="nyt-split-feature-col">
                <div class="nyt-split-feature-head">
                    <h2><?php echo esc_html( $label ); ?></h2>
                </div>
                <?php nyt_render_feature_bullet_column( $q1_posts ); ?>
            </div>

            <div class="nyt-split-feature-col">
                <div class="nyt-split-feature-head">
                    <h2><?php echo esc_html( $secondary_label ); ?></h2>
                    <a class="nyt-view-all" href="<?php echo esc_url( $link ); ?>">See more &rsaquo;</a>
                </div>
                <?php nyt_render_feature_bullet_column( $q2_posts ); ?>
            </div>

        </div>
    </div>
    <?php
}

// Render a 50/50 "feature split" band: one featured post from a left category
// alongside one featured post from a right category, each with its own heading,
// image, title, dek and byline row. Used for साहित्य–कला–मनोरञ्जन / स्वास्थ्य–जीवनशैली.
function nyt_render_feature_split( $cfg ) {

    $left = new WP_Query(array(
        'posts_per_page' => 1,
        'category_name'  => $cfg['left_cat']
    ));

    $right = new WP_Query(array(
        'posts_per_page' => 1,
        'category_name'  => $cfg['right_cat']
    ));

    if( !$left->have_posts() && !$right->have_posts() ){
        return;
    }
?>

<div class="nyt-feature-split">

    <div class="nyt-feature-column">

        <div class="nyt-feature-heading">
            <h2><?php echo esc_html($cfg['left_label']); ?></h2>
        </div>

        <?php while($left->have_posts()): $left->the_post(); ?>

            <div class="nyt-feature-image">

                <a href="<?php the_permalink();?>">

                    <?php
                    if(has_post_thumbnail())
                        the_post_thumbnail('large');
                    ?>

                </a>

            </div>

            <h3>

                <a href="<?php the_permalink();?>">

                    <?php the_title();?>

                </a>

            </h3>

            <p>

                <?php echo wp_trim_words(get_the_excerpt(),30);?>

            </p>

            <div class="nyt-byline-row">

                <span class="nyt-byline">

                    <?php echo nyt_byline(get_the_ID());?>

                </span>

                <span class="nyt-readtime">

                    <?php echo nyt_read_time(get_the_ID());?>

                </span>

            </div>

        <?php endwhile; wp_reset_postdata(); ?>

    </div>



    <div class="nyt-feature-column">

        <div class="nyt-feature-heading">
            <h2><?php echo esc_html($cfg['right_label']); ?></h2>
        </div>

        <?php while($right->have_posts()): $right->the_post(); ?>

            <div class="nyt-feature-image">

                <a href="<?php the_permalink();?>">

                    <?php
                    if(has_post_thumbnail())
                        the_post_thumbnail('large');
                    ?>

                </a>

            </div>

            <h3>

                <a href="<?php the_permalink();?>">

                    <?php the_title();?>

                </a>

            </h3>

            <p>

                <?php echo wp_trim_words(get_the_excerpt(),30);?>

            </p>

            <div class="nyt-byline-row">

                <span class="nyt-byline">

                    <?php echo nyt_byline(get_the_ID());?>

                </span>

                <span class="nyt-readtime">

                    <?php echo nyt_read_time(get_the_ID());?>

                </span>

            </div>

        <?php endwhile; wp_reset_postdata(); ?>

    </div>

</div>

<?php
}

// ── प्रदेश (province) tabbed section ──
// Renders the whole tabbed section: head + tab bar + one panel per province
function nyt_render_province_section( $cfg ) {
    $label          = $cfg['label'];
    $link           = $cfg['link'];
    $provinces      = $cfg['provinces']; // key => array('label'=>.., 'slug'=>..)
    $featured_count = isset( $cfg['featured_count'] ) ? (int) $cfg['featured_count'] : 1;
    $list_count     = isset( $cfg['list_count'] ) ? (int) $cfg['list_count'] : 6;
    $parent_slug    = isset( $cfg['parent_slug'] ) ? $cfg['parent_slug'] : 'province';

    $parent_term = get_category_by_slug( $parent_slug );
    ?>
    <div class="nyt-band nyt-province-section">
        <div class="nyt-band-head">
            <h2><?php echo esc_html( $label ); ?></h2>
            <a class="nyt-view-all" href="<?php echo esc_url( $link ); ?>">थप समाचार &rsaquo;</a>
        </div>

        <div class="nyt-province-tabs">
            <button type="button" class="nyt-ptab active" data-ptab="home" aria-label="सबै प्रदेश">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 11L12 3L21 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 10V20C5 20.5523 5.44772 21 6 21H9C9.55228 21 10 20.5523 10 20V15C10 14.4477 10.4477 14 11 14H13C13.5523 14 14 14.4477 14 15V20C14 20.5523 14.4477 21 15 21H18C18.5523 21 19 20.5523 19 20V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <?php foreach ( $provinces as $key => $p ) : ?>
                <button type="button" class="nyt-ptab" data-ptab="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $p['label'] ); ?></button>
            <?php endforeach; ?>
        </div>

        <?php
        // ── HOME panel: latest posts across the whole province tree ──
        $home_args = array(
            'posts_per_page' => $featured_count + $list_count,
        );
        if ( $parent_term && ! is_wp_error( $parent_term ) ) {
            $home_args['cat'] = $parent_term->term_id; // 'cat' includes child categories by default
        } else {
            $home_args['category_name'] = $parent_slug;
        }
        $home_query = new WP_Query( $home_args );
        $home_posts = $home_query->posts;
        wp_reset_postdata();
        nyt_render_province_panel( 'home', $home_posts, $featured_count );

        // ── One panel per province sub-category ──
        foreach ( $provinces as $key => $p ) {
            $pq = new WP_Query( array(
                'posts_per_page' => $featured_count + $list_count,
                'category_name'  => $p['slug'],
            ) );
            $p_posts = $pq->posts;
            wp_reset_postdata();
            nyt_render_province_panel( $key, $p_posts, $featured_count );
        }
        ?>
    </div>
    <?php
}

// Renders a single tab's content: featured story (left) + thumb list (right)
function nyt_render_province_panel( $key, $posts, $featured_count = 1 ) {
    $active_class = ( 'home' === $key ) ? ' active' : '';
    ?>
    <div class="nyt-province-panel<?php echo esc_attr( $active_class ); ?>" data-ptab="<?php echo esc_attr( $key ); ?>">
        <?php if ( empty( $posts ) ) : ?>
            <p class="nyt-empty">यस प्रदेशका समाचारहरू छिट्टै थपिनेछन्।</p>
        <?php else :
            $featured = array_slice( $posts, 0, $featured_count );
            $rest     = array_slice( $posts, $featured_count );
            ?>
            <div class="nyt-province-grid">
                <div class="nyt-province-featured">
                    <?php foreach ( $featured as $fp ) : $fp_id = $fp->ID; ?>
                        <article class="nyt-province-feature-card">
                            <div class="nyt-province-feature-media">
                                <a href="<?php echo esc_url( get_permalink( $fp_id ) ); ?>">
                                    <?php if ( has_post_thumbnail( $fp_id ) ) {
                                        echo get_the_post_thumbnail( $fp_id, 'large' );
                                    } else { ?>
                                        <img src="https://placehold.co/700x480/eeeeee/999999?text=Photo" alt="">
                                    <?php } ?>
                                </a>
                            </div>
                            <h3><a href="<?php echo esc_url( get_permalink( $fp_id ) ); ?>"><?php echo esc_html( get_the_title( $fp_id ) ); ?></a></h3>
                            <p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $fp_id ), 26 ) ); ?></p>
                            <div class="nyt-byline-row">
                                <span class="nyt-byline"><?php echo esc_html( nyt_byline( $fp_id ) ); ?></span>
                                <span class="nyt-readtime"><?php echo esc_html( nyt_read_time( $fp_id ) ); ?></span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if ( ! empty( $rest ) ) : ?>
                    <ul class="nyt-province-list">
                        <?php foreach ( $rest as $rp ) : $rp_id = $rp->ID; ?>
                            <li class="nyt-province-list-item">
                                <a class="nyt-province-list-media" href="<?php echo esc_url( get_permalink( $rp_id ) ); ?>">
                                    <?php if ( has_post_thumbnail( $rp_id ) ) {
                                        echo get_the_post_thumbnail( $rp_id, 'thumbnail' );
                                    } else { ?>
                                        <img src="https://placehold.co/120x90/eeeeee/999999?text=+" alt="">
                                    <?php } ?>
                                </a>
                                <div class="nyt-province-list-text">
                                    <h4><a href="<?php echo esc_url( get_permalink( $rp_id ) ); ?>"><?php echo esc_html( get_the_title( $rp_id ) ); ?></a></h4>
                                    <span class="nyt-province-list-time"><?php echo esc_html( nyt_read_time( $rp_id ) ); ?></span>
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
?>
<!-- ── Masthead date / edition rule ── -->
<div class="nyt-top-rule">
<span><?php echo esc_html( date_i18n( 'l, F j, Y' ) ); ?></span>
<span>Today's Edition</span>
</div>
<!-- =====================================================
     INDEX-BANNER SECTION
     Pulls up to 3 posts from the "index-banner" category
     (slug: banner). Each one gets its OWN full-width row,
     stacked vertically — never side-by-side.
     Set $nyt_banner_count to show fewer/more rows.
===================================================== -->
<?php
$nyt_banner_count = 3; // how many index-banner posts to show, each as its own full-width row
$banner_query = new WP_Query( array(
'posts_per_page' => $nyt_banner_count,
'category_name'  => 'banner',
'orderby'        => 'date',
'order'          => 'DESC', // newest index-banner post shows first (top row)
) );
$banner_posts = $banner_query->posts;
wp_reset_postdata();
// Fallback: if no posts are tagged "index-banner" at all, use the latest post
if ( empty( $banner_posts ) ) {
$fallback_query = new WP_Query( array( 'posts_per_page' => 1 ) );
$banner_posts   = $fallback_query->posts;
wp_reset_postdata();
}
$used_ids = array();
if ( ! empty( $banner_posts ) ) : ?>
<div class="nyt-banner-stack">
<?php foreach ( $banner_posts as $bp ) :
$used_ids[] = $bp->ID;
$bp_id      = $bp->ID;
$bp_cats    = get_the_category( $bp_id );
?>
<article class="nyt-banner-row">
<div class="nyt-banner-media">
<a href="<?php echo esc_url( get_permalink( $bp_id ) ); ?>">
<?php if ( has_post_thumbnail( $bp_id ) ) {
echo get_the_post_thumbnail( $bp_id, 'large' );
                        } else { ?>
<img src="https://placehold.co/900x420/eeeeee/999999?text=Photo" alt="">
<?php } ?>
</a>
</div>
<div class="nyt-banner-text">
<span class="nyt-kicker"><?php echo esc_html( $bp_cats[0]->name ?? 'INDEX-BANNER' ); ?></span>
<h2><a href="<?php echo esc_url( get_permalink( $bp_id ) ); ?>"><?php echo esc_html( get_the_title( $bp_id ) ); ?></a></h2>
<p class="nyt-dek"><?php echo esc_html( wp_trim_words( get_the_excerpt( $bp_id ), 34 ) ); ?></p>
<div class="nyt-byline-row">
<span class="nyt-byline"><?php echo esc_html( nyt_byline( $bp_id ) ); ?></span>
<span class="nyt-readtime"><?php echo esc_html( nyt_read_time( $bp_id ) ); ?></span>
</div>
</div>
</article>
<?php endforeach; ?>
</div>
<?php endif; ?>
<!-- =====================================================
     विशेष कभरेज (Special Coverage) — abcspecial category.
     Renders nothing at all (no heading) when the category
     currently has zero posts.
===================================================== -->
<?php
nyt_render_special_band( array(
    'label' => 'विशेष कभरेज',
    'cat'   => 'abcspecial',
    'link'  => home_url( '/abcspecial/' ),
    'cols'  => 10, // 1 featured + 5 headline bullets (जति post छन् त्यति अनुसार list तन्किन्छ)
) );
?>
<!-- =====================================================
     SECONDARY GRID (3-up, with dek + byline/read-time)
===================================================== -->

<!-- =====================================================
     थप मुख्य समाचार
     Left (3/4 width): headline + image cards, pulled from
     the "news" (मुख्य समाचार) + "banner" (ब्यान इन्डेक्स)
     categories, most recently UPDATED first.
     Right (1/4 width): "ताजा मुख्य समाचार" — title-only
     list of the freshest updates from ANY category.
===================================================== -->
<?php
$thap_query = new WP_Query( array(
'posts_per_page' => 6,
'category_name'  => 'news,banner', // comma = OR — either category qualifies
'post__not_in'   => $used_ids,
'orderby'        => 'modified',    // "अपडेट भएको" — most recently updated first
'order'          => 'DESC',
) );
if ( $thap_query->have_posts() ) : ?>
<div class="nyt-split-section">
<h2 class="nyt-section-title">थप मुख्य समाचार</h2>
<div class="nyt-split-grid">
<!-- 3/4 — headline + image cards (news + banner, latest updated) -->
<div class="nyt-split-main-grid">
<?php while ( $thap_query->have_posts() ) : $thap_query->the_post();
$used_ids[] = get_the_ID();
nyt_render_story_card( get_the_ID() );
endwhile; ?>
</div>
<!-- 1/4 — ताजा मुख्य समाचार (title-only, any category, freshest updates) -->
<aside class="nyt-split-side">
<h3>ताजा मुख्य समाचार</h3>
<ul>
<?php
$split_list_query = new WP_Query( array(
'posts_per_page' => 8,
'post__not_in'   => $used_ids,
'orderby'        => 'modified', // freshest update, regardless of category
'order'          => 'DESC',
                ) );
if ( $split_list_query->have_posts() ) :
while ( $split_list_query->have_posts() ) : $split_list_query->the_post();
$used_ids[] = get_the_ID();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
endwhile;
endif;
wp_reset_postdata();
?>
</ul>
</aside>
</div>
</div>
<?php endif; wp_reset_postdata(); ?>
<!-- =====================================================
     CATEGORY BANDS (4-up each)
===================================================== -->
<?php
nyt_render_band( array(
'label' => 'मुख्यसमाचार',
'cat'   => 'news',
'link'  => home_url( '/mainnews/' ),
) );
nyt_render_band( array(
'label' => 'राजनीति',
'cat'   => 'politics',
'link'  => home_url( '/politics/' ),
) );

// ── प्रदेश: tabbed section (home icon + 7 provinces) ──
nyt_render_province_section( array(
    'label'          => 'प्रदेश',
    'link'           => home_url( '/province/' ),
    'parent_slug'    => 'province',
    'featured_count' => 1,
    'list_count'     => 6,
    'provinces'      => array(
        'koshi'        => array( 'label' => 'कोशी',        'slug' => 'provincial_koshi' ),
        'madhesh'      => array( 'label' => 'मधेश',        'slug' => 'provincial_madhesh' ),
        'bagmati'      => array( 'label' => 'बागमती',      'slug' => 'provincial_bagmati' ),
        'gandaki'      => array( 'label' => 'गण्डकी',      'slug' => 'provincial_gandaki' ),
        'lumbini'      => array( 'label' => 'लुम्बिनी',    'slug' => 'provincial_lumbini' ),
        'karnali'      => array( 'label' => 'कर्णाली',     'slug' => 'provincial_karnali' ),
        'sudurpaschim' => array( 'label' => 'सुदूरपश्चिम', 'slug' => 'provincial_sudurpaschim' ),
    ),
) );

nyt_render_band( array(
'label' => 'अर्थ',
'cat'   => 'business',
'link'  => home_url( '/artha/' ),
) );
nyt_render_band_mixed( array(
'label'           => 'विचार',
'link'            => home_url( '/opinino/' ),
'primary_cat'     => 'opinion',
'primary_count'   => 3,
'secondary_cat'   => 'editorial', // सम्पादकीय — adjust slug here if different on your site
'secondary_count' => 1,
'secondary_label' => 'सम्पादकीय',
) );
nyt_render_band_mixed( array(
'label'           => 'कुटनीति',
'link'            => home_url( '/diplomacy/' ),
'primary_cat'     => 'kutniti',
'primary_count'   => 2,
'secondary_cat'   => 'technology',
'secondary_count' => 2,
'secondary_label' => 'सूचना-प्रविधि',
'split'           => 'split-2-2',   // ← यो नयाँ लाइन थप्नुहोस्
) );
nyt_render_intl_split( array(
    'label'         => 'अन्तर्राष्ट्रिय',
    'cat'           => 'international',
    'link'          => home_url( '/international/' ),
    'featured_count'=> 2,   // 2 featured stories (left 30% + center 30%)
    'bullet_count'  => 5,   // 5 headline bullets (right 40%)
) );
nyt_render_band( array(
'label' => 'ABC TV PROGRAMS',
'cat'   => 'abc-video',
'link'  => home_url( '/abc-videos/' ),
) );
nyt_render_band( array(
'label' => 'खेलकुद',
'cat'   => 'sports',
'link'  => home_url( '/sports/' ),
) );

nyt_render_split_feature_grid( array(
    'label'           => 'साहित्य–कला–मनोरञ्जन',
    'link'            => home_url( '/entertainments/' ),
    'primary_cat'     => 'entertainment',
    'primary_count'   => 6,   // 1 featured + 5 bullets
    'secondary_cat'   => 'lifestyle',
    'secondary_count' => 6,   // 1 featured + 5 bullets
    'secondary_label' => 'स्वास्थ्य–जीवनशैली',
) );


?>
<!-- =====================================================
     NEWSLETTER STRIP
===================================================== -->
<div class="nyt-newsletter">
<div>
<h2>ABC Nepal TV न्यूजलेटर</h2>
<p>सबैभन्दा पहिले समाचार पाउनुहोस् — सोझै इमेलमा।</p>
</div>
<div class="nyt-newsletter-form">
<input type="email" placeholder="तपाईंको इमेल ठेगाना">
<button type="button">सदस्य बन्नुहोस्</button>
</div>
</div>
</div><!-- /nyt-wrap -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.nyt-province-section .nyt-ptab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var key     = tab.getAttribute('data-ptab');
            var section = tab.closest('.nyt-province-section');
            section.querySelectorAll('.nyt-ptab').forEach(function (t) { t.classList.remove('active'); });
            section.querySelectorAll('.nyt-province-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            var panel = section.querySelector('.nyt-province-panel[data-ptab="' + key + '"]');
            if (panel) panel.classList.add('active');
        });
    });
});
</script>

<?php get_footer(); ?>