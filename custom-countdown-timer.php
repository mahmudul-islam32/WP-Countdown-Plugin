<?php
/**
 * Plugin Name: Custom Countdown Timer
 * Description: A simple countdown timer plugin.
 * Version: 1.0
 * Author: Mahmudul Islam
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


function cct_countdown_shortcode($atts) {
    // If it's a single listing, pull the custom date field using CMB2
    if (is_singular('post')) {
        // Get the custom field value (Unix timestamp)
        $custom_date_timestamp = get_post_meta(get_the_ID(), 'cct_countdown_date', true);

        // Convert timestamp to 'Y-m-d H:i:s' format for the countdown plugin
        $custom_date = $custom_date_timestamp ? date('Y-m-d H:i:s', $custom_date_timestamp) : '';

        // If a custom date exists, use it, otherwise use the default from shortcode attributes
        $atts = shortcode_atts(
            array(
                'date' => !empty($custom_date) ? $custom_date : '2024-12-31 23:59:59', // default date
            ),
            $atts
        );
    } else {
        // Default behavior for non-listing pages
        $atts = shortcode_atts(
            array(
                'date' => '2024-12-31 23:59:59', // default date
            ),
            $atts
        );
    }

    // Enqueue the CSS and JavaScript
    wp_enqueue_style('cct-countdown-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('cct-countdown-script', plugins_url('js/countdown.js', __FILE__), array('jquery'), null, true);

    // Generate a unique ID for each countdown
    $unique_id = uniqid('cct_');

    // Countdown HTML structure with unique IDs
    ob_start();
    ?>
    <div id="<?php echo $unique_id; ?>" class="cct-countdown" data-date="<?php echo esc_attr($atts['date']); ?>">
        <div>
            <span class="days"></span>
            <label>Days</label>
        </div>
        <div>
            <span class="hours"></span>
            <label>Hours</label>
        </div>
        <div>
            <span class="minutes"></span>
            <label>Minutes</label>
        </div>
        <div>
            <span class="seconds"></span>
            <label>Seconds</label>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initializeCountdown('<?php echo $unique_id; ?>');
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown', 'cct_countdown_shortcode');


