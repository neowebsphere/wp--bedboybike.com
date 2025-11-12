<?php
/**
 * Single Motorcycle Template
 *
 * @package BadBoyBike
 */

get_header();

while (have_posts()) : the_post();
    $post_id = get_the_ID();
    
    // Get meta data
    $model = get_post_meta($post_id, '_motorcycle_model', true);
    $year = get_post_meta($post_id, '_motorcycle_year', true);
    $engine = get_post_meta($post_id, '_motorcycle_engine', true);
    $power = get_post_meta($post_id, '_motorcycle_power', true);
    $torque = get_post_meta($post_id, '_motorcycle_torque', true);
    $weight = get_post_meta($post_id, '_motorcycle_weight', true);
    $status = get_post_meta($post_id, '_motorcycle_status', true) ?: 'Available';
    $modifications_text = get_post_meta($post_id, '_motorcycle_modifications', true);
    $modifications = $modifications_text ? explode("\n", trim($modifications_text)) : array();
    
    // Get gallery
    $gallery_ids = get_post_meta($post_id, '_motorcycle_gallery', true);
    $gallery_images = array();
    if ($gallery_ids) {
        $ids = explode(',', $gallery_ids);
        foreach ($ids as $id) {
            $gallery_images[] = wp_get_attachment_image_url($id, 'motorcycle-main');
        }
    }
    
    // Get categories
    $categories = wp_get_post_terms($post_id, 'motorcycle_category');
    $category = !empty($categories) ? $categories[0]->name : 'Custom Cruiser';
?>

<!-- Hero Section with Parallax -->
<section class="motorcycle-hero">
    <div class="motorcycle-hero__parallax" data-parallax="scroll">
        <?php 
        if (has_post_thumbnail()) : 
            the_post_thumbnail('full', array('class' => 'motorcycle-hero__bg-image'));
        else : 
            // Fallback: use a default motorcycle image
            $fallback_jpg = get_template_directory() . '/images/default-motorcycle-hero.jpg';
            $fallback_svg = get_template_directory_uri() . '/images/default-motorcycle-hero.svg';
            
            // Check if JPG exists, otherwise use SVG
            if (file_exists($fallback_jpg)) {
                $fallback_image = get_template_directory_uri() . '/images/default-motorcycle-hero.jpg';
            } else {
                $fallback_image = $fallback_svg;
            }
            ?>
            <img src="<?php echo esc_url($fallback_image); ?>" 
                 alt="<?php the_title_attribute(); ?>" 
                 class="motorcycle-hero__bg-image">
        <?php endif; ?>
        <div class="motorcycle-hero__overlay"></div>
    </div>
    
    <div class="motorcycle-hero__content">
        <div class="container">
            <div class="motorcycle-hero__badge" data-animate="fade-up" data-delay="200">
                <span class="hero-badge__icon">🏍️</span>
                <span class="hero-badge__text"><?php echo esc_html($category); ?></span>
            </div>
            
            <h1 class="motorcycle-hero__title" data-animate="fade-up" data-delay="400">
                <?php the_title(); ?>
            </h1>
            
            <div class="motorcycle-hero__meta" data-animate="fade-up" data-delay="600">
                <div class="hero-meta__item">
                    <span class="hero-meta__label">Model</span>
                    <span class="hero-meta__value"><?php echo esc_html($model); ?></span>
                </div>
                <div class="hero-meta__separator">•</div>
                <div class="hero-meta__item">
                    <span class="hero-meta__label">Year</span>
                    <span class="hero-meta__value"><?php echo esc_html($year); ?></span>
                </div>
                <div class="hero-meta__separator">•</div>
                <div class="hero-meta__item">
                    <span class="hero-meta__label">Status</span>
                    <span class="hero-meta__value hero-meta__value--<?php echo strtolower($status); ?>">
                        <?php echo esc_html($status); ?>
                    </span>
                </div>
            </div>
            
            <div class="motorcycle-hero__actions" data-animate="fade-up" data-delay="800">
                <a href="#details" class="btn btn--primary btn--hero">
                    <span>VIEW DETAILS</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 4L10 16M10 16L6 12M10 16L14 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="#contact" class="btn btn--outline btn--hero">
                    INQUIRE NOW
                </a>
            </div>
        </div>
    </div>
    
    <div class="motorcycle-hero__scroll-indicator" data-animate="bounce">
        <div class="scroll-indicator__line"></div>
    </div>
</section>

