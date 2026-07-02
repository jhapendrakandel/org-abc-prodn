<?php
/* ================================================
   USED BY: Global (all pages) - theme setup
   PURPOSE: Register theme features (title-tag, post-thumbnails, nav menus)
   ================================================ */
// ── Load the News Toggle System ──────────────────────────────
require_once get_template_directory() . '/inc/news-toggles.php';

require_once get_template_directory() . '/inc/advanced-search.php';

require_once get_template_directory() . '/inc/ticker-cpt.php';


/* ================================================
   USED BY: Global (all pages) - theme setup
   PURPOSE: Add theme support for title-tag, post-thumbnails, and register main-menu
   ================================================ */
function abcnepal_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'main-menu' => 'Main Menu'
    ));
}
add_action('after_setup_theme', 'abcnepal_setup');


/* ================================================
   USED BY: page-live-update.php, template_redirect/template_include hooks
   PURPOSE: Check if current request path is /liveupdate or /live-update for custom routing
   ================================================ */
function abcnepal_is_live_update_path() {
    if (is_admin() || empty($_SERVER['REQUEST_URI'])) {
        return false;
    }
    $request_path = trim(wp_parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH), '/');
    $home_path    = trim(wp_parse_url(home_url('/'), PHP_URL_PATH), '/');
    if (!empty($home_path) && 0 === strpos($request_path, $home_path)) {
        $request_path = trim(substr($request_path, strlen($home_path)), '/');
    }
    return in_array($request_path, array('liveupdate', 'live-update'), true);
}


/* ================================================
   USED BY: Global (all pages) - wp_enqueue_scripts
   PURPOSE: Enqueue main style.css and live-update.js for live update pages
   ================================================ */
function abcnepal_styles() {
    wp_enqueue_style(
        'abc-style',
        get_stylesheet_uri(),
        array(),
        time()
    );
    if (is_page_template('page-live-update.php') || is_page(array('liveupdate', 'live-update')) || abcnepal_is_live_update_path()) {
        wp_enqueue_script(
            'abc-live-update',
            get_template_directory_uri() . '/js/live-update.js',
            array('jquery'),
            time(),
            true
        );
        wp_localize_script(
            'abc-live-update',
            'abcLiveUpdate',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('abc_live_update_nonce'),
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'abcnepal_styles');


/* ================================================
   USED BY: Global (all pages) - nav_menu_item_title filter
   PURPOSE: Translate English menu slugs to Nepali labels
   ================================================ */
function abcnepal_translate_menu_title($title) {
    $labels = array(
        'mainnews'      => 'मुख्य समाचार',
        'main news'     => 'मुख्य समाचार',
        'rajneeti'      => 'राजनीति',
        'rajniti'       => 'राजनीति',
        'kutni'         => 'कूटनीति',
        'kutniti'       => 'कूटनीति',
        'artha'         => 'अर्थ',
        'entertainment' => 'मनोरञ्जन',
        'abc_videos'    => 'एबीसी भिडियो',
        'abc videos'    => 'एबीसी भिडियो',
        'english'       => 'अंग्रेजी',
        'international' => 'अन्तर्राष्ट्रिय',
        'opinion'       => 'विचार',
        'economics'     => 'अर्थतन्त्र',
        'sports'        => 'खेलकुद',
        'liveupdate'    => 'लाइभ अपडेट',
        'live update'   => 'लाइभ अपडेट',
        'live updates'  => 'लाइभ अपडेट',
    );
    $key = strtolower(trim(wp_strip_all_tags($title)));
    return isset($labels[$key]) ? $labels[$key] : $title;
}
add_filter('nav_menu_item_title', 'abcnepal_translate_menu_title');


/* ================================================
   USED BY: page-live-update.php (via template_redirect hook)
   PURPOSE: Fix 404 status for live update paths - set is_page/is_singular
   ================================================ */
function abcnepal_live_update_route_status() {
    if (!abcnepal_is_live_update_path()) {
        return;
    }
    global $wp_query;
    if ($wp_query) {
        $wp_query->is_404      = false;
        $wp_query->is_page     = true;
        $wp_query->is_singular = true;
    }
    status_header(200);
}
add_action('template_redirect', 'abcnepal_live_update_route_status', 0);


/* ================================================
   USED BY: page-live-update.php (via template_include hook)
   PURPOSE: Force page-live-update.php template for /liveupdate and /live-update paths
   ================================================ */
function abcnepal_live_update_template_route($template) {
    if (!abcnepal_is_live_update_path()) {
        return $template;
    }
    $live_template = locate_template('page-live-update.php');
    return !empty($live_template) ? $live_template : $template;
}
add_filter('template_include', 'abcnepal_live_update_template_route', 99);


/* ================================================
   USED BY: page-politics.php, page-sports.php, page-entertainment.php,
            page-international.php, page-diplomacy.php, page-economics.php,
            page-english.php, page-opinion.php, page-abc-videos.php,
            page-artha-pahe-php.php, page-rajniti.php, page-kutniti-page-php.php,
            page-abcspecila.php, page-arthabadijaya.php,
            english.php, international.php, economics.php, opinion.php,
            sports.php, Entertainment.php, abc_video.php, single-live-blog.php,
            page-mainnews.php (for config data)
   PURPOSE: Return configuration array for each news section (category, titles, fallback content)
   ================================================ */
function abcnepal_section_config($section) {
    $sections = array(
        'mainnews' => array(
            'category'      => '',
            'breaking'      => 'मुख्य समाचार : राष्ट्रिय राजनीति, अर्थतन्त्र, समाज र खेलकुदका प्रमुख समाचार',
            'section_title' => 'मुख्य समाचार',
            'sidebar_title' => 'ताजा मुख्य समाचार',
            'featured'      => 'सरकारको प्राथमिकतामा सेवा प्रवाह सुधार, नागरिकका मुद्दा केन्द्रमा',
            'excerpt'       => 'नयाँ कार्ययोजनासहित सरकारले प्रशासनिक सुधार, सार्वजनिक सेवा र आर्थिक गतिविधिलाई गति दिने तयारी अघि बढाएको छ।',
            'latest'        => array(
                'संसद बैठकमा जनजीविकाका विषयमा छलफल',
                'स्थानीय तहमा बजेट कार्यान्वयन तीव्र बनाइँदै',
                'मनसुन सक्रिय भएपछि सावधानी अपनाउन आग्रह',
                'स्वास्थ्य संस्थामा सेवा विस्तार गर्ने निर्णय',
                'युवा रोजगारी कार्यक्रमका लागि नयाँ प्रस्ताव',
            ),
            'cards'         => array(
                'पूर्वाधार निर्माणमा ढिलाइ हटाउन निर्देशन',
                'पर्यटन क्षेत्रमा बुकिङ बढेपछि व्यवसायी उत्साहित',
                'शिक्षा क्षेत्रमा डिजिटल प्रणाली विस्तार हुँदै',
                'सार्वजनिक यातायात सुधारका लागि नयाँ मापदण्ड',
                'कृषि उत्पादन बजारसम्म पुर्‍याउन सहकारी सक्रिय',
                'नगर क्षेत्रमा सरसफाइ अभियान सुरु',
            ),
        ),
        'politics' => array(
            'category'      => 'politics',
            'breaking'      => 'राजनीति अपडेट : दलहरूबीच संवाद, संसद र सरकारका पछिल्ला गतिविधि',
            'section_title' => 'राजनीति विशेष',
            'sidebar_title' => 'ताजा राजनीतिक समाचार',
            'featured'      => 'संसदमा नीति प्राथमिकतामाथि बहस, दलहरू आन्तरिक छलफलमा',
            'excerpt'       => 'सत्तापक्ष र प्रतिपक्षबीच संसदीय कार्यसूची, सुशासन र जनसरोकारका विषयमा संवाद बढेको छ।',
            'latest'        => array(
                'दलहरूबीच सहमतिको प्रयास जारी',
                'संसदीय समितिमा विधेयकमाथि छलफल',
                'प्रदेश सरकार पुनर्गठनबारे परामर्श',
                'नेताहरू जनताका मुद्दा केन्द्रमा राख्न आग्रह',
                'स्थानीय तहको समन्वय बैठक सम्पन्न',
            ),
            'cards'         => array(
                'नयाँ राजनीतिक समीकरणबारे शीर्ष नेताहरूको भेट',
                'सुशासनका विषयमा संसदमा प्रश्न उठ्यो',
                'दलहरूको आन्तरिक बैठकमा संगठन सुदृढीकरण छलफल',
                'संविधान कार्यान्वयनका चुनौतीबारे बहस',
                'युवा प्रतिनिधित्व बढाउन राजनीतिक दबाब',
                'प्रदेशसभामा बजेट प्राथमिकतामाथि छलफल',
            ),
        ),
        'kutniti' => array(
            'category'      => 'kutniti',
            'breaking'      => 'कूटनीति अपडेट : छिमेक, सहायता र अन्तर्राष्ट्रिय सम्बन्धका खबर',
            'section_title' => 'कूटनीति विशेष',
            'sidebar_title' => 'ताजा कूटनीति समाचार',
            'featured'      => 'नेपालको विकास साझेदारीमा नयाँ चरण, दूतावासस्तरीय संवाद तीव्र',
            'excerpt'       => 'पूर्वाधार, ऊर्जा र शिक्षा क्षेत्रमा अन्तर्राष्ट्रिय सहकार्य विस्तार गर्न विभिन्न मुलुकसँग छलफल अघि बढेको छ।',
            'latest'        => array(
                'द्विपक्षीय भेटवार्तामा आर्थिक सहकार्य प्राथमिकता',
                'विदेशस्थित नेपाली सेवामा सुधारको तयारी',
                'सीमा क्षेत्रका विषयमा संयुक्त संयन्त्र सक्रिय',
                'विकास साझेदारसँग परियोजना समीक्षा',
                'क्षेत्रीय सम्मेलनमा नेपाली प्रतिनिधिमण्डल सहभागी',
            ),
            'cards'         => array(
                'ऊर्जा व्यापारबारे उच्चस्तरीय छलफल',
                'श्रम गन्तव्य मुलुकसँग नयाँ समझदारीको तयारी',
                'कूटनीतिक नियोगमा सेवा डिजिटल बनाइँदै',
                'अन्तर्राष्ट्रिय मञ्चमा नेपालको जलवायु मुद्दा',
                'विदेशी लगानी आकर्षित गर्न दूतावास सक्रिय',
                'छिमेकी मुलुकसँग यातायात सम्पर्क विस्तार',
            ),
        ),
        'pradesh' => array(
            'category'      => 'pradesh',
            'breaking'      => 'प्रदेश अपडेट : सातै प्रदेशका नीति, विकास र जनसरोकारका खबर',
            'section_title' => 'प्रदेश विशेष',
            'sidebar_title' => 'ताजा प्रदेश समाचार',
            'featured'      => 'प्रदेश सरकारका प्राथमिकतामा सेवा प्रवाह, पूर्वाधार र स्थानीय विकास',
            'excerpt'       => 'प्रदेश तहमा बजेट कार्यान्वयन, सार्वजनिक सेवा र स्थानीय आवश्यकताका विषयमा नयाँ पहल अघि बढाइएको छ।',
            'latest'        => array(
                'प्रदेशसभामा बजेट कार्यान्वयनबारे छलफल',
                'स्थानीय पूर्वाधार निर्माणको अनुगमन तीव्र',
                'स्वास्थ्य सेवा विस्तारका लागि नयाँ योजना',
                'कृषि र रोजगारी कार्यक्रमलाई प्राथमिकता',
                'स्थानीय तहसँग समन्वय बैठक सम्पन्न',
            ),
            'cards'         => array(
                'प्रदेश सडक आयोजना समयमै सम्पन्न गर्न निर्देशन',
                'पर्यटन प्रवर्द्धनका लागि पालिकासँग सहकार्य',
                'विद्यालय सुधार कार्यक्रममा समुदायको सहभागिता',
                'प्रदेश अस्पतालमा सेवा थप गर्ने तयारी',
                'सिँचाइ योजनाबाट किसान लाभान्वित',
                'युवा सीप विकास तालिम सञ्चालन',
            ),
        ),
        'artha' => array(
            'category'      => 'artha',
            'breaking'      => 'अर्थ अपडेट : बजार, बैंकिङ, उद्योग र व्यापारका खबर',
            'section_title' => 'अर्थ विशेष',
            'sidebar_title' => 'ताजा अर्थ समाचार',
            'featured'      => 'लगानी वातावरण सुधारको संकेत, निजी क्षेत्र नयाँ नीतिबाट उत्साहित',
            'excerpt'       => 'बैंकिङ तरलता, ब्याजदर र व्यापारिक गतिविधिमा देखिएको सुधारले बजारमा सकारात्मक अपेक्षा बढाएको छ।',
            'latest'        => array(
                'सेयर बजारमा सामान्य सुधार',
                'बैंकिङ क्षेत्रमा नयाँ निर्देशन लागू',
                'पर्यटन आय बढ्दा व्यवसायी उत्साहित',
                'उद्योगीहरूले कर प्रणाली सरल बनाउन माग गरे',
                'विदेशी मुद्रा सञ्चिति मजबुत हुँदै',
            ),
            'cards'         => array(
                'व्यापार घाटा घटाउन उत्पादनमुखी नीति आवश्यक',
                'साना उद्यमलाई सहुलियत कर्जा विस्तार',
                'निर्यात प्रवर्द्धनका लागि नयाँ योजना',
                'होटल क्षेत्रमा लगानी बढ्ने संकेत',
                'कृषि बजारलाई डिजिटल प्रणालीमा जोड्ने तयारी',
                'बिमा क्षेत्रमा ग्राहक सेवा सुधार अभियान',
            ),
        ),
        'entertainment' => array(
            'category'      => 'entertainment',
            'breaking'      => 'मनोरञ्जन अपडेट : चलचित्र, संगीत, कला र सेलिब्रेटी खबर',
            'section_title' => 'मनोरञ्जन विशेष',
            'sidebar_title' => 'ताजा मनोरञ्जन समाचार',
            'featured'      => 'नयाँ नेपाली चलचित्रको घोषणा, युवा कलाकार मुख्य भूमिकामा',
            'excerpt'       => 'नेपाली चलचित्र उद्योगमा नयाँ कथावस्तु र डिजिटल प्रविधिको प्रयोग बढ्दै जाँदा दर्शकको चासो पनि बढेको छ।',
            'latest'        => array(
                'गायकको नयाँ गीत सार्वजनिक',
                'चलचित्र महोत्सवमा नेपाली फिल्म छनोट',
                'रंगमञ्चमा नयाँ नाटक मञ्चन हुँदै',
                'कलाकारहरूले सामाजिक अभियानमा सहभागिता जनाए',
                'वेब सिरिज निर्माणमा युवा टोली सक्रिय',
            ),
            'cards'         => array(
                'लोकगीतमा नयाँ पुस्ताको आकर्षण बढ्दै',
                'फिल्म छायांकनका लागि पोखरा रोजाइमा',
                'संगीत भिडियोमा डिजिटल प्लेटफर्मको प्रभाव',
                'कलाकार संघले सम्मान कार्यक्रम गर्ने',
                'सांस्कृतिक कार्यक्रमका लागि तयारी पूरा',
                'सिनेमा हलमा दर्शक फर्किन थाले',
            ),
        ),
        'abc_video' => array(
            'category'      => 'abc-video',
            'breaking'      => 'एबीसी भिडियो अपडेट : अन्तर्वार्ता, रिपोर्ट र विशेष भिडियो',
            'section_title' => 'एबीसी भिडियो विशेष',
            'sidebar_title' => 'ताजा भिडियो',
            'featured'      => 'विशेष संवाद : समसामयिक राजनीतिबारे विस्तृत कुराकानी',
            'excerpt'       => 'एबीसी नेपाल टिभीको भिडियो खण्डमा प्रमुख समाचार, विश्लेषण र जनसरोकारका विषयलाई दृश्य सामग्रीमार्फत प्रस्तुत गरिएको छ।',
            'latest'        => array(
                'आजको मुख्य समाचार भिडियो',
                'अर्थतन्त्रबारे विशेषज्ञसँग कुराकानी',
                'प्रदेश विशेष रिपोर्ट प्रसारण',
                'युवा उद्यमीको सफलताको कथा',
                'अन्तर्राष्ट्रिय घटनाक्रमको भिडियो विश्लेषण',
            ),
            'cards'         => array(
                'स्टुडियो बहस : सुशासन र सेवा प्रवाह',
                'मैदानबाट रिपोर्ट : किसानका समस्या',
                'विशेष अन्तर्वार्ता : नीति र नेतृत्व',
                'भिडियो रिपोर्ट : बजारको पछिल्लो अवस्था',
                'जनआवाज : नागरिकका अपेक्षा',
                'साप्ताहिक समीक्षा : सात दिनका मुख्य घटना',
            ),
        ),
        'english' => array(
            'category'      => 'english',
            'breaking'      => 'अंग्रेजी संस्करण अपडेट : नेपालका प्रमुख खबरको संक्षिप्त प्रस्तुति',
            'section_title' => 'अंग्रेजी संस्करण विशेष',
            'sidebar_title' => 'ताजा अंग्रेजी संस्करण',
            'featured'      => 'नेपालका मुख्य घटनाक्रम अन्तर्राष्ट्रिय पाठकका लागि प्रस्तुत',
            'excerpt'       => 'अंग्रेजी संस्करणले राजनीति, अर्थतन्त्र, समाज र कूटनीतिका प्रमुख नेपाली खबरलाई विश्वव्यापी पाठकसम्म पुर्‍याउने लक्ष्य राखेको छ।',
            'latest'        => array(
                'सरकारी प्राथमिकताबारे संक्षिप्त रिपोर्ट',
                'बजार र व्यापार गतिविधिको अपडेट',
                'पर्यटन क्षेत्रमा सुधारको संकेत',
                'कूटनीतिक भेटवार्ताको सार',
                'खेलकुद उपलब्धिबारे छोटो समाचार',
            ),
            'cards'         => array(
                'नेपालको अर्थतन्त्रबारे तथ्यसहित विश्लेषण',
                'नयाँ नीतिले लगानीकर्तालाई दिएको संकेत',
                'स्थानीय शासनमा देखिएका परिवर्तन',
                'जलवायु मुद्दामा नेपालको आवाज',
                'पर्यटन गन्तव्यको अन्तर्राष्ट्रिय प्रचार',
                'खेलकुदमा नेपाली टोलीको तयारी',
            ),
        ),
        'international' => array(
            'category'      => 'international',
            'breaking'      => 'अन्तर्राष्ट्रिय अपडेट : विश्व राजनीति, अर्थतन्त्र र दक्षिण एसियाका खबर',
            'section_title' => 'अन्तर्राष्ट्रिय विशेष',
            'sidebar_title' => 'ताजा अन्तर्राष्ट्रिय समाचार',
            'featured'      => 'दक्षिण एसियाली क्षेत्रमा आर्थिक सहकार्यबारे नयाँ छलफल',
            'excerpt'       => 'क्षेत्रीय राजनीति, व्यापार र सुरक्षा विषयमा भइरहेका परिवर्तनले नेपालसहित दक्षिण एसियाका मुलुकमा प्रभाव पार्ने देखिएको छ।',
            'latest'        => array(
                'विश्व बजारमा ऊर्जा मूल्यमा उतारचढाव',
                'क्षेत्रीय सम्मेलनमा आर्थिक मुद्दा प्राथमिकता',
                'प्रविधि क्षेत्रमा नयाँ नियम लागू',
                'जलवायु परिवर्तनबारे राष्ट्रहरूको प्रतिबद्धता',
                'अन्तर्राष्ट्रिय सहायता कार्यक्रम विस्तार',
            ),
            'cards'         => array(
                'विश्व अर्थतन्त्रमा सुस्त सुधारको संकेत',
                'छिमेकी मुलुकमा निर्वाचन तयारी तीव्र',
                'समुद्री व्यापार मार्गमा नयाँ चुनौती',
                'श्रम बजारमा प्रवासी कामदारको माग बढ्दै',
                'शिक्षा र अनुसन्धानमा अन्तर्राष्ट्रिय सहकार्य',
                'स्वास्थ्य सुरक्षा प्रणाली बलियो बनाउने प्रयास',
            ),
        ),
        'opinion' => array(
            'category'      => 'opinion',
            'breaking'      => 'विचार अपडेट : विश्लेषण, टिप्पणी र सम्पादकीय दृष्टिकोण',
            'section_title' => 'विचार विशेष',
            'sidebar_title' => 'ताजा विचार',
            'featured'      => 'सुशासनको बहस कागजमा होइन, नागरिकको सेवामा देखिनुपर्छ',
            'excerpt'       => 'राजनीतिक प्रतिबद्धता, प्रशासनिक क्षमता र नागरिक निगरानी एकसाथ अघि बढे मात्रै सार्वजनिक सेवा प्रभावकारी बन्न सक्छ।',
            'latest'        => array(
                'युवाको सहभागिता किन आवश्यक छ?',
                'अर्थतन्त्र सुधारका लागि नीतिगत स्थिरता',
                'स्थानीय सरकारको जवाफदेहिता बढाउने उपाय',
                'शिक्षामा गुणस्तरको बहस',
                'जलवायु संकट र हाम्रो तयारी',
            ),
            'cards'         => array(
                'लोकतन्त्र बलियो बनाउन संस्थागत सुधार',
                'मिडियाको जिम्मेवारी र सार्वजनिक विश्वास',
                'शहर विकासमा दीर्घकालीन सोचको खाँचो',
                'स्वास्थ्य सेवामा नागरिकमैत्री प्रणाली',
                'उद्यमशीलता बढाउन नीतिको भूमिका',
                'कृषि क्षेत्रमा बजार पहुँचको चुनौती',
            ),
        ),
        'literature' => array(
            'category'      => 'literature',
            'breaking'      => 'साहित्य अपडेट : कथा, कविता, समीक्षा र सांस्कृतिक लेखन',
            'section_title' => 'साहित्य विशेष',
            'sidebar_title' => 'ताजा साहित्य',
            'featured'      => 'नयाँ पुस्ताको लेखनमा समाज, स्मृति र परिवर्तनका स्वर',
            'excerpt'       => 'साहित्य खण्डमा कथा, कविता, निबन्ध, पुस्तक समीक्षा र सांस्कृतिक विमर्शलाई समेटिएको छ।',
            'latest'        => array(
                'नयाँ कविता संग्रह सार्वजनिक',
                'कथामा समकालीन समाजको चित्रण',
                'पुस्तक समीक्षामा नयाँ बहस',
                'साहित्यिक गोष्ठी सम्पन्न',
                'युवा लेखकहरूको सिर्जना प्रकाशित',
            ),
            'cards'         => array(
                'स्मृति र शहरबारे नयाँ निबन्ध',
                'लोक संस्कृतिको संरक्षणमा साहित्यको भूमिका',
                'कवितामा नयाँ शैलीको प्रयोग',
                'बालसाहित्यमा पाठकको रुचि बढ्दै',
                'लेखन कार्यशालामा युवा सहभागिता',
                'अनुवाद साहित्यको विस्तार आवश्यक',
            ),
        ),
        'economics' => array(
            'category'      => 'economics',
            'breaking'      => 'अर्थतन्त्र अपडेट : उत्पादन, रोजगारी, बजार र नीतिका मुख्य खबर',
            'section_title' => 'अर्थतन्त्र विशेष',
            'sidebar_title' => 'ताजा अर्थतन्त्र समाचार',
            'featured'      => 'उत्पादन र रोजगारी बढाउने नीतिमा विज्ञहरूको जोड',
            'excerpt'       => 'आयात निर्भरता घटाउँदै स्थानीय उत्पादन, सीप विकास र वित्तीय पहुँच विस्तार गर्नुपर्ने आवाज बलियो बन्दै गएको छ।',
            'latest'        => array(
                'रोजगारी सिर्जनाका लागि नयाँ कार्यक्रम प्रस्ताव',
                'कृषि उत्पादनको बजार मूल्यमा सुधार',
                'साना उद्योगलाई प्रविधि सहयोग आवश्यक',
                'विकास खर्च बढाउन मन्त्रालयहरू सक्रिय',
                'नीतिगत स्थिरता माग्दै निजी क्षेत्र',
            ),
            'cards'         => array(
                'स्थानीय उत्पादन प्रवर्द्धनमा पालिकाको भूमिका',
                'ऊर्जा क्षेत्रमा लगानी बढ्दा अर्थतन्त्रलाई टेवा',
                'पूर्वाधार परियोजनाले रोजगारी सिर्जना गर्ने अपेक्षा',
                'डिजिटल भुक्तानीले कारोबार पारदर्शी बनाउँदै',
                'कृषि बीमामा किसानको आकर्षण बढ्दै',
                'आन्तरिक पर्यटनबाट स्थानीय अर्थतन्त्र चलायमान',
            ),
        ),
        'sports' => array(
            'category'      => 'sports',
            'breaking'      => 'खेलकुद अपडेट : क्रिकेट, फुटबल र राष्ट्रिय खेलका खबर',
            'section_title' => 'खेलकुद विशेष',
            'sidebar_title' => 'ताजा खेलकुद समाचार',
            'featured'      => 'नेपाली टोलीको तयारी तीव्र, आगामी प्रतियोगितामा राम्रो नतिजाको लक्ष्य',
            'excerpt'       => 'प्रशिक्षक टोलीले फिटनेस, रणनीति र युवा खेलाडीको भूमिकालाई केन्द्रमा राखेर अभ्यास अघि बढाएको छ।',
            'latest'        => array(
                'क्रिकेट टोलीको बन्द प्रशिक्षण सुरु',
                'फुटबल लिगको तालिका सार्वजनिक',
                'एथलेटिक्समा नयाँ राष्ट्रिय कीर्तिमान',
                'युवा खेलाडी छनोट प्रक्रिया अघि बढ्यो',
                'विद्यालयस्तरीय प्रतियोगिता आयोजना हुँदै',
            ),
            'cards'         => array(
                'नेपालले मैत्रीपूर्ण खेलमा जित निकाल्यो',
                'महिला टोलीको प्रदर्शनमा प्रशिक्षक सन्तुष्ट',
                'खेल पूर्वाधार सुधार गर्न बजेट माग',
                'स्थानीय क्लबहरू लिगका लागि तयारीमा',
                'मार्शल आर्ट्स खेलाडी अन्तर्राष्ट्रिय प्रतियोगितामा',
                'ग्रासरुट फुटबल कार्यक्रम विस्तार हुँदै',
            ),
        ),
    );
    return isset($sections[$section]) ? $sections[$section] : $sections['mainnews'];
}


/* ================================================
   USED BY: page-mainnews.php (2 calls), functions.php abcnepal_render_news_section (3 calls)
   PURPOSE: Render placeholder image from picsum.photos when post has no thumbnail
   ================================================ */
function abcnepal_render_sample_image($seed, $size = 'large') {
    $dimensions = 'large' === $size ? '900/500' : '500/320';
    printf(
        '<img src="%s" alt="">',
        esc_url('https://picsum.photos/' . $dimensions . '?random=' . absint($seed))
    );
}


/* ================================================
   USED BY: page-politics.php, page-sports.php, page-entertainment.php,
            page-international.php, page-diplomacy.php, page-economics.php,
            page-english.php, page-opinion.php, page-abc-videos.php,
            page-artha-pahe-php.php, page-rajniti.php, page-kutniti-page-php.php,
            page-abcspecila.php, page-arthabadijaya.php,
            english.php, international.php, economics.php, opinion.php,
            sports.php, Entertainment.php, abc_video.php, single-live-blog.php
   PURPOSE: Render complete news section layout (breaking banner, hero, sidebar, grid, ad)
   ================================================ */
function abcnepal_render_news_section($section) {
    $config      = abcnepal_section_config($section);
    $category    = $config['category'];
    $query_args  = array('posts_per_page' => 9);
    if (!empty($category)) {
        $query_args['category_name'] = $category;
    }
    $news_query = new WP_Query($query_args);
    $posts      = $news_query->posts;
    ?>
    <main class="container news-section news-section-<?php echo esc_attr($section); ?>">
        <div class="breaking-news">
            <span><?php echo esc_html($config['breaking']); ?></span>
        </div>

        <h1 class="main-headline">
            <?php
            if (!empty($posts)) {
                echo esc_html(get_the_title($posts[0]));
            } else {
                echo esc_html($config['featured']);
            }
            ?>
        </h1>

        <div class="news-grid">
            <article class="main-news">
                <?php if (!empty($posts)) : ?>
                    <a href="<?php echo esc_url(get_permalink($posts[0])); ?>">
                        <?php
                        if (has_post_thumbnail($posts[0])) {
                            echo get_the_post_thumbnail($posts[0], 'large');
                        } else {
                            abcnepal_render_sample_image(crc32($section . 'featured'));
                        }
                        ?>
                    </a>
                    <p class="featured-excerpt">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt($posts[0]), 32)); ?>
                    </p>
                <?php else : ?>
                    <?php abcnepal_render_sample_image(crc32($section . 'featured')); ?>
                    <p class="featured-excerpt"><?php echo esc_html($config['excerpt']); ?></p>
                <?php endif; ?>
            </article>

            <aside class="side-news">
                <h3><?php echo esc_html($config['sidebar_title']); ?></h3>
                <ul>
                    <?php
                    $latest_posts  = array_slice($posts, 1, 5);
                    if (!empty($latest_posts)) :
                        foreach ($latest_posts as $post_item) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_permalink($post_item)); ?>">
                                    <?php echo esc_html(get_the_title($post_item)); ?>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    $latest_needed = 5 - count($latest_posts);
                    if ($latest_needed > 0) :
                        foreach (array_slice($config['latest'], 0, $latest_needed) as $headline) :
                            ?>
                            <li><?php echo esc_html($headline); ?></li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </aside>
        </div>

        <div class="category-section">
            <h2><?php echo esc_html($config['section_title']); ?></h2>
            <div class="category-grid">
                <?php
                $grid_posts = array_slice($posts, 0, 8);
                if (!empty($grid_posts)) :
                    foreach ($grid_posts as $index => $post_item) :
                        ?>
                        <article>
                            <a href="<?php echo esc_url(get_permalink($post_item)); ?>">
                                <?php
                                if (has_post_thumbnail($post_item)) {
                                    echo get_the_post_thumbnail($post_item, 'medium');
                                } else {
                                    abcnepal_render_sample_image(crc32($section . $index), 'medium');
                                }
                                ?>
                                <h3><?php echo esc_html(get_the_title($post_item)); ?></h3>
                            </a>
                        </article>
                        <?php
                    endforeach;
                endif;
                $grid_needed = max(0, 6 - count($grid_posts));
                if ($grid_needed > 0) :
                    foreach (array_slice($config['cards'], 0, $grid_needed) as $index => $headline) :
                        ?>
                        <article>
                            <?php abcnepal_render_sample_image(crc32($section . 'sample' . $index), 'medium'); ?>
                            <h3><?php echo esc_html($headline); ?></h3>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <div class="ad-slot">
            <img src="<?php echo esc_url('https://picsum.photos/1200/150?random=' . absint(crc32($section . 'ad'))); ?>" class="ad-image" alt="">
        </div>
    </main>
    <?php
    wp_reset_postdata();
}


