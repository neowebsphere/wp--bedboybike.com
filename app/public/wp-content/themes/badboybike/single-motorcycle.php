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

<article class="motorcycle-single">
    <div class="container">
        <div class="motorcycle-single__header">
            <h1 class="motorcycle-single__title"><?php the_title(); ?></h1>
            <p class="motorcycle-single__meta"><?php echo esc_html($model . ' • ' . $year . ' • ' . $category); ?></p>
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
                    <a href="<?php echo esc_url(home_url('/#customs')); ?>" class="btn">BACK TO GALLERY</a>
                </div>
            </div>
        </div>
    </div>
</article>

<style>
.motorcycle-single {
    padding: var(--spacing-4xl) 0;
    background-color: var(--color-bg-primary);
}

.motorcycle-single__header {
    text-align: center;
    margin-bottom: var(--spacing-3xl);
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
}
</style>

<?php endwhile; ?>

<?php get_footer(); ?>