<article class="motorcycle-single" id="details">
    <div class="container">
        <div class="motorcycle-single__header">
            <h2 class="section-title section-title--center">Complete Specifications</h2>
        </div>
        
        <div class="motorcycle-single__content">
            <div class="motorcycle-single__gallery">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="motorcycle-single__main-image">
                        <?php the_post_thumbnail('motorcycle-main'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($gallery_images)) : ?>
                    <div class="motorcycle-single__thumbnails">
                        <?php foreach ($gallery_images as $image_url) : ?>
                            <div class="motorcycle-single__thumbnail">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="motorcycle-single__details">
                <div class="motorcycle-single__section">
                    <h2 class="section-title">Description</h2>
                    <div class="motorcycle-single__description">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <div class="motorcycle-single__section">
                    <h2 class="section-title">Specifications</h2>
                    <div class="motorcycle-single__specs">
                        <?php if ($engine) : ?>
                            <div class="spec-item">
                                <span class="spec-label">Engine:</span>
                                <span class="spec-value"><?php echo esc_html($engine); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($power) : ?>
                            <div class="spec-item">
                                <span class="spec-label">Power:</span>
                                <span class="spec-value"><?php echo esc_html($power); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($torque) : ?>
                            <div class="spec-item">
                                <span class="spec-label">Torque:</span>
                                <span class="spec-value"><?php echo esc_html($torque); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($weight) : ?>
                            <div class="spec-item">
                                <span class="spec-label">Weight:</span>
                                <span class="spec-value"><?php echo esc_html($weight); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="spec-item">
                            <span class="spec-label">Status:</span>
                            <span class="spec-value spec-value--<?php echo strtolower($status); ?>">
                                <?php echo esc_html($status); ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($modifications)) : ?>
                    <div class="motorcycle-single__section">
                        <h2 class="section-title">Modifications</h2>
                        <ul class="motorcycle-single__modifications">
                            <?php foreach ($modifications as $mod) : ?>
                                <?php if (trim($mod)) : ?>
                                    <li><?php echo esc_html(trim($mod)); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="motorcycle-single__actions">
                    <a href="#contact" class="btn btn--primary">INQUIRE ABOUT THIS BUILD</a>
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
                    <a href="<?php echo esc_url($gallery_page_url); ?>" class="btn">BACK TO GALLERY</a>
                </div>
            </div>
        </div>
    </div>
</article>

<style>
/* Hero Section with Parallax */
.motorcycle-hero {
    position: relative;
    height: 100vh;
    min-height: 600px;
    max-height: 900px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.motorcycle-hero__parallax {
    position: absolute;
    top: -50px;
    left: 0;
    width: 100%;
    height: calc(100% + 100px);
    z-index: 1;
    will-change: transform;
}

.motorcycle-hero__bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.motorcycle-hero__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.3) 0%,
        rgba(0, 0, 0, 0.7) 100%
    );
}

.motorcycle-hero__content {
    position: relative;
    z-index: 2;
    width: 100%;
    text-align: center;
    padding: 0 20px;
}

.motorcycle-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    margin-bottom: 24px;
    opacity: 0;
    transform: translateY(20px);
}

.hero-badge__icon {
    font-size: 20px;
}

