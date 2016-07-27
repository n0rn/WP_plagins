<?php
/*
Plugin Name: PandaTeam Plagin CAPTCHA
Plugin URI: google.com.ua
Description: Some information
Version: 1.2
Author: Norn
Author http://pandateam.net.ua/
*/



add_action('login_form', 'panda_cptcha_login');
add_action('wp_authenticate', 'panda_authenticate', 10, 2);


function panda_authenticate($username, $password) {
	if(isset($_POST['check']) && $_POST['check'] == 'check'){
		//wp_die('<b>Ошибка</b>: Вы робот');
		add_filter('login_errors', 'my_login_errors');
		$username = null;
	}
}

function my_login_errors(){
	return 'Возможно вы робот';
}


function panda_cptcha_login(){
	echo '<p><lable for="check"><input type="checkbox" name="check" id="check" value="check" checked>Снимите галочку</lable></p>';
}




 