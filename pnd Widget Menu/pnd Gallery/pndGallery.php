<?php
/*
Plugin Name: pndGallery
Plugin URI: http://pandateam.net.ua/
Description: Use the shortcode: [gallery ids = "1,2,3"], where the attribute ids shows ID picture
Version: 1.0
Author: Viacheslav Yudin
Author URI: http://pandateam.net.ua/
*/

 remove_shortcode('gallery'); 
 add_shortcode('gallery', 'pnd_gallery');
 add_action('wp_enqueue_scripts', 'pnd_style_scripts');

 function pnd_style_scripts() {
 	wp_register_script('pnd-lightbox-js', plugins_url('js/lightbox.js', __FILE__ ), array('jquery') );
 	wp_register_style('pnd-lightbox-css', plugins_url('css/lightbox.css', __FILE__ ) );
 	wp_register_style('pnd-style-css', plugins_url('css/style.css', __FILE__ ) );

 	wp_enqueue_script ('pnd-lightbox-js');
 	wp_enqueue_style ('pnd-lightbox-css');
 	wp_enqueue_style ('pnd-style-css');
 }


 function pnd_gallery($atts) {
 	$img_id = explode(',', $atts['ids']);
 	if( !$img_id[0])  return '<div class="pnd-gallery"><p>In the gallery there are no pictures</p></div>';
 	$html = '<div class="pnd-gallery">';
 	foreach($img_id as $item) {
 		$img_data = get_posts( array(
           'p' => $item,
           'post_type' => 'attachment'

 			));
 		$img_desc =  $img_data[0] ->post_content;
 		$img_caption = $img_data[0] ->post_excerpt;
 		$img_title = $img_data[0] ->post_title;
 		$img_thumb = wp_get_attachment_image_src( $item );
 		$img_full = wp_get_attachment_image_src( $item, 'full');


 		$html .= "<a href='{$img_full[0]}' data-lightbox='gallery' data-title='{$img_caption}'><img src='{$img_thumb[0]}' width='{$img_thumb[1]}' height='{$img_thumb[2]}' alt='{$img_title}'></a>";
 	}
 	$html .= '</div>';
 	return $html;


 }