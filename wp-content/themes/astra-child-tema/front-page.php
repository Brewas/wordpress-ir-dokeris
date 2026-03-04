<?php
/**
 * Template Name: Pagrindinis puslapis
 * Description: Custom homepage template
 */

// Kalbos nustatymas
$lang = isset($_POST['language']) ? $_POST['language'] : 'lt';

// Vertimai
$translations = [
    // Hero section
    'hero_title' => [
        'lt' => 'Sveiki atvykę į ' . get_bloginfo('name'),
        'en' => 'Welcome to ' . get_bloginfo('name')
    ],
    'hero_subtitle' => [
        'lt' => 'Kuriame modernius skaitmeninius sprendimus jūsų verslui',
        'en' => 'Creating modern digital solutions for your business'
    ],
    'hero_btn' => [
        'lt' => 'Peržiūrėti paslaugas',
        'en' => 'View services'
    ],
    
    // Features section
    'features_title' => [
        'lt' => 'Kodėl rinktis mus?',
        'en' => 'Why choose us?'
    ],
    'feature_1_title' => [
        'lt' => 'Profesionalumas',
        'en' => 'Professionalism'
    ],
    'feature_1_desc' => [
        'lt' => 'Patyrusi komanda ir aukščiausia kokybė',
        'en' => 'Experienced team and highest quality'
    ],
    'feature_2_title' => [
        'lt' => 'Inovatyvumas',
        'en' => 'Innovation'
    ],
    'feature_2_desc' => [
        'lt' => 'Naujausios technologijos ir sprendimai',
        'en' => 'Latest technologies and solutions'
    ],
    'feature_3_title' => [
        'lt' => 'Palaikymas',
        'en' => 'Support'
    ],
    'feature_3_desc' => [
        'lt' => '24/7 klientų aptarnavimas',
        'en' => '24/7 customer support'
    ],
    
    // Services section
    'services_title' => [
        'lt' => 'Mūsų paslaugos',
        'en' => 'Our Services'
    ],
    'service_1_title' => [
        'lt' => 'Web kūrimas',
        'en' => 'Web Development'
    ],
    'service_2_title' => [
        'lt' => 'Mobilios programėlės',
        'en' => 'Mobile Apps'
    ],
    'service_3_title' => [
        'lt' => 'SEO optimizavimas',
        'en' => 'SEO Optimization'
    ],
    
    // CTA section
    'cta_title' => [
        'lt' => 'Pasiruošę pradėti?',
        'en' => 'Ready to start?'
    ],
    'cta_desc' => [
        'lt' => 'Susisiekite su mumis ir gaukite nemokamą konsultaciją',
        'en' => 'Contact us for a free consultation'
    ],
    'cta_btn' => [
        'lt' => 'Susisiekti',
        'en' => 'Contact Us'
    ]
];

function t($key, $lang, $translations) {
    return isset($translations[$key][$lang]) ? $translations[$key][$lang] : $key;
}

get_header(); ?>

