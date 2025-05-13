<?php
/*
Plugin Name: NETWAYS WP Thumbs
Description: Adds thumbs up/down voting to posts. Uses ETmodules icons if Divi is active, otherwise falls back to Font Awesome.
Version: 1.0
Author: NETWAYS
Author URI: https://www.netways.de
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: netways-wp-thumbs
*/
function netways_wp_thumbs_load_textdomain() {
    load_plugin_textdomain('netways-wp-thumbs', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'netways_wp_thumbs_load_textdomain');

function netways_enqueue_assets() {
    wp_enqueue_script(
        'netways_wp_thumbs_js',
        plugin_dir_url(__FILE__) . 'netways_wp_thumbs.js',
        array('jquery'),
        null,
        true
    );

    wp_enqueue_style(
        'netways_wp_thumbs_css',
        plugin_dir_url(__FILE__) . 'netways_wp_thumbs.css'
    );

    $is_divi = wp_get_theme()->get('Name') === 'Divi';

    wp_localize_script('netways_wp_thumbs_js', 'netwaysThumbs', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    	'nonce' => wp_create_nonce('netways_nonce'),
    	'useETmodules' => $is_divi,
    	'i18n' => array(
        	'already_voted' => __('Du hast bereits abgestimmt.', 'netways-wp-thumbs'),
        	'vote_failed'   => __('Es gab ein Problem beim Abstimmen.', 'netways-wp-thumbs'),
        )
    ));
}
add_action('wp_enqueue_scripts', 'netways_enqueue_assets');

function netways_display_thumbs() {
    if (is_single()) {
        global $post;
        $up = get_post_meta($post->ID, '_netways_thumb_up', true) ?: 0;
        $down = get_post_meta($post->ID, '_netways_thumb_down', true) ?: 0;

	return "
	<div class='netways-thumb-container' data-post-id='{$post->ID}'>
    	<button class='netways-thumb-btn up' data-vote='up'>
        	<span class='icon-holder' data-icon='up'></span>
        	<span class='netways-thumb-count' data-count='up'>0</span>
    	</button>
    	<button class='netways-thumb-btn down' data-vote='down'>
        	<span class='icon-holder' data-icon='down'></span>
        	<span class='netways-thumb-count' data-count='down'>0</span>
    	</button>
	</div>";
    }
    return '';
}
add_shortcode('netways_wp_thumbs', 'netways_display_thumbs');

function netways_handle_vote() {
    check_ajax_referer('netways_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $vote = $_POST['vote'];

    // Simple validation
    if (!in_array($vote, ['up', 'down'], true)) {
        wp_send_json_error('Invalid vote');
    }

    // Check for cookie
    $cookie_key = 'netways_voted_' . $post_id;
    if (isset($_COOKIE[$cookie_key])) {
        wp_send_json_error('already_voted');
    }

    // Update vote count
    $meta_key = '_netways_thumb_' . $vote;
    $count = get_post_meta($post_id, $meta_key, true);
    $count = $count ? intval($count) + 1 : 1;
    update_post_meta($post_id, $meta_key, $count);

    // Set cookie (valid 1 year)
    setcookie($cookie_key, $vote, time() + (365 * 24 * 60 * 60), "/");

    wp_send_json_success(array('new_count' => $count));
}
add_action('wp_ajax_netways_vote', 'netways_handle_vote');
add_action('wp_ajax_nopriv_netways_vote', 'netways_handle_vote');

function netways_get_vote_counts() {
    $post_id = intval($_GET['post_id']);
    $up = get_post_meta($post_id, '_netways_thumb_up', true) ?: 0;
    $down = get_post_meta($post_id, '_netways_thumb_down', true) ?: 0;

    wp_send_json_success(array(
        'up' => intval($up),
        'down' => intval($down)
    ));
}
add_action('wp_ajax_netways_get_votes', 'netways_get_vote_counts');
add_action('wp_ajax_nopriv_netways_get_votes', 'netways_get_vote_counts');


