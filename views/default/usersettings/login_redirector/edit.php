<?php
	/**
	* Login Redirector
	* 
	* @package login_redirector
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	if((get_plugin_setting("useroverride", "login_redirector") == "yes") && (get_plugin_setting("redirectpage", "login_redirector") != "custom")){
		$plugin = $vars["entity"];
		
		$redirect_options = array();
		$redirect_options["homepage"] = elgg_echo('login_redirector:admin:option:homepage');
		$redirect_options["dashboard"] = elgg_echo('login_redirector:admin:option:dashboard');
		if(is_plugin_enabled("profile")){
			$redirect_options["profile"] = elgg_echo('login_redirector:admin:option:profile');
		}
		
		if($custom_redirect_list = get_plugin_setting("custom_redirect_list", "login_redirector")){
			$custom_list = string_to_tag_array($custom_redirect_list);
			
			if(!empty($custom_list)){
				foreach($custom_list as $custom_link){
					list($title, $url) = explode("|", $custom_link);
					
					if(!empty($title) && !empty($url)){
						$redirect_options[$url] = ucwords($title);
					}
				}
			}
		}
		
		echo "<div>" . elgg_echo('login_redirector:user:config') . "</div>";
		echo elgg_view("input/pulldown", array("internalname" => "params[redirectpage]", "options_values" => $redirect_options, "value" => $plugin->redirectpage));
		
	}
?>