<style>
    :root {
        --primary: #007cba;
        --primary-dark: #005a87;
        --secondary: #f8f9fa;
        --text: #333;
        --text-light: #666;
        --white: #fff;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text);
        line-height: 1.6;
    }

    .home-page {
        overflow-x: hidden;
    }

    /* Language Switcher */
    .lang-switcher {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        background: var(--white);
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .lang-switcher button {
        padding: 8px 15px;
        margin: 0 5px;
        border: 2px solid var(--primary);
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
    }

    .lang-switcher button.active {
        background: var(--primary);
        color: var(--white);
    }

    .lang-switcher button:not(.active) {
        background: var(--white);
        color: var(--primary);
    }

    .lang-switcher button:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,124,186,0.3);
    }

    /* Hero Section */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        padding: 80px 20px;
    }

    .hero-content {
        max-width: 800px;
    }

    .hero h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
        animation: fadeInUp 1s ease;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
        animation: fadeInUp 1s ease 0.2s both;
    }

    .hero-btn {
        display: inline-block;
        padding: 15px 40px;
        background: var(--white);
        color: var(--primary);
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s;
        animation: fadeInUp 1s ease 0.4s both;
    }

    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    /* Features Section */
    .features {
        padding: 80px 20px;
        background: var(--secondary);
    }

    .section-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 50px;
        color: var(--primary);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background: var(--white);
        padding: 40px 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: var(--primary);
    }

    .feature-card p {
        color: var(--text-light);
    }

    /* Services Section */
    .services {
        padding: 80px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .service-card {
        background: var(--white);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .service-image {
        height: 200px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .service-image span {
        font-size: 4rem;
        color: var(--white);
    }

    .service-content {
        padding: 30px;
    }

    .service-content h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: var(--primary);
    }

    .service-content p {
        color: var(--text-light);
        margin-bottom: 20px;
    }

    .service-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .service-link:hover {
        gap: 10px;
    }

    /* CTA Section */
    .cta {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        text-align: center;
        padding: 80px 20px;
    }

    .cta-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .cta h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .cta p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
    }

    .cta-btn {
        display: inline-block;
        padding: 15px 40px;
        background: var(--white);
        color: var(--primary);
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s;
    }

    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }
        
        .hero p {
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .services-grid {
            grid-template-columns: 1fr;
        }
        
        .lang-switcher {
            position: static;
            text-align: center;
            margin-bottom: 20px;
        }
    }
</style>

<div class="home-page">
    
    <!-- Language Switcher -->
    <div class="lang-switcher">
        <form method="post">
            <button type="submit" name="language" value="lt" class="<?php echo $lang == 'lt' ? 'active' : ''; ?>">🇱🇹 LT</button>
            <button type="submit" name="language" value="en" class="<?php echo $lang == 'en' ? 'active' : ''; ?>">🇬🇧 EN</button>
        </form>
    </div>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="fade-in"><?php echo t('hero_title', $lang, $translations); ?></h1>
            <p class="fade-in"><?php echo t('hero_subtitle', $lang, $translations); ?></p>
            <a href="#services" class="hero-btn fade-in"><?php echo t('hero_btn', $lang, $translations); ?></a>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title fade-in"><?php echo t('features_title', $lang, $translations); ?></h2>
        <div class="features-grid">
            <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="feature-card fade-in" style="animation-delay: <?php echo $i * 0.1; ?>s">
                <div class="feature-icon">
                    <?php echo $i == 1 ? '👥' : ($i == 2 ? '💡' : '🔧'); ?>
                </div>
                <h3><?php echo t('feature_' . $i . '_title', $lang, $translations); ?></h3>
                <p><?php echo t('feature_' . $i . '_desc', $lang, $translations); ?></p>
            </div>
            <?php endfor; ?>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services" id="services">
        <h2 class="section-title fade-in"><?php echo t('services_title', $lang, $translations); ?></h2>
        <div class="services-grid">
            <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="service-card fade-in" style="animation-delay: <?php echo $i * 0.1; ?>s">
                <div class="service-image">
                    <span><?php echo $i == 1 ? '🌐' : ($i == 2 ? '📱' : '📈'); ?></span>
                </div>
                <div class="service-content">
                    <h3><?php echo t('service_' . $i . '_title', $lang, $translations); ?></h3>
                    <p><?php echo t('service_' . $i . '_desc', $lang, $translations); ?></p>
                    <a href="#" class="service-link"><?php echo t('read_more', $lang, $translations); ?> →</a>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2 class="fade-in"><?php echo t('cta_title', $lang, $translations); ?></h2>
            <p class="fade-in"><?php echo t('cta_desc', $lang, $translations); ?></p>
            <a href="#" class="cta-btn fade-in"><?php echo t('cta_btn', $lang, $translations); ?></a>
        </div>
    </section>
    
</div>

<?php get_footer(); ?>
