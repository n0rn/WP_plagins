<?php
/*
Plugin Name: pnd-Wiget-Menu
Plugin URI: http://pandateam.net.ua/
Description: The widget displays menu category of an accordion
Version: 1.0
Author: Viacheslav Yudin
Author URI: http://pandateam.net.ua/
*/

add_action('widgets_init', 'pnd_cats');


function pnd_cats() {
	register_widget('PND_Cats');
}

class PND_Cats extends WP_Widget {

	public $pnd_cats_array;

	function __construct() {
		$args = array(
			'name' => 'Categories: Accordion',
			'description' => ' The widget displays menu category of an accordion'
			);
		parent::__construct('pnd_cats', '', $args);
	}

	function form($instance) {
		extract($instance);
		$title = !empty($title) ? esc_attr($title) : '';
		$eventType = isset($eventType) ? $eventType : 'hover';
		$hoverDelay = isset($hoverDelay) ? $hoverDelay : 100;
		$speed = isset($speed) ? $speed : 400;
		$exclude = isset($exclude) ? $exclude : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>">Heading:</label>
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo $title ?>" class="widefat">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('eventType') ?>">Method disclosure:</label>
		<select class="widefat" name="<?php echo $this->get_field_name('eventType') ?>" id="<?php echo $this->get_field_name('eventType') ?>">
			<option value="click" <?php selected('click', $eventType, true); ?>>Click</option>
			<option value="hover" <?php selected('hover', $eventType, true); ?>>Hover</option>
		</select>	
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('hoverDelay') ?>">Pause before opening (ms):</label>
			<input type="text" name="<?php echo $this->get_field_name('hoverDelay') ?>" id="<?php echo $this->get_field_id('hoverDelay') ?>" value="<?php echo $hoverDelay ?>" class="widefat">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('speed') ?>">Animation speed (ms):</label>
			<input type="text" name="<?php echo $this->get_field_name('speed') ?>" id="<?php echo $this->get_field_id('speed') ?>" value="<?php echo $speed ?>" class="widefat">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('exclude') ?>">Remove category (ID):</label>
			<input type="text" name="<?php echo $this->get_field_name('exclude') ?>" id="<?php echo $this->get_field_id('exclude') ?>" value="<?php echo $exclude ?>" class="widefat">
		</p>

		<?php
	}


	function widget($args, $instance) {
		extract($args);
		extract($instance);

        $this->pnd_cats_array = array(
        	'eventType' => $eventType,
        	'hoverDelay' => $hoverDelay,
        	'speed' => $speed
        	);

		add_action('wp_footer', array($this, 'pnd_styles_scripts' ));

		$title = apply_filters('widget_title', $title);

		add_filter ('wp_list_categories', array($this, 'pnd_remove_title'));


		$cats = wp_list_categories(
			array(
                'title_li' =>'',
                'echo' => false,
                /*'exclude' => $exclude*/
				)
			);

		$cats = preg_replace('#title="[^"]+"#', '', $cats);

		$html = $before_widget;
		$html .=$before_title . $title . $after_title;
		$html .= '<ul class="accordion">';
		$html .= $cats;
		$html .= '</ul>';
		$html .= $after_widget;
		echo $html;

	}

	function update($new_instance, $old_instance){

		$new_instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$new_instance['eventType'] = ($new_instance['eventType'] == 'click') ? 'click' : 'hover';
		$new_instance['hoverDelay'] = ((int)$new_instance['hoverDelay'] ) ? $new_instance['hoverDelay'] : 100;
		$new_instance['speed'] = ((int)$new_instance['speed'] ) ? $new_instance['speed'] : 400;
		$new_instance['exclude'] = !empty($new_instance['exclude']) ? $new_instance['exclude'] : '';

		return $new_instance;
	}

	function pnd_styles_scripts() {
		wp_register_script('pnd-cookie', plugins_url('js/jquery.cookie.js', __FILE__), array('jquery'));
		wp_register_script('pnd-hoverIntent', plugins_url('js/jquery.hoverIntent.minified.js', __FILE__), array('pnd-cookie'));
		wp_register_script('pnd-accordion', plugins_url('js/jquery.dcjqaccordion.2.7.min.js', __FILE__), array('pnd-hoverIntent'));
		wp_register_script('pnd-custom', plugins_url('js/pnd-custom.js', __FILE__), array('pnd-accordion'));

		wp_enqueue_script('pnd-custom');
		wp_localize_script('pnd-custom', 'pnd_obj', $this->pnd_cats_array);


	}
	function pnd_remove_title($str) {
	$str = preg_replace('#title="[^"]+"#', '', $str);
	return $str;
	}
}