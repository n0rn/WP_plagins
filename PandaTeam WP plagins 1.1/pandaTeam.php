<?php
/*
Plugin Name: PandaTeam Plagin CAPTCHA
Plugin URI: google.com.ua
Description: Some information
Version: 1.1
Author: Norn
Author http://pandateam.net.ua/
*/


add_filter('comment_form_default_fields', 'panda_plagin_captcha');
add_filter('preprocess_comment', 'panda_check_captcha');
add_filter('comment_form_field_comment', 'padnda_check_captcha2');

function panda_plagin_captcha($fields){
	unset($fields['url']);
	$fields['captcha'] = '<p>
	<lable for="captcha">Captcha<span class="required">*</span></lable>
	<input type="checkbox" name="captcha" id="captcha">
	</p>';

	return $fields;

}

function panda_check_captcha($commentdata){

	if(is_user_logged_in()) return $commentdata;
	if(!isset($_POST['captcha'])) {
		wp_die('<b>Ошибка</b>: Возможно вы робот');
	}
	return $commentdata;
}

function padnda_check_captcha2($comment_field){
     $comment_field .='<p>
     <lable for="captcha">Captcha<span class="required">*</span></lable>
     <input type="checkbox" name="captcha" id="captcha">
	 </p>';

	return $comment_field;


}

 