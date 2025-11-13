<?php
/**
 * Bad Boy Bike Theme Functions
 *
 * @package BadBoyBike
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include contact form
require get_template_directory() . '/inc/contact-form.php';

// Theme setup
function badboybike_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'badboybike'),
        'footer' => __('Footer Menu', 'badboybike'),
    ));
    
    // Image sizes for motorcycles
    add_image_size('motorcycle-thumb', 400, 300, true);
    add_image_size('motorcycle-main', 1200, 800, true);
    add_image_size('motorcycle-detail', 1200, 800, true);
    add_image_size('hero-image', 1920, 1080, true);
}
add_action('after_setup_theme', 'badboybike_setup');

// Enqueue styles and scripts
function badboybike_scripts() {
    // Styles
    wp_enqueue_style('badboybike-variables', get_template_directory_uri() . '/css/variables.css', array(), '1.0.0');
    wp_enqueue_style('badboybike-reset', get_template_directory_uri() . '/css/reset.css', array('badboybike-variables'), '1.0.0');
    wp_enqueue_style('badboybike-style', get_template_directory_uri() . '/css/style.css', array('badboybike-reset'), '1.0.0');
    wp_enqueue_style('badboybike-responsive', get_template_directory_uri() . '/css/responsive.css', array('badboybike-style'), '1.0.0');
    
    // Scripts
    wp_enqueue_script('badboybike-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true);
    wp_enqueue_script('badboybike-gallery', get_template_directory_uri() . '/js/gallery.js', array(), '1.0.0', true);
    wp_enqueue_script('badboybike-modal', get_template_directory_uri() . '/js/modal.js', array(), '1.0.0', true);
    wp_enqueue_script('badboybike-parallax', get_template_directory_uri() . '/js/parallax.js', array(), '1.0.0', true);
    wp_enqueue_script('badboybike-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
    
    // Lightbox only on Gallery template
    if (is_page_template('template-gallery.php')) {
        wp_enqueue_script('badboybike-lightbox', get_template_directory_uri() . '/js/lightbox.js', array(), '1.0.0', true);
    }
    
    // Localize script with WordPress data
    wp_localize_script('badboybike-gallery', 'badboybike_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('badboybike_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'badboybike_scripts');

// Register Custom Post Type: Motorcycles
function badboybike_register_motorcycle_post_type() {
    $labels = array(
        'name' => 'Motorcycles',
        'singular_name' => 'Motorcycle',
        'menu_name' => 'Motorcycles',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Motorcycle',
        'edit_item' => 'Edit Motorcycle',
        'new_item' => 'New Motorcycle',
        'view_item' => 'View Motorcycle',
        'search_items' => 'Search Motorcycles',
        'not_found' => 'No motorcycles found',
        'not_found_in_trash' => 'No motorcycles found in trash',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-motorcycle',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'motorcycles'),
        'show_in_menu' => true,
    );
    
    register_post_type('motorcycle', $args);
}
add_action('init', 'badboybike_register_motorcycle_post_type');

// Register Custom Taxonomy: Motorcycle Categories
function badboybike_register_motorcycle_taxonomy() {
    $labels = array(
        'name' => 'Categories',
        'singular_name' => 'Category',
        'search_items' => 'Search Categories',
        'all_items' => 'All Categories',
        'edit_item' => 'Edit Category',
        'update_item' => 'Update Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => 'New Category Name',
        'menu_name' => 'Categories',
    );
    
    register_taxonomy('motorcycle_category', array('motorcycle'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'motorcycle-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'badboybike_register_motorcycle_taxonomy');

// Add custom meta boxes for motorcycle specifications
function badboybike_add_motorcycle_meta_boxes() {
    add_meta_box(
        'motorcycle_specs',
        'Motorcycle Specifications',
        'badboybike_motorcycle_specs_callback',
        'motorcycle',
        'normal',
        'high'
    );
    
    add_meta_box(
        'motorcycle_modifications',
        'Modifications',
        'badboybike_motorcycle_modifications_callback',
        'motorcycle',
        'normal',
        'high'
    );
    
    add_meta_box(
        'motorcycle_gallery',
        'Motorcycle Gallery',
        'badboybike_motorcycle_gallery_callback',
        'motorcycle',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'badboybike_add_motorcycle_meta_boxes');

// Specifications meta box callback
function badboybike_motorcycle_specs_callback($post) {
    wp_nonce_field('badboybike_save_motorcycle_specs', 'badboybike_motorcycle_specs_nonce');
    
    $model = get_post_meta($post->ID, '_motorcycle_model', true);
    $year = get_post_meta($post->ID, '_motorcycle_year', true);
    $engine = get_post_meta($post->ID, '_motorcycle_engine', true);
    $power = get_post_meta($post->ID, '_motorcycle_power', true);
    $torque = get_post_meta($post->ID, '_motorcycle_torque', true);
    $weight = get_post_meta($post->ID, '_motorcycle_weight', true);
    $status = get_post_meta($post->ID, '_motorcycle_status', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="motorcycle_model">Model</label></th>
            <td><input type="text" id="motorcycle_model" name="motorcycle_model" value="<?php echo esc_attr($model); ?>" class="regular-text" placeholder="Harley-Davidson V-Rod"></td>
        </tr>
        <tr>
            <th><label for="motorcycle_year">Year</label></th>
            <td><input type="number" id="motorcycle_year" name="motorcycle_year" value="<?php echo esc_attr($year); ?>" class="regular-text" placeholder="2024"></td>
        </tr>
        <tr>
            <th><label for="motorcycle_engine">Engine</label></th>
            <td><input type="text" id="motorcycle_engine" name="motorcycle_engine" value="<?php echo esc_attr($engine); ?>" class="regular-text" placeholder="1250cc Revolution V-Twin"></td>
        </tr>
        <tr>
            <th><label for="motorcycle_power">Power</label></th>
            <td><input type="text" id="motorcycle_power" name="motorcycle_power" value="<?php echo esc_attr($power); ?>" class="regular-text" placeholder="125 HP"></td>
        </tr>
        <tr>
            <th><label for="motorcycle_torque">Torque</label></th>
            <td><input type="text" id="motorcycle_torque" name="motorcycle_torque" value="<?php echo esc_attr($torque); ?>" class="regular-text" placeholder="85 lb-ft"></td>
        </tr>
        <tr>
            <th><label for="motorcycle_weight">Weight</label></th>
            <td><input type="text" id="motorcycle_weight" name="motorcycle_weight" value="<?php echo esc_attr($weight); ?>" class="regular-text" placeholder="295 kg"></td>
        </tr>
        <tr>
            <th><label for="motorcycle_status">Status</label></th>
            <td>
                <select id="motorcycle_status" name="motorcycle_status">
                    <option value="Available" <?php selected($status, 'Available'); ?>>Available</option>
                    <option value="Sold" <?php selected($status, 'Sold'); ?>>Sold</option>
                    <option value="Reserved" <?php selected($status, 'Reserved'); ?>>Reserved</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Modifications meta box callback
function badboybike_motorcycle_modifications_callback($post) {
    wp_nonce_field('badboybike_save_motorcycle_modifications', 'badboybike_motorcycle_modifications_nonce');
    
    $modifications = get_post_meta($post->ID, '_motorcycle_modifications', true);
    ?>
    <p>Enter each modification on a new line:</p>
    <textarea name="motorcycle_modifications" rows="10" class="large-text"><?php echo esc_textarea($modifications); ?></textarea>
    <p class="description">Example: Full custom black powder coat</p>
    <?php
}

// Gallery meta box callback
function badboybike_motorcycle_gallery_callback($post) {
    wp_nonce_field('badboybike_save_motorcycle_gallery', 'badboybike_motorcycle_gallery_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_motorcycle_gallery', true);
    ?>
    <div id="motorcycle-gallery-container">
        <ul id="motorcycle-gallery-images">
            <?php
            if ($gallery_ids) {
                $ids = explode(',', $gallery_ids);
                foreach ($ids as $id) {
                    $image = wp_get_attachment_image_src($id, 'thumbnail');
                    echo '<li data-id="' . $id . '"><img src="' . $image[0] . '"><a href="#" class="remove-image">Remove</a></li>';
                }
            }
            ?>
        </ul>
        <input type="hidden" id="motorcycle_gallery_ids" name="motorcycle_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>">
        <button type="button" class="button" id="add-gallery-image">Add Images</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#add-gallery-image').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to Gallery' },
                multiple: true
            });
            
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                var ids = $('#motorcycle_gallery_ids').val();
                ids = ids ? ids.split(',') : [];
                
                attachments.forEach(function(attachment) {
                    ids.push(attachment.id);
                    $('#motorcycle-gallery-images').append(
                        '<li data-id="' + attachment.id + '"><img src="' + attachment.sizes.thumbnail.url + '"><a href="#" class="remove-image">Remove</a></li>'
                    );
                });
                
                $('#motorcycle_gallery_ids').val(ids.join(','));
            });
            
            frame.open();
        });
        
        $('#motorcycle-gallery-images').on('click', '.remove-image', function(e) {
            e.preventDefault();
            var $li = $(this).closest('li');
            var id = $li.data('id');
            var ids = $('#motorcycle_gallery_ids').val().split(',');
            ids = ids.filter(function(val) { return val != id; });
            $('#motorcycle_gallery_ids').val(ids.join(','));
            $li.remove();
        });
    });
    </script>
    <style>
    #motorcycle-gallery-images {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #motorcycle-gallery-images li {
        display: inline-block;
        margin: 5px;
        position: relative;
    }
    #motorcycle-gallery-images li img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    #motorcycle-gallery-images .remove-image {
        position: absolute;
        top: 0;
        right: 0;
        background: red;
        color: white;
        padding: 2px 5px;
        text-decoration: none;
        font-size: 10px;
    }
    </style>
    <?php
}

// Save motorcycle meta data
function badboybike_save_motorcycle_meta($post_id) {
    // Check nonce and autosave
    if (!isset($_POST['badboybike_motorcycle_specs_nonce']) || 
        !wp_verify_nonce($_POST['badboybike_motorcycle_specs_nonce'], 'badboybike_save_motorcycle_specs')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save specifications
    $fields = array('model', 'year', 'engine', 'power', 'torque', 'weight', 'status');
    foreach ($fields as $field) {
        if (isset($_POST['motorcycle_' . $field])) {
            update_post_meta($post_id, '_motorcycle_' . $field, sanitize_text_field($_POST['motorcycle_' . $field]));
        }
    }
    
    // Save modifications
    if (isset($_POST['motorcycle_modifications'])) {
        update_post_meta($post_id, '_motorcycle_modifications', sanitize_textarea_field($_POST['motorcycle_modifications']));
    }
    
    // Save gallery
    if (isset($_POST['motorcycle_gallery_ids'])) {
        update_post_meta($post_id, '_motorcycle_gallery', sanitize_text_field($_POST['motorcycle_gallery_ids']));
    }
}
add_action('save_post_motorcycle', 'badboybike_save_motorcycle_meta');

// Get motorcycle data for JavaScript
function badboybike_get_motorcycles_data() {
    $args = array(
        'post_type' => 'motorcycle',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    
    $motorcycles = array();
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            
            // Get gallery images
            $gallery_ids = get_post_meta($post_id, '_motorcycle_gallery', true);
            $images = array();
            
            if ($gallery_ids) {
                $ids = explode(',', $gallery_ids);
                foreach ($ids as $id) {
                    $images[] = wp_get_attachment_image_url($id, 'motorcycle-main');
                }
            }
            
            // Get modifications
            $modifications_text = get_post_meta($post_id, '_motorcycle_modifications', true);
            $modifications = $modifications_text ? explode("\n", trim($modifications_text)) : array();
            
            // Get categories
            $categories = wp_get_post_terms($post_id, 'motorcycle_category');
            $category = !empty($categories) ? $categories[0]->name : 'Custom Cruiser';
            
            $motorcycles[] = array(
                'id' => $post_id,
                'name' => get_the_title(),
                'model' => get_post_meta($post_id, '_motorcycle_model', true),
                'year' => get_post_meta($post_id, '_motorcycle_year', true),
                'category' => $category,
                'thumbnail' => get_the_post_thumbnail_url($post_id, 'motorcycle-thumb'),
                'images' => $images,
                'specs' => array(
                    'engine' => get_post_meta($post_id, '_motorcycle_engine', true),
                    'power' => get_post_meta($post_id, '_motorcycle_power', true),
                    'torque' => get_post_meta($post_id, '_motorcycle_torque', true),
                    'weight' => get_post_meta($post_id, '_motorcycle_weight', true),
                ),
                'modifications' => array_filter($modifications),
                'description' => get_the_excerpt(),
                'status' => get_post_meta($post_id, '_motorcycle_status', true) ?: 'Available',
            );
        }
        wp_reset_postdata();
    }
    
    return $motorcycles;
}

// Enqueue media uploader on motorcycle edit page
function badboybike_enqueue_media_uploader($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        global $post;
        if (isset($post) && 'motorcycle' === $post->post_type) {
            wp_enqueue_media();
            wp_enqueue_script('jquery');
        }
    }
}
add_action('admin_enqueue_scripts', 'badboybike_enqueue_media_uploader');

// Add motorcycles data to footer for JavaScript
function badboybike_footer_scripts() {
    if (is_front_page() || is_home() || is_page_template('template-home.php')) {
        $motorcycles = badboybike_get_motorcycles_data();
        ?>
        <script>
        var motorcyclesData = <?php echo json_encode($motorcycles); ?>;
        </script>
        <?php
    } else {
        // Always define motorcyclesData to prevent JS errors
        ?>
        <script>
        var motorcyclesData = [];
        </script>
        <?php
    }
}
add_action('wp_footer', 'badboybike_footer_scripts', 5);

// Contact form handler
function badboybike_handle_contact_form() {
    check_ajax_referer('badboybike_contact_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = sanitize_textarea_field($_POST['message']);
    
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission from ' . $name;
    $body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    $sent = wp_mail($to, $subject, $body, $headers);
    
    if ($sent) {
        wp_send_json_success('Message sent successfully!');
    } else {
        wp_send_json_error('Failed to send message.');
    }
}
add_action('wp_ajax_badboybike_contact', 'badboybike_handle_contact_form');
add_action('wp_ajax_nopriv_badboybike_contact', 'badboybike_handle_contact_form');

// Theme Customizer Settings
function badboybike_customize_register($wp_customize) {
    // Features Section
    $wp_customize->add_section('badboybike_features', array(
        'title' => 'Feature Cards',
        'description' => 'Customize the feature cards on the homepage',
        'priority' => 30,
    ));
    
    // Feature Card 1: Custom Motorcycles
    $wp_customize->add_setting('badboybike_feature1_image', array(
        'default' => get_template_directory_uri() . '/images/featured/feature-custom.webp',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'badboybike_feature1_image', array(
        'label' => 'Custom Motorcycles - Image',
        'description' => 'Recommended size: 800x600px',
        'section' => 'badboybike_features',
        'settings' => 'badboybike_feature1_image',
        'priority' => 10,
    )));
    
    $wp_customize->add_setting('badboybike_feature1_title', array(
        'default' => 'CUSTOM<br>MOTORCYCLES',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('badboybike_feature1_title', array(
        'label' => 'Custom Motorcycles - Title',
        'description' => 'Use <br> for line breaks',
        'section' => 'badboybike_features',
        'type' => 'text',
        'priority' => 11,
    ));
    
    // Feature Card 2: Parts & Accessories
    $wp_customize->add_setting('badboybike_feature2_image', array(
        'default' => get_template_directory_uri() . '/images/featured/feature-parts.webp',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'badboybike_feature2_image', array(
        'label' => 'Parts & Accessories - Image',
        'description' => 'Recommended size: 800x600px',
        'section' => 'badboybike_features',
        'settings' => 'badboybike_feature2_image',
        'priority' => 20,
    )));
    
    $wp_customize->add_setting('badboybike_feature2_title', array(
        'default' => 'PARTS &<br>ACCESSORIES',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('badboybike_feature2_title', array(
        'label' => 'Parts & Accessories - Title',
        'description' => 'Use <br> for line breaks',
        'section' => 'badboybike_features',
        'type' => 'text',
        'priority' => 21,
    ));
    
    // Feature Card 3: About Us
    $wp_customize->add_setting('badboybike_feature3_image', array(
        'default' => get_template_directory_uri() . '/images/featured/feature-about.webp',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'badboybike_feature3_image', array(
        'label' => 'About Us - Image',
        'description' => 'Recommended size: 800x600px',
        'section' => 'badboybike_features',
        'settings' => 'badboybike_feature3_image',
        'priority' => 30,
    )));
    
    $wp_customize->add_setting('badboybike_feature3_title', array(
        'default' => 'ABOUT<br>US',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('badboybike_feature3_title', array(
        'label' => 'About Us - Title',
        'description' => 'Use <br> for line breaks',
        'section' => 'badboybike_features',
        'type' => 'text',
        'priority' => 31,
    ));
    
    // Hero Section
    $wp_customize->add_section('badboybike_hero', array(
        'title' => 'Hero Section',
        'description' => 'Customize the hero section',
        'priority' => 20,
    ));
    
    $wp_customize->add_setting('badboybike_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'badboybike_hero_image', array(
        'label' => 'Hero Background Image',
        'section' => 'badboybike_hero',
        'settings' => 'badboybike_hero_image',
    )));
    
    $wp_customize->add_setting('badboybike_hero_title', array(
        'default' => 'HARLEY-DAVIDSON<br>CUSTOM SHOP',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('badboybike_hero_title', array(
        'label' => 'Hero Title',
        'section' => 'badboybike_hero',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('badboybike_hero_subtitle', array(
        'default' => 'UNIQUE CUSTOM BIKES BUILT TO PERFECTION',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('badboybike_hero_subtitle', array(
        'label' => 'Hero Subtitle',
        'section' => 'badboybike_hero',
        'type' => 'text',
    ));
    
    // About Section
    $wp_customize->add_section('badboybike_about', array(
        'title' => 'About Section',
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('badboybike_about_title', array(
        'default' => 'About Bad Boy Bike',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('badboybike_about_title', array(
        'label' => 'About Title',
        'section' => 'badboybike_about',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('badboybike_about_content', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('badboybike_about_content', array(
        'label' => 'About Content',
        'section' => 'badboybike_about',
        'type' => 'textarea',
    ));
    
    // About Section Parallax Background
    $wp_customize->add_setting('badboybike_about_bg_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'badboybike_about_bg_image', array(
        'label' => 'About Section Background Image (Parallax)',
        'description' => 'Recommended size: 1920x1080px or larger for best parallax effect',
        'section' => 'badboybike_about',
        'settings' => 'badboybike_about_bg_image',
    )));
    
    // Social Media
    $wp_customize->add_section('badboybike_social', array(
        'title' => 'Social Media',
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('badboybike_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('badboybike_facebook', array(
        'label' => 'Facebook URL',
        'section' => 'badboybike_social',
        'type' => 'url',
    ));
    
    $wp_customize->add_setting('badboybike_instagram', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('badboybike_instagram', array(
        'label' => 'Instagram URL',
        'section' => 'badboybike_social',
        'type' => 'url',
    ));
    
    $wp_customize->add_setting('badboybike_youtube', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('badboybike_youtube', array(
        'label' => 'YouTube URL',
        'section' => 'badboybike_social',
        'type' => 'url',
    ));
}
add_action('customize_register', 'badboybike_customize_register');