.hero-badge__text {
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.motorcycle-hero__title {
    font-size: clamp(48px, 8vw, 96px);
    font-weight: 900;
    color: #fff;
    margin: 0 0 32px;
    line-height: 1.1;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    opacity: 0;
    transform: translateY(30px);
}

.motorcycle-hero__meta {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 40px;
    opacity: 0;
    transform: translateY(20px);
}

.hero-meta__item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.hero-meta__label {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hero-meta__value {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
}

.hero-meta__value--available {
    color: #4ade80;
}

.hero-meta__value--sold {
    color: #f87171;
}

.hero-meta__separator {
    color: rgba(255, 255, 255, 0.3);
    font-size: 20px;
}

.motorcycle-hero__actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
    opacity: 0;
    transform: translateY(20px);
}

.btn--hero {
    padding: 16px 32px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.btn--primary.btn--hero {
    background: #fff;
    color: #000;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn--primary.btn--hero:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
}

.btn--primary.btn--hero svg {
    transition: transform 0.3s ease;
}

.btn--primary.btn--hero:hover svg {
    transform: translateY(3px);
}

.btn--outline {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.btn--outline:hover {
    background: #fff;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
}

.motorcycle-hero__scroll-indicator {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    opacity: 0;
}

.scroll-indicator__line {
    width: 2px;
    height: 60px;
    background: linear-gradient(
        180deg,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.8) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    animation: scrollLine 2s ease-in-out infinite;
}

@keyframes scrollLine {
    0%, 100% {
        transform: translateY(-10px);
        opacity: 0;
    }
    50% {
        transform: translateY(10px);
        opacity: 1;
    }
}

/* Animation States */
[data-animate] {
    transition: opacity 0.8s ease, transform 0.8s ease;
}

[data-animate].animated {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

[data-animate="bounce"].animated {
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    50% {
        transform: translateX(-50%) translateY(10px);
    }
}

/* Main Content */
.motorcycle-single {
    padding: var(--spacing-4xl) 0;
    background-color: var(--color-bg-primary);
}

.motorcycle-single__header {
    text-align: center;
    margin-bottom: var(--spacing-3xl);
}

.section-title--center {
    text-align: center;
}

.motorcycle-single__title {
    font-size: var(--font-size-h1);
    margin-bottom: var(--spacing-md);
}

.motorcycle-single__meta {
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
}

.motorcycle-single__content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: var(--spacing-2xl);
}

.motorcycle-single__main-image {
    width: 100%;
    margin-bottom: var(--spacing-lg);
}

.motorcycle-single__main-image img {
    width: 100%;
    height: auto;
    transition: opacity 0.3s ease;
}

.motorcycle-single__thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: var(--spacing-md);
}

.motorcycle-single__thumbnail {
    cursor: pointer;
    transition: transform var(--transition-base);
}

.motorcycle-single__thumbnail:hover {
    transform: scale(1.05);
}

.motorcycle-single__thumbnail img {
    width: 100%;
    height: auto;
}

.motorcycle-single__section {
    margin-bottom: var(--spacing-2xl);
}

.motorcycle-single__description {
    line-height: 1.8;
    color: var(--color-text-light);
}

.motorcycle-single__specs {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.spec-item {
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm) 0;
    border-bottom: 1px solid var(--color-border);
}

.spec-label {
    color: var(--color-text-secondary);
    text-transform: uppercase;
    font-size: var(--font-size-sm);
}

.spec-value {
    color: var(--color-text-primary);
}

.spec-value--available {
    color: #28a745;
}

.spec-value--sold {
    color: #dc3545;
}

.motorcycle-single__modifications {
    list-style: none;
    padding: 0;
}

.motorcycle-single__modifications li {
    padding: var(--spacing-sm) 0;
    padding-left: var(--spacing-lg);
    position: relative;
}

.motorcycle-single__modifications li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--color-accent);
    font-size: 20px;
}

.motorcycle-single__actions {
    display: flex;
    gap: var(--spacing-md);
    flex-wrap: wrap;
}

@media (max-width: 1024px) {
    .motorcycle-single__content {
        grid-template-columns: 1fr;
    }
    
    .motorcycle-hero {
        max-height: 700px;
    }
    
    .motorcycle-hero__title {
        font-size: clamp(36px, 10vw, 64px);
    }
    
    .motorcycle-hero__meta {
        flex-direction: column;
        gap: 12px;
    }
    
    .hero-meta__separator {
        display: none;
    }
    
    .motorcycle-hero__actions {
        flex-direction: column;
        width: 100%;
        padding: 0 20px;
    }
    
    .btn--hero {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .motorcycle-hero {
        min-height: 500px;
    }
    
    .hero-meta__value {
        font-size: 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parallax Effect
    const parallaxElement = document.querySelector('.motorcycle-hero__parallax');
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const heroHeight = document.querySelector('.motorcycle-hero').offsetHeight;
        
        if (scrolled < heroHeight) {
            const parallaxSpeed = 0.5;
            const yPos = scrolled * parallaxSpeed;
            
            if (parallaxElement) {
                parallaxElement.style.transform = `translate3d(0, ${yPos}px, 0)`;
            }
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
    
    // Fade-in animations on load
    const animatedElements = document.querySelectorAll('[data-animate]');
    
    function animateElements() {
        animatedElements.forEach((element) => {
            const delay = element.getAttribute('data-delay') || 0;
            
            setTimeout(() => {
                element.classList.add('animated');
            }, parseInt(delay));
        });
    }
    
    // Trigger animations after a short delay
    setTimeout(animateElements, 100);
    
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
    
    // Gallery thumbnail click handler (if exists)
    const mainImage = document.querySelector('.motorcycle-single__main-image img');
    const thumbnails = document.querySelectorAll('.motorcycle-single__thumbnail img');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const tempSrc = mainImage.src;
                mainImage.style.opacity = '0';
                
                setTimeout(() => {
                    mainImage.src = this.src;
                    mainImage.style.opacity = '1';
                }, 200);
            });
        });
    }
    
    // Add scroll reveal for content sections
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.motorcycle-single__section').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
});
</script>

<?php endwhile; ?>

<?php get_footer(); ?>


