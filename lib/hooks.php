<?php

	/**
	* Hook on forward to allow forwarding to login_redirector url
	*
	* @param string $hook_name
	* @param string $entity_type
	* @param string $return_value
	* @param array $params
	*/
	function login_redirector_forward_hook($hook_name, $entity_type, $return_value, $params){
		$result = $return_value;
		
		if($user = elgg_get_logged_in_user_entity()){
				
			if($forward_url = login_redirector_get_general_login_url($user)){
				$result = $forward_url;
			}
		}
		
		return $result;
	}