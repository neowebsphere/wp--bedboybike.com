<?php
/**
 * Template Name: Motorcycles Gallery
 * Description: A gallery page that displays images added via the page editor.
 *
 * @package BadBoyBike
 */

get_header();
?>

<section class="gallery" id="gallery">
	<div class="container">
		<div class="gallery__header">
			<h1 class="section-title"><?php the_title(); ?></h1>
		</div>
		
		<div class="gallery__content">
			<?php
			while (have_posts()) :
				the_post();
				the_content(); // Use WP editor content (Gallery block recommended)
			endwhile;
			?>
		</div>
	</div>
</section>

<?php
get_footer();


