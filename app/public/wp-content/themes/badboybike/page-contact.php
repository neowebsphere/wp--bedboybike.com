<?php
/**
 * Template Name: Contact
 * Description: Contact page with contact form
 *
 * @package BadBoyBike
 */

get_header();
?>

<section class="contact" id="contact">
    <div class="container">
        <div class="contact__header">
            <h1 class="section-title"><?php the_title(); ?></h1>
        </div>
        
        <div class="contact__content">
            <div class="contact__info">
                <?php
                // Display the page content if any
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
            
            <div class="contact__form-wrapper">
                <h2>Get In Touch</h2>
                <?php 
                // Display the contact form using the shortcode
                echo do_shortcode('[badboybike_contact_form]'); 
                ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
