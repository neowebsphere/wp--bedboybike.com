<?php
/**
 * Template Name: Customs
 * Description: Display custom motorcycles and builds
 *
 * @package BadBoyBike
 */

get_header();
?>

<section class="customs" id="customs">
    <div class="container">
        <div class="customs__header">
            <h1 class="section-title"><?php the_title(); ?></h1>
            <?php if (get_the_content()) : ?>
                <div class="customs__intro">
                    <?php
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="customs__grid">
            <?php
            // Query custom post type 'motorcycle' or display featured customs
            $args = array(
                'post_type' => 'motorcycle',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => 'is_custom',
                        'value' => '1',
                        'compare' => '='
                    )
                )
            );
            
            $customs_query = new WP_Query($args);
            
            if ($customs_query->have_posts()) :
                while ($customs_query->have_posts()) : $customs_query->the_post();
            ?>
                <article class="customs__item">
                    <div class="customs__item-image">
                        <?php 
                        $status = get_post_meta(get_the_ID(), '_motorcycle_status', true);
                        if ($status == 'Sold') : ?>
                            <span class="customs__item-badge customs__item-badge--sold">Sold</span>
                        <?php elseif ($status == 'Reserved') : ?>
                            <span class="customs__item-badge customs__item-badge--reserved">Reserved</span>
                        <?php endif; ?>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder-bike.svg" alt="<?php the_title(); ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="customs__item-content">
                        <h3 class="customs__item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <?php 
                        $model = get_post_meta(get_the_ID(), '_motorcycle_model', true);
                        $year = get_post_meta(get_the_ID(), '_motorcycle_year', true);
                        $price = get_post_meta(get_the_ID(), '_motorcycle_price', true);
                        
                        if ($model || $year) : ?>
                            <div class="customs__item-specs">
                                <?php if ($year) : ?><span class="year"><?php echo esc_html($year); ?></span><?php endif; ?>
                                <?php if ($model) : ?><span class="model"><?php echo esc_html($model); ?></span><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($price) : ?>
                            <div class="customs__item-price">
                                <?php echo esc_html($price); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (has_excerpt()) : ?>
                            <div class="customs__item-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn--secondary">View Details</a>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="customs__empty">
                    <p>No custom motorcycles found. Check back soon for our latest builds!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
