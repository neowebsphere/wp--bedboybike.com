<?php
/**
 * The main template file
 *
 * @package BadBoyBike
 */

get_header();
?>

<!-- HERO SECTION WITH PARALLAX -->
<section class="hero" id="home">
    <!-- Parallax Background -->
    <div class="hero__parallax" data-parallax-speed="0.5">
        <div class="hero__background">
            <?php
            $hero_image = get_theme_mod('badboybike_hero_image');
            if ($hero_image) {
                echo '<img src="' . esc_url($hero_image) . '" alt="Custom Harley-Davidson motorcycle" class="hero__bg-image">';
            } else {
                // Check if default hero image exists
                $default_hero_jpg = get_template_directory() . '/images/hero-bike.jpg';
                $default_hero_fallback = get_template_directory() . '/images/default-hero.jpg';
                
                if (file_exists($default_hero_jpg)) {
                    echo '<img src="' . get_template_directory_uri() . '/images/hero-bike.jpg" alt="Custom Harley-Davidson motorcycle" class="hero__bg-image">';
                } elseif (file_exists($default_hero_fallback)) {
                    echo '<img src="' . get_template_directory_uri() . '/images/default-hero.jpg" alt="Custom Harley-Davidson motorcycle" class="hero__bg-image">';
                }
            }
            ?>
        </div>
        <div class="hero__overlay"></div>
    </div>
    
    <!-- Animated Content -->
    <div class="container">
        <div class="hero__content">
            <!-- Animated Badge -->
            <div class="hero__badge" data-animate="fade-up" data-delay="200">
                <span class="hero__badge-icon"></span>
                <span class="hero__badge-text">Custom Harley-Davidson</span>
            </div>
            
            <!-- Animated Title -->
            <h1 class="hero__title" data-animate="fade-up" data-delay="400">
                <?php 
                $hero_title = get_theme_mod('badboybike_hero_title', 'HARLEY-DAVIDSON<br>CUSTOM SHOP');
                echo wp_kses_post($hero_title);
                ?>
            </h1>
            
            <!-- Animated Subtitle -->
            <p class="hero__subtitle" data-animate="fade-up" data-delay="600">
                <?php echo esc_html(get_theme_mod('badboybike_hero_subtitle', 'UNIQUE CUSTOM BIKES BUILT TO PERFECTION')); ?>
            </p>
            
            <!-- Animated Buttons -->
            <div class="hero__actions" data-animate="fade-up" data-delay="800">
                <?php
                // Resolve Gallery page URL (by template), fallback to homepage section
                $gallery_pages = get_pages(array(
                    'post_type'      => 'page',
                    'meta_key'       => '_wp_page_template',
                    'meta_value'     => 'template-gallery.php',
                    'number'         => 1,
                ));
                $gallery_page_url = !empty($gallery_pages) ? get_permalink($gallery_pages[0]->ID) : home_url('/#customs');
                ?>
                <a href="<?php echo esc_url($gallery_page_url); ?>" class="btn btn--primary btn--hero">
                    <span>VIEW CUSTOMS</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 4L10 16M10 16L6 12M10 16L14 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
               
            </div>
            
            <!-- Stats Counter -->
            <div class="hero__stats" data-animate="fade-up" data-delay="1000">
                <div class="hero__stat">
                    <span class="hero__stat-number" data-count="150">0</span>
                    <span class="hero__stat-label">Custom Builds</span>
                </div>
                <div class="hero__stat-divider"></div>
                <div class="hero__stat">
                    <span class="hero__stat-number" data-count="15">0</span>
                    <span class="hero__stat-label">Years Experience</span>
                </div>
                <div class="hero__stat-divider"></div>
                <div class="hero__stat">
                    <span class="hero__stat-number" data-count="100">0</span>
                    <span class="hero__stat-label">Happy Clients</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="hero__scroll-indicator" data-animate="bounce">
        <div class="scroll-indicator__mouse">
            <div class="scroll-indicator__wheel"></div>
        </div>
        <span class="scroll-indicator__text">Scroll Down</span>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features">
    <div class="container">
        <div class="features__grid">
            <!-- Feature 1: Custom Motorcycles -->
            <article class="feature-card">
                <div class="feature-card__background">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/feature-custom.jpg" alt="Custom Motorcycles">
                </div>
                <div class="feature-card__overlay">
                    <h2 class="feature-card__title">CUSTOM<br>MOTORCYCLES</h2>
                </div>
            </article>
            
            <!-- Feature 2: Parts & Accessories -->
            <article class="feature-card">
                <div class="feature-card__background">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/feature-parts.jpg" alt="Parts and Accessories">
                </div>
                <div class="feature-card__overlay">
                    <h2 class="feature-card__title">PARTS &<br>ACCESSORIES</h2>
                </div>
            </article>
            
            <!-- Feature 3: About Us -->
            <article class="feature-card">
                <div class="feature-card__background">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/feature-about.jpg" alt="About Us">
                </div>
                <div class="feature-card__overlay">
                    <h2 class="feature-card__title">ABOUT<br>US</h2>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about" id="about">
    <div class="container about__container">
        <h2 class="section-title"><?php echo get_theme_mod('badboybike_about_title', 'About Bad Boy Bike'); ?></h2>
        <?php
        $about_content = get_theme_mod('badboybike_about_content');
        if ($about_content) {
            echo wpautop($about_content);
        } else {
            ?>
            <p class="about__text">
                We are a premium Harley-Davidson custom shop dedicated to creating unique, one-of-a-kind motorcycles 
                that reflect your personal style and vision. With years of experience and a passion for perfection, 
                we transform standard bikes into extraordinary machines.
            </p>
            <p class="about__text">
                Every custom build is a collaboration between our expert craftsmen and you. From concept to completion, 
                we ensure every detail is meticulously crafted to exceed your expectations.
            </p>
            <p class="about__text">
                Our shop specializes in full custom builds, performance upgrades, custom paint, and premium modifications 
                that make your bike truly unique.
            </p>
            <?php
        }
        ?>
    </div>
