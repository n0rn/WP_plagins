<?php
/*
Plugin Name: PandaTeam Plagin
Plugin URI: google.com.ua
Description: Some information
Version: 1.0
Author: Norn
Author http://pandateam.net.ua/
*/



/*Remove News Post from dashnord*/


function action_hook_dashboard() {
	remove_meta_box('dashboard_primary','dashboard','post_container_1');
}
add_action('wp_dashboard_setup', 'action_hook_dashboard');


/*Add link in admin bar*/

function add_links() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(array(
	'id'    => 'vk',
	'title' => 'Вконтакте',
	'href'  => 'https://vk.com'
));


}

add_action('wp_before_admin_bar_render', 'add_links');