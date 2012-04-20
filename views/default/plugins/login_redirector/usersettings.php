<?php
	/**
	* Login Redirector
	* 
	* @package login_redirector
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	$plugin = $vars["entity"];

	if($plugin->useroverride == "yes"){
		
		$redirect_options = array();
		$redirect_options["homepage"] = elgg_echo('login_redirector:admin:option:homepage');
		if(elgg_is_active_plugin("dashboard")){
			$redirect_options["dashboard"] = elgg_echo('login_redirector:admin:option:dashboard');
		}
		if(elgg_is_active_plugin("profile")){
			$redirect_options["profile"] = elgg_echo('login_redirector:admin:option:profile');
		}
		
		if($plugin->redirectpage == "custom"){
			if($custom_redirect = $plugin->custom_redirect){
				$custom_redirect = str_ireplace("[wwwroot]", "/", $custom_redirect);
				$custom_redirect = str_ireplace("[username]", elgg_get_logged_in_user_entity()->username, $custom_redirect);
				$redirect_options["custom_redirect"] = $custom_redirect;
			}
		}
		
		if($custom_redirect_list = $plugin->custom_redirect_list){
			
			if($custom_list = string_to_tag_array($custom_redirect_list)){
				foreach($custom_list as $custom_link){
					list($title, $url) = explode("|", $custom_link);
					
					if(!empty($title) && !empty($url)){
						$redirect_options[$url] = ucwords($title);
					}
				}
			}
		}
		
		echo "<div>";
		echo elgg_echo('login_redirector:user:config') . " ";
		echo elgg_view("input/dropdown", array("name" => "params[redirectpage]", "options_values" => $redirect_options, "value" => $plugin->getUserSetting("redirectpage", elgg_get_page_owner_guid())));
		echo "</div>";
	}