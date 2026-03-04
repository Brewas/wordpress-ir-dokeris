<?php
/**
 * Template Name: Verčiamas puslapis
 */

// Kalbos nustatymas
$lang = isset($_POST['language']) ? $_POST['language'] : 'lt';

// Vertimai
$translations = [
    'our_services' => [
        'lt' => 'Mūsų paslaugos',
        'en' => 'Our Services'
    ],
    'service_1_title' => [
        'lt' => 'Internetinių svetainių kūrimas',
        'en' => 'Web Development'
    ],
    'service_1_desc' => [
        'lt' => 'Modernios, greitos ir responsive svetainės',
        'en' => 'Modern, fast and responsive websites'
    ],
    'service_2_title' => [
        'lt' => 'Mobiliosios programėlės',
        'en' => 'Mobile Apps'
    ],
    'service_2_desc' => [
        'lt' => 'Native ir cross-platform programėlės',
        'en' => 'Native and cross-platform apps'
    ],
    'read_more' => [
        'lt' => 'Skaityti daugiau',
        'en' => 'Read More'
    ],
    'contact' => [
        'lt' => 'Susisiekite',
        'en' => 'Contact Us'
    ]
];

function t($key, $lang, $translations) {
    return isset($translations[$key][$lang]) ? $translations[$key][$lang] : $key;
}

get_header();
?>

<div class="custom-page-container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    <!-- Language Switcher -->
    <div style="text-align: right; margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <form method="post" style="display: inline;">
            <button type="submit" name="language" value="lt" style="padding: 10px 20px; margin: 0 5px; border: 2px solid <?php echo $lang == 'lt' ? '#007cba' : '#ddd'; ?>; background: <?php echo $lang == 'lt' ? '#007cba' : 'white'; ?>; color: <?php echo $lang == 'lt' ? 'white' : '#333'; ?>; border-radius: 5px; cursor: pointer;">
                🇱🇹 Lietuviškai
            </button>
            <button type="submit" name="language" value="en" style="padding: 10px 20px; margin: 0 5px; border: 2px solid <?php echo $lang == 'en' ? '#007cba' : '#ddd'; ?>; background: <?php echo $lang == 'en' ? '#007cba' : 'white'; ?>; color: <?php echo $lang == 'en' ? 'white' : '#333'; ?>; border-radius: 5px; cursor: pointer;">
                🇬🇧 English
            </button>
        </form>
    </div>
    
    <!-- Contact Button -->
    <div style="text-align: center; margin: 40px 0;">
        <a href="#" style="display: inline-block; padding: 15px 40px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; font-size: 18px;">
            <?php echo t('contact', $lang, $translations); ?>
        </a>
    </div>
    
    <!-- Services Title -->
    <h1 style="text-align: center; font-size: 48px; margin: 50px 0 30px;">
        <?php echo t('our_services', $lang, $translations); ?>
    </h1>
    
    <!-- Services Grid -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; margin: 40px 0;">
        
        <!-- Service 1 -->
        <div style="background: white; border: 1px solid #eee; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h2 style="color: #007cba; margin-top: 0;"><?php echo t('service_1_title', $lang, $translations); ?></h2>
            <p style="line-height: 1.6; color: #666;"><?php echo t('service_1_desc', $lang, $translations); ?></p>
            <a href="#" style="display: inline-block; margin-top: 15px; color: #007cba; text-decoration: none; font-weight: bold;">
                <?php echo t('read_more', $lang, $translations); ?> →
            </a>
        </div>
        
        <!-- Service 2 -->
        <div style="background: white; border: 1px solid #eee; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h2 style="color: #007cba; margin-top: 0;"><?php echo t('service_2_title', $lang, $translations); ?></h2>
            <p style="line-height: 1.6; color: #666;"><?php echo t('service_2_desc', $lang, $translations); ?></p>
            <a href="#" style="display: inline-block; margin-top: 15px; color: #007cba; text-decoration: none; font-weight: bold;">
                <?php echo t('read_more', $lang, $translations); ?> →
            </a>
        </div>
        
    </div>
    
</div>

<?php get_footer(); ?>
