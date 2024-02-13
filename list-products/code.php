<?php
/*
Plugin Name: Products List
Plugin URI: https://compado.test
Description: Plugin to display a list of products using a compado's API.
Version: 1.0
Author: Felipe Paez
Author URI: https://felipepaez.com
License: GPL2
*/

// scripts and styles
function plugin_scripts() {
    wp_enqueue_script('my-plugin-script', plugin_dir_url(__FILE__) . 'assets/js/script.js');
}
add_action('wp_enqueue_scripts', 'plugin_scripts');

function plugin_styles() {
    wp_enqueue_style('product-listing-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'plugin_styles');

// Shortcode function to display product list
function display_product_list() {
    $api_url = 'https://api.compado.com/v2_1/host/205/category/home/defaul'; 
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return 'Error fetching data';
    }

    $body = wp_remote_retrieve_body($response);
    $products = json_decode($body);

    $output = '';
   
    foreach ($products->partners as $product) {
        $output .= '<div class="product-box">';
        $output .= '<a href="'. $product->api_exitover_url .'" target="_blank"><div class="top-section">';
        $output .= '<div class="logo">';
        $output .= '<img src="https://media.api-domain-compado.com/'. $product->logo_image .'" alt="Logo del producto">';
        $output .= '</div>';
        $output .= '<div class="title-description">';
        $output .= '<h2>'. $product->partner_name .'</h2>';
        $output .= '<p>'. $product->pricing .'</p>';
        $output .= '</div>';
        $output .= '<div class="rating"><p>'. $product->score .'</p></div>';
        $output .= '</div></a>';
        $output .= '<hr class="separator">';
        $output .= '<div class="bottom-section">';
        $output .= '<div class="visit-site">';
        $output .= '<a href="'. $product->api_exitover_url .'" target="_blank">Visit Site</a>';
        $output .= '</div>';
        $output .= '<div class="see-more" id="see-more-'.$product->partner_id.'" onclick="toggleAdditionalInfo('.$product->partner_id.')">Read More</div>';
        $output .= '<div style="display: none;" class="column-section column-section-'.$product->partner_id.'">';
        $output .= '<div class="additional-info-bottom">';
        $output .= '<p>'. $product->introduction .'</p>';
        $output .= '</div>';
        $output .= '<div class="product-image-bottom">';
        $output .= '<img src="https://media.api-domain-compado.com/'. $product->cover_image .'" alt="Imagen del producto">';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '';

    return $output;
}
add_shortcode('product_list', 'display_product_list');