// =============================================
// LIVE BLOG / LIVE UPDATES SYSTEM
// =============================================

/* ================================================
   USED BY: page-live-update.php, single-live-blog.php, live_update CPT
   PURPOSE: Register 'live_update' custom post type for live blog updates
   ================================================ */
function register_live_update_cpt() {
    register_post_type('live_update', array(
        'labels'       => array(
            'name'          => 'Live Updates',
            'singular_name' => 'Live Update',
            'menu_name'     => 'Live Updates',
            'add_new'       => 'Add Update',
            'add_new_item'  => 'Add New Live Update',
            'edit_item'     => 'Edit Live Update',
        ),
        'public'       => true,
        'supports'     => array('title', 'editor', 'thumbnail', 'author', 'excerpt'),
        'menu_icon'    => 'dashicons-rss',
        'has_archive'  => false,
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_live_update_cpt');


// ── Admin: Custom Columns ─────────────────────────────────────

/* ================================================
   USED BY: WP Admin - live_update post list table
   PURPOSE: Add custom columns (Reporter, Posted, Time Ago) for live_update CPT
   ================================================ */
function abcnepal_live_update_admin_columns($columns) {
    unset($columns['date']);
    $columns['live_author']   = 'Reporter';
    $columns['live_posted']   = 'Posted';
    $columns['live_time_ago'] = 'Time Ago';
    return $columns;
}
add_filter('manage_live_update_posts_columns', 'abcnepal_live_update_admin_columns');

/* ================================================
   USED BY: WP Admin - live_update post list table
   PURPOSE: Render content for custom live_update columns
   ================================================ */
function abcnepal_live_update_column_content($column, $post_id) {
    switch ($column) {
        case 'live_author':
            $author_id = get_post_field('post_author', $post_id);
            $name      = get_the_author_meta('display_name', $author_id);
            $avatar    = get_avatar($author_id, 28);
            $edit_url  = esc_url(get_edit_user_link($author_id));
            echo '<div style="display:flex;align-items:center;gap:6px;">';
            echo $avatar;
            echo '<a href="' . $edit_url . '">' . esc_html($name) . '</a>';
            echo '</div>';
            break;
        case 'live_posted':
            $time = get_post_time('U', false, $post_id);
            echo '<abbr title="' . esc_attr(get_post_time('Y-m-d H:i:s', false, $post_id)) . '">';
            echo esc_html(date_i18n('j M Y, H:i', $time));
            echo '</abbr>';
            break;
        case 'live_time_ago':
            $time        = get_post_time('U', false, $post_id);
            $minutes_ago = (current_time('timestamp') - $time) / 60;
            $diff        = human_time_diff($time, current_time('timestamp'));
            if ($minutes_ago < 10) {
                $colour = '#dc2626'; $label = 'Just now';
            } elseif ($minutes_ago < 60) {
                $colour = '#d97706'; $label = $diff . ' ago';
            } else {
                $colour = '#6b7280'; $label = $diff . ' ago';
            }
            echo '<span style="color:' . $colour . ';font-weight:600;">' . esc_html($label) . '</span>';
            break;
    }
}
add_action('manage_live_update_posts_custom_column', 'abcnepal_live_update_column_content', 10, 2);

/* ================================================
   USED BY: WP Admin - live_update post list table
   PURPOSE: Make 'Posted' column sortable by date
   ================================================ */
function abcnepal_live_update_sortable_columns($columns) {
    $columns['live_posted'] = 'date';
    return $columns;
}
add_filter('manage_edit-live_update_sortable_columns', 'abcnepal_live_update_sortable_columns');


// ── Admin: Quick Publish Box ──────────────────────────────────

/* ================================================
   USED BY: WP Admin - live_update edit.php screen
   PURPOSE: Show quick publish UI for live updates in admin
   ================================================ */
function abcnepal_live_update_quick_publish() {
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'live_update' || $screen->base !== 'edit') {
        return;
    }
    ?>
    <style>
        #lqp-wrap {
            background:#fff; border:1px solid #c3c4c7;
            border-left:4px solid #dc2626; border-radius:4px;
            padding:16px 20px; margin:16px 0;
        }
        #lqp-wrap h2 {
            margin:0 0 12px; font-size:14px; color:#dc2626;
            display:flex; align-items:center; gap:6px;
        }
        #lqp-wrap h2::before { content:'●'; animation:lqp-blink 1.2s infinite; }
        @keyframes lqp-blink { 0%,100%{opacity:1} 50%{opacity:.3} }
        #lqp-wrap .lqp-row { display:flex; gap:8px; flex-wrap:wrap; }
        #lqp-title {
            flex:1; min-width:240px; padding:8px 10px;
            font-size:13px; border:1px solid #c3c4c7; border-radius:3px;
        }
        #lqp-body {
            width:100%; margin:8px 0; padding:8px 10px;
            font-size:13px; border:1px solid #c3c4c7; border-radius:3px;
            resize:vertical; min-height:60px;
        }
        #lqp-submit {
            background:#dc2626; color:#fff; border:none;
            padding:8px 18px; border-radius:3px;
            cursor:pointer; font-size:13px; font-weight:600;
        }
        #lqp-submit:hover { background:#b91c1c; }
        #lqp-feedback { font-size:12px; margin-top:6px; min-height:18px; }
    </style>
    <div id="lqp-wrap">
        <h2>Quick Live Update</h2>
        <div class="lqp-row">
            <input type="text" id="lqp-title" placeholder="Headline…" />
        </div>
        <textarea id="lqp-body" placeholder="Body (optional)…"></textarea>
        <div class="lqp-row">
            <button id="lqp-submit">Publish Now</button>
        </div>
        <p id="lqp-feedback"></p>
    </div>
    <script>
    document.getElementById('lqp-submit').addEventListener('click', function () {
        var title    = document.getElementById('lqp-title').value.trim();
        var body     = document.getElementById('lqp-body').value.trim();
        var feedback = document.getElementById('lqp-feedback');
        if (!title) { feedback.style.color='#dc2626'; feedback.textContent='Please enter a headline.'; return; }
        feedback.style.color='#6b7280'; feedback.textContent='Publishing…';
        var fd = new FormData();
        fd.append('action',  'abcnepal_lqp_publish');
        fd.append('nonce',   '<?php echo wp_create_nonce('abcnepal_lqp_publish'); ?>');
        fd.append('title',   title);
        fd.append('content', body);
        fetch(ajaxurl, { method:'POST', body:fd, credentials:'same-origin' })
            .then(function(r){ return r.json(); })
            .then(function(res) {
                if (res.success) {
                    feedback.style.color='#16a34a';
                    feedback.textContent='✔ Published at ' + res.data.time;
                    document.getElementById('lqp-title').value = '';
                    document.getElementById('lqp-body').value  = '';
                    setTimeout(function(){ location.reload(); }, 1500);
                } else {
                    feedback.style.color='#dc2626';
                    feedback.textContent = res.data || 'Error publishing.';
                }
            })
            .catch(function(){ feedback.style.color='#dc2626'; feedback.textContent='Network error.'; });
    });
    </script>
    <?php
}
add_action('admin_notices', 'abcnepal_live_update_quick_publish');

