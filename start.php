<?php
	/**
	* Login Redirector
	* 
	* @package login_redirector
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	function login_redirector_login_handler($event, $type, $entity)	{
		
		if(empty($_SESSION['last_forward_from']) && !empty($entity) && ($entity instanceof ElggUser)){
			
			if(!empty($entity->last_login)){
				if((get_plugin_setting("useroverride", "login_redirector") == 'yes') && (get_plugin_setting("redirectpage","login_redirector") != "custom")){
					
					if($userpref = get_plugin_usersetting("redirectpage", $entity->getGUID(), "login_redirector")){
						$username = $user->username;
						
						switch($userpref){
							case "hoempage":
								$url = $CONFIG->wwwroot;
								break;
							case "profile":
								if(is_plugin_enabled("profile")){
									$url = $CONFIG->wwwroot . "pg/profile/" . $username;
									break;
								}
							case "dashboard":
								$url = $CONFIG->wwwroot . "pg/dashboard";
								break;
							default:
								$url = $userpref;
								$url = str_replace("[wwwroot]", $CONFIG->wwwroot, $url);
								$url = str_replace("[username]", $username, $url);
								break;
						}
						
						$_SESSION['last_forward_from'] = $url;
					} else {
						login_redirector_default_options($entity);
					}
				} else {
					login_redirector_default_options($entity);
				}
			} else {
				login_redirector_default_options($entity, true);
			}
		}
	}
	
	function login_redirector_default_options(ElggUser $user, $first_login = false){
		global $CONFIG;
		
		if(!empty($user) && ($user instanceof ElggUser)){
			
			if($first_login){
				if(($pref = get_plugin_setting("first_login_redirectpage", "login_redirector")) && ($pref == "none")){
					$pref = get_plugin_setting("redirectpage", "login_redirector");
				}
			} else {
				$pref = get_plugin_setting("redirectpage", "login_redirector");
			}
			
			$username = $user->username;
			
			switch($pref){
				case "hoempage":
					$url = $CONFIG->wwwroot;
					break;
				case "profile":
					if(is_plugin_enabled("profile")){
						$url = $CONFIG->wwwroot . "pg/profile/" . $username;
						break;
					}
				case "custom":
					if($first_login){
						$custom = get_plugin_setting("first_login_custom_redirect", "login_redirector");
					} else {
						$custom = get_plugin_setting("custom_redirect", "login_redirector");
					}
					
					if(!empty($custom)){
						$url = str_replace("[wwwroot]", $CONFIG->wwwroot, $custom);
						$url = str_replace("[username]", $username, $url);
						break;
					}
				case "dashboard":
				default:
					$url = $CONFIG->wwwroot . "pg/dashboard";
					break;
			}
			
			$_SESSION['last_forward_from'] = $url;
		}				
	}

	register_elgg_event_handler('login','user','login_redirector_login_handler');
?>