</section>

<!-- CUSTOMS GALLERY -->
<section class="gallery" id="customs">
    <div class="container">
        <div class="gallery__header">
            <h2 class="section-title">Our Custom Builds</h2>
        </div>
        
        <div class="gallery__grid" id="galleryGrid">
            <!-- Bike cards will be generated by JavaScript -->
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="contact" id="contact">
    <div class="container contact__container">
        <div class="contact__header">
            <h2 class="section-title">Get In Touch</h2>
            <p class="about__text">Ready to start your custom build? Contact us today.</p>
        </div>
        
        <?php echo do_shortcode('[badboybike_contact_form]'); ?>
    </div>
</section>

<style>
/* Enhanced Hero Section with Parallax */
.hero {
    position: relative;
    height: 100vh;
    min-height: 700px;
    max-height: 1000px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero__parallax {
    position: absolute;
    top: -100px;
    left: 0;
    width: 100%;
    height: calc(100% + 200px);
    z-index: 1;
    will-change: transform;
}

.hero__background {
    width: 100%;
    height: 100%;
    position: relative;
}

.hero__bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.hero__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        135deg,
        rgba(0, 0, 0, 0.7) 0%,
        rgba(0, 0, 0, 0.5) 50%,
        rgba(0, 0, 0, 0.7) 100%
    );
}

.hero__content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Badge */
.hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 24px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    margin-bottom: 30px;
    opacity: 0;
    transform: translateY(30px);
}

.hero__badge-icon {
    font-size: 24px;
    animation: rotate 3s ease-in-out infinite;
}

@keyframes rotate {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-10deg); }
    75% { transform: rotate(10deg); }
}

.hero__badge-text {
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Title */
.hero__title {
    /* font-size: clamp(48px, 8vw, 120px); */
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin: 0 0 30px;
    text-shadow: 0 4px 30px rgba(0, 0, 0, 0.8);
    opacity: 0;
    transform: translateY(40px);
}

/* Subtitle */
.hero__subtitle {
    font-size: clamp(16px, 2vw, 24px);
    color: rgba(255, 255, 255, 0.9);
    font-weight: 400;
    letter-spacing: 3px;
    margin-bottom: 40px;
    opacity: 0;
    transform: translateY(30px);
}

/* Actions */
.hero__actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 60px;
    opacity: 0;
    transform: translateY(30px);
}

.btn--hero {
    padding: 18px 40px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 1.5px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.btn--primary.btn--hero {
    background: #fff;
    color: #000;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn--primary.btn--hero::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.btn--primary.btn--hero:hover::before {
    width: 300px;
    height: 300px;
}

.btn--primary.btn--hero:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(255, 255, 255, 0.3);
}