/* ================================================
   USED BY: WP Admin - AJAX handler for quick live update publish
   PURPOSE: Handle AJAX request to publish live_update post
   ================================================ */
function abcnepal_lqp_publish_handler() {
    check_ajax_referer('abcnepal_lqp_publish', 'nonce');
    if (!current_user_can('publish_posts')) {
        wp_send_json_error('Insufficient permissions.');
    }
    $title   = isset($_POST['title'])   ? sanitize_text_field($_POST['title']) : '';
    $content = isset($_POST['content']) ? wp_kses_post($_POST['content'])       : '';
    if (empty($title)) {
        wp_send_json_error('Title is required.');
    }
    $id = wp_insert_post(array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'live_update',
        'post_author'  => get_current_user_id(),
    ), true);
    if (is_wp_error($id)) {
        wp_send_json_error($id->get_error_message());
    }
    wp_send_json_success(array('id' => $id, 'time' => date_i18n('H:i', current_time('timestamp'))));
}
add_action('wp_ajax_abcnepal_lqp_publish', 'abcnepal_lqp_publish_handler');


// ── AJAX: Fetch new updates (ID > last_id) ────────────────────

/* ================================================
   USED BY: page-live-update.js (AJAX polling), frontend live updates feed
   PURPOSE: AJAX endpoint to fetch new live_update posts since last_id
   ================================================ */
function abcnepal_get_live_updates() {
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'abc_live_updates_nonce')) {
        wp_send_json(array('success' => false));
    }
    $last_id = isset($_GET['last_id']) ? absint($_GET['last_id']) : 0;
    if ($last_id > 0) {
        add_filter('posts_where', function ($where) use ($last_id) {
            global $wpdb;
            $where .= $wpdb->prepare(' AND ' . $wpdb->posts . '.ID > %d', $last_id);
            return $where;
        });
    }
    $updates = new WP_Query(array(
        'post_type'      => 'live_update',
        'posts_per_page' => 10,
        'orderby'        => 'ID',
        'order'          => 'DESC',
    ));
    remove_all_filters('posts_where');
    $html  = '';
    $count = 0;
    if ($updates->have_posts()) {
        ob_start();
        while ($updates->have_posts()) {
            $updates->the_post();
            $post_id       = get_the_ID();
            $author_id     = get_post_field('post_author', $post_id);
            $author_name   = get_the_author_meta('display_name', $author_id);
            $author_avatar = get_avatar_url($author_id, array('size' => 48));
            $post_time     = get_post_time('U');
            $iso_time      = get_post_time('c');
            $display_time  = get_post_time('H:i');
            $word_count    = str_word_count(wp_strip_all_tags(get_the_content()));
            ?>
            <div class="update-entry" data-id="<?php echo esc_attr($post_id); ?>">
                <div class="update-header">
                    <?php if ($author_avatar) : ?>
                        <img src="<?php echo esc_url($author_avatar); ?>"
                             alt="<?php echo esc_attr($author_name); ?>"
                             class="author-avatar">
                    <?php endif; ?>
                    <div class="update-meta">
                        <span class="author-name"><?php echo esc_html($author_name); ?></span>
                        <time class="time-ago"
                              datetime="<?php echo esc_attr($iso_time); ?>"
                              data-timestamp="<?php echo esc_attr($post_time); ?>">
                            just now
                        </time>
                    </div>
                    <span class="update-clock"><?php echo esc_html($display_time); ?></span>
                </div>
                <h3 class="update-title"><?php the_title(); ?></h3>
                <div class="update-content">
                    <?php the_content(); ?>
                </div>
                <?php if ($word_count > 40) : ?>
                    <button class="show-more-btn" aria-expanded="false">Show more</button>
                <?php endif; ?>
            </div>
            <?php
            $count++;
        }
        $html = ob_get_clean();
        wp_reset_postdata();
    }
    wp_send_json(array('success' => !empty($html), 'html' => $html, 'count' => $count));
}
add_action('wp_ajax_get_live_updates',        'abcnepal_get_live_updates');
add_action('wp_ajax_nopriv_get_live_updates', 'abcnepal_get_live_updates');


// ── Header assets ─────────────────────────────────────────────

/* ================================================
   USED BY: Global (all pages) - wp_enqueue_scripts
   PURPOSE: Enqueue header-nav.css and header-nav.js for navigation/ticker
   ================================================ */
function abc_enqueue_header_assets() {
    wp_enqueue_style(
        'abc-header-nav',
        get_template_directory_uri() . '/header-nav.css',
        array(), '1.0.0'
    );
    wp_enqueue_script(
        'abc-header-nav',
        get_template_directory_uri() . '/header-nav.js',
        array(), '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'abc_enqueue_header_assets');


// ── REST API endpoints for toggle system ──────────────────────

/* ================================================
   USED BY: Frontend JS (if any) consuming REST API for breaking/hero/featured
   PURPOSE: Register REST routes for breaking news, hero post, featured posts
   ================================================ */
add_action('rest_api_init', function () {

    register_rest_route('abcnt/v1', '/breaking', array(
        'methods'             => 'GET',
        'callback'            => function () {
            $post = abcnt_get_breaking_post();
            if (!$post) return new WP_REST_Response(null, 204);
            return array(
                'id'        => $post->ID,
                'title'     => get_the_title($post->ID),
                'permalink' => get_permalink($post->ID),
                'excerpt'   => wp_trim_words(get_the_excerpt($post->ID), 40),
                'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium_large'),
                'date'      => get_the_date('c', $post->ID),
            );
        },
        'permission_callback' => '__return_true',
    ));

    register_rest_route('abcnt/v1', '/hero', array(
        'methods'             => 'GET',
        'callback'            => function () {
            $post = abcnt_get_hero_post();
            if (!$post) return new WP_REST_Response(null, 204);
            return array(
                'id'        => $post->ID,
                'title'     => get_the_title($post->ID),
                'permalink' => get_permalink($post->ID),
                'excerpt'   => wp_trim_words(get_the_excerpt($post->ID), 40),
                'thumbnail' => get_the_post_thumbnail_url($post->ID, 'large'),
                'date'      => get_the_date('c', $post->ID),
            );
        },
        'permission_callback' => '__return_true',
    ));

    register_rest_route('abcnt/v1', '/featured', array(
        'methods'             => 'GET',
        'callback'            => function ($req) {
            $limit = (int) $req->get_param('limit') ?: 5;
            $limit = min($limit, 20);
            $posts = abcnt_get_featured_posts($limit);
            return array_map(function ($post) {
                return array(
                    'id'        => $post->ID,
                    'title'     => get_the_title($post->ID),
                    'permalink' => get_permalink($post->ID),
                    'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium_large'),
                    'date'      => get_the_date('c', $post->ID),
                );
            }, $posts);
        },
        'permission_callback' => '__return_true',
    ));

});


/* ══════════════════════════════════════════════════════
   BREAKING NEWS — ADMIN BAR + QUICK CLEAR
   (news-toggles.php handles the meta box itself)
══════════════════════════════════════════════════════ */

/* ================================================
   USED BY: WP Admin - admin_bar_menu (admin only)
   PURPOSE: Add breaking news indicator to admin bar with per-post remove links
   ================================================ */
/**
 * Admin bar: show count of active breaking posts + per-post remove links
 */
function abcnt_breaking_admin_bar_node( $wp_admin_bar ) {
    if ( ! current_user_can( 'edit_posts' ) ) return;

    $breaking = abcnt_get_breaking_posts( 5 );
    $count    = count( $breaking );

    if ( $count > 0 ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'abcnt-breaking-indicator',
            'title' => '🔴 Breaking Active: ' . $count . '/5',
            'href'  => admin_url( 'edit.php?meta_key=_abcnt_breaking&meta_value=1' ),
            'meta'  => array( 'title' => 'View all breaking posts' ),
        ) );
        foreach ( $breaking as $bp ) {
            $wp_admin_bar->add_node( array(
                'id'     => 'abcnt-breaking-post-' . $bp->ID,
                'parent' => 'abcnt-breaking-indicator',
                'title'  => '📰 ' . wp_trim_words( $bp->post_title, 6 ),
                'href'   => get_edit_post_link( $bp->ID ),
            ) );
            $wp_admin_bar->add_node( array(
                'id'     => 'abcnt-breaking-clear-' . $bp->ID,
                'parent' => 'abcnt-breaking-post-' . $bp->ID,
                'title'  => '✕ Remove from Breaking',
                'href'   => wp_nonce_url(
                    add_query_arg( array(
                        'abcnt_clear_breaking' => '1',
                        'post_id'              => $bp->ID,
                    ) ),
                    'abcnt_clear_breaking'
                ),
            ) );
        }
    } else {
        $wp_admin_bar->add_node( array(
            'id'    => 'abcnt-breaking-indicator',
            'title' => '⚪ No Breaking News Set',
            'href'  => admin_url( 'edit.php' ),
        ) );
    }
}
add_action( 'admin_bar_menu', 'abcnt_breaking_admin_bar_node', 999 );

/* ================================================
   USED BY: WP Admin - admin_init (admin only)
   PURPOSE: Handle quick-clear breaking news from admin bar link
   ================================================ */
/**
 * Handle quick-clear from admin bar
 */
function abcnt_handle_clear_breaking() {
    if (
        ! isset( $_GET['abcnt_clear_breaking'] ) ||
        ! isset( $_GET['post_id'] ) ||
        ! wp_verify_nonce( $_GET['_wpnonce'], 'abcnt_clear_breaking' ) ||
        ! current_user_can( 'edit_posts' )
    ) return;

    delete_post_meta( absint( $_GET['post_id'] ), '_abcnt_breaking' );
    wp_redirect( remove_query_arg( array( 'abcnt_clear_breaking', 'post_id', '_wpnonce' ) ) );
    exit;
}
add_action( 'admin_init', 'abcnt_handle_clear_breaking' );