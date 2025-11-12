<?php
/**
 * Contact Form Shortcode
 *
 * @package BadBoyBike
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register contact form shortcode
function badboybike_contact_form_shortcode() {
    ob_start();
    ?>
    <form class="contact-form" id="contactForm">
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" id="phone" name="phone" class="form-input">
        </div>
        
        <div class="form-group">
            <label for="message" class="form-label">Message</label>
            <textarea id="message" name="message" class="form-textarea" required></textarea>
        </div>
        
        <button type="submit" class="btn btn--primary form-submit">SEND MESSAGE</button>
    </form>
    
    <script>
    jQuery(document).ready(function($) {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var originalText = $button.text();
            
            $button.text('SENDING...').prop('disabled', true);
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'badboybike_contact',
                    nonce: '<?php echo wp_create_nonce('badboybike_contact_nonce'); ?>',
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    message: $('#message').val()
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.data);
                        $form[0].reset();
                    } else {
                        alert('Error: ' + response.data);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('badboybike_contact_form', 'badboybike_contact_form_shortcode');


