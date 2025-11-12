<?php
/**
 * Archive Motorcycle Template
 *
 * @package BadBoyBike
 */

get_header();
?>

<section class="motorcycle-archive">
    <div class="container">
        <header class="archive-header">
            <h1 class="section-title">
                <?php
                if (is_tax('motorcycle_category')) {
                    single_term_title();
                } else {
                    echo 'All Custom Motorcycles';
                }
                ?>
            </h1>
            <?php if (is_tax('motorcycle_category') && term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
        </header>
        
        <?php if (have_posts()) : ?>
            <div class="gallery__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="bike-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="bike-card__image">
                                    <?php the_post_thumbnail('motorcycle-thumb'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="bike-card__content">
                                <h3 class="bike-card__name"><?php the_title(); ?></h3>
                                <p class="bike-card__model">
                                    <?php
                                    $model = get_post_meta(get_the_ID(), '_motorcycle_model', true);
                                    $year = get_post_meta(get_the_ID(), '_motorcycle_year', true);
                                    echo esc_html($model . ' • ' . $year);
                                    ?>
                                </p>
                                
                                <div class="bike-card__specs">
                                    <?php
                                    $engine = get_post_meta(get_the_ID(), '_motorcycle_engine', true);
                                    $power = get_post_meta(get_the_ID(), '_motorcycle_power', true);
                                    if ($engine) echo '<span class="bike-card__spec">' . esc_html($engine) . '</span>';
                                    if ($power) echo '<span class="bike-card__spec">' . esc_html($power) . '</span>';
                                    ?>
                                </div>
                                
                                <span class="btn btn--primary bike-card__btn">VIEW DETAILS</span>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
            ));
            ?>
        <?php else : ?>
            <p class="no-motorcycles">No motorcycles found.</p>
        <?php endif; ?>
    </div>
</section>

<style>
.motorcycle-archive {
    padding: var(--spacing-4xl) 0;
    background-color: var(--color-bg-primary);
    min-height: 60vh;
}

.archive-header {
    text-align: center;
    margin-bottom: var(--spacing-3xl);
}

.archive-description {
    max-width: 800px;
    margin: var(--spacing-lg) auto 0;
    line-height: 1.8;
    color: var(--color-text-light);
}

.no-motorcycles {
    text-align: center;
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
    padding: var(--spacing-4xl) 0;
}

.bike-card a {
    display: block;
    text-decoration: none;
    color: inherit;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: var(--spacing-sm);
    margin-top: var(--spacing-3xl);
}

.pagination .page-numbers {
    padding: var(--spacing-sm) var(--spacing-lg);
    background-color: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    color: var(--color-text-primary);
    text-decoration: none;
    transition: all var(--transition-base);
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background-color: var(--color-text-primary);
    color: var(--color-bg-primary);
    border-color: var(--color-text-primary);
}
</style>

<?php get_footer(); ?>