.btn--primary.btn--hero svg {
    transition: transform 0.4s ease;
}

.btn--primary.btn--hero:hover svg {
    transform: translateY(5px);
    animation: bounce-arrow 0.6s ease-in-out infinite;
}

@keyframes bounce-arrow {
    0%, 100% { transform: translateY(5px); }
    50% { transform: translateY(8px); }
}

.btn--outline {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.btn--outline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: #fff;
    transition: width 0.4s ease;
    z-index: -1;
}

.btn--outline:hover::before {
    width: 100%;
}

.btn--outline:hover {
    color: #000;
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(255, 255, 255, 0.3);
}

/* Stats */
.hero__stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
    opacity: 0;
    transform: translateY(30px);
}

.hero__stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.hero__stat-number {
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    color: #fff;
    line-height: 1;
}

.hero__stat-number::after {
    content: '+';
    margin-left: 5px;
    opacity: 0.7;
}

.hero__stat-label {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hero__stat-divider {
    width: 2px;
    height: 60px;
    background: linear-gradient(
        180deg,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.5) 50%,
        rgba(255, 255, 255, 0) 100%
    );
}

/* Scroll Indicator */
.hero__scroll-indicator {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    opacity: 0;
}

.scroll-indicator__mouse {
    width: 28px;
    height: 45px;
    border: 2px solid rgba(255, 255, 255, 0.8);
    border-radius: 20px;
    position: relative;
}

.scroll-indicator__wheel {
    width: 4px;
    height: 8px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll-wheel 2s ease-in-out infinite;
}

@keyframes scroll-wheel {
    0%, 100% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    50% {
        opacity: 0;
        transform: translateX(-50%) translateY(15px);
    }
}

.scroll-indicator__text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Animation States */
[data-animate] {
    transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1),
                transform 1s cubic-bezier(0.4, 0, 0.2, 1);
}

[data-animate].animated {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

[data-animate="bounce"].animated {
    animation: bounce-indicator 2s ease-in-out infinite;
}

@keyframes bounce-indicator {
    0%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    50% {
        transform: translateX(-50%) translateY(15px);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .hero {
        max-height: 800px;
    }
    
    .hero__stats {
        gap: 30px;
    }
    
    .hero__stat-divider {
        height: 40px;
    }
}

@media (max-width: 768px) {
    .hero {
        min-height: 600px;
    }
    
    .hero__badge-text {
        font-size: 12px;
    }
    
    .hero__subtitle {
        letter-spacing: 1px;
    }
    
    .hero__actions {
        flex-direction: column;
        width: 100%;
        gap: 15px;
    }
    
    .btn--hero {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
    
    .hero__stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .hero__stat-divider {
        width: 60px;
        height: 2px;
        background: linear-gradient(
            90deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.5) 50%,
            rgba(255, 255, 255, 0) 100%
        );
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parallax Effect
    const parallaxElement = document.querySelector('.hero__parallax');
    const heroSection = document.querySelector('.hero');
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const heroHeight = heroSection ? heroSection.offsetHeight : 0;
        
        if (scrolled < heroHeight && parallaxElement) {
            const speed = parseFloat(parallaxElement.dataset.parallaxSpeed) || 0.5;
            const yPos = scrolled * speed;
            parallaxElement.style.transform = `translate3d(0, ${yPos}px, 0)`;
        }
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            window.requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick, { passive: true });
    
    // Fade-in animations
    const animatedElements = document.querySelectorAll('[data-animate]');
    
    function animateElements() {
        animatedElements.forEach((element) => {
            const delay = element.getAttribute('data-delay') || 0;
            
            setTimeout(() => {
                element.classList.add('animated');
            }, parseInt(delay));
        });
    }
    
    // Trigger animations
    setTimeout(animateElements, 300);
    
    // Counter Animation for Stats
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 60; // 60 frames for smooth animation
        const duration = 2000; // 2 seconds
        const frameTime = duration / 60;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, frameTime);
    }
    
    // Animate stats when they become visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const numbers = entry.target.querySelectorAll('.hero__stat-number');
                numbers.forEach(number => {
                    const target = parseInt(number.dataset.count);
                    animateCounter(number, target);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    const heroStats = document.querySelector('.hero__stats');
    if (heroStats) {
        statsObserver.observe(heroStats);
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>

<?php
get_footer();


