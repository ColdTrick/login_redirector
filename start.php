<?php
	/**
	* Login Redirector
	* 
	* @package login_redirector
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	/**
	 * Handles the login event and determines if login director should controle the next page
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $type
	 * @param unknown_type $entity
	 */
	function login_redirector_login_handler($event, $type, $entity)	{
		
		if(empty($_SESSION['last_forward_from']) && !empty($entity) && ($entity instanceof ElggUser)){
			elgg_register_plugin_hook_handler("forward", "system", "login_redirector_forward_hook");
		}
	}
	
	/**
	 * Hook on forward to allow forwarding to login_redirector url
	 * 
	 * @param unknown_type $hook_name
	 * @param unknown_type $entity_type
	 * @param unknown_type $return_value
	 * @param unknown_type $params
	 */
	function login_redirector_forward_hook($hook_name, $entity_type, $return_value, $params){
		if($user = elgg_get_logged_in_user_entity()){
			if(empty($user->last_login)){
				$forward_url = login_redirector_first_login($user);
				if(empty($forward_url)){
					$forward_url = login_redirector_general_login($user);
				}
			} else {
				$forward_url = login_redirector_general_login($user);
			}
			
			if(!empty($forward_url)){
				return $forward_url;
			}
		}
	}
	
	/**
	 * Returns the forward url for a first login
	 * 
	 * @param ElggUser $user
	 * @return false | string forward url
	 */
	function login_redirector_first_login(ElggUser $user){
		$result = false;
		
		$plugin = elgg_get_plugin_from_id("login_redirector");
		
		$pref = $plugin->first_login_redirectpage;
		if(!empty($pref) && $pref !== "none"){
			
			switch($pref){
				case "homepage":
					$url = elgg_get_site_url();
					break;
				case "profile":
					if(elgg_is_active_plugin("profile")){
						$url = elgg_get_site_url() . "profile/" . $user->username;
					}
					break;
				case "dashboard":
					if(elgg_is_active_plugin("dashboard")){
						$url = elgg_get_site_url() . "dashboard";
					}
					break;
				case "custom":
					if($custom = $plugin->first_login_custom_redirect){
						$url = str_ireplace("[wwwroot]", elgg_get_site_url(), $custom);
						$url = str_ireplace("[username]", $user->username, $url);
					}
					break;
			}
			
			if($url){
				$result = elgg_normalize_url($url);
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns the redirect url after login
	 * 
	 * @param ElggUser $user
	 * @return false | string forward url
	 */
	function login_redirector_general_login(ElggUser $user){
		$result = false;
		
		$plugin = elgg_get_plugin_from_id("login_redirector");
		
		if($plugin->useroverride == 'yes'){
			$pref = $plugin->getUserSetting("redirectpage", $user->getGUID());
		} 
		
		if(empty($pref)){
			$pref = $plugin->redirectpage;
		}
		
		switch($pref){
			case "homepage":
				$url = elgg_get_site_url();
				break;
			case "profile":
				if(elgg_is_active_plugin("profile")){
					$url = elgg_get_site_url() . "profile/" . $user->username;
				}
				break;
			case "dashboard":
				if(elgg_is_active_plugin("dashboard")){
					$url = elgg_get_site_url() . "dashboard";
				}
				break;
			case "custom":
				if($custom = $plugin->first_login_custom_redirect){
					$url = str_ireplace("[wwwroot]", elgg_get_site_url(), $custom);
					$url = str_ireplace("[username]", $user->username, $url);
				}
				break;
			default:
				if(!empty($pref)){
					$url = str_ireplace("[wwwroot]", elgg_get_site_url(), $pref);
					$url = str_ireplace("[username]", $user->username, $url);
				}
				break;
		}
			
		if($url){
			// set the redirect url correctly
			$result = elgg_normalize_url($url);
		}
		
		return $result;
	}

	elgg_register_event_handler('login','user','login_redirector_login_handler');