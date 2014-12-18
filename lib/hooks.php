<?php
/**
 * All plugin hooks are bundled her
 */

/**
* Hook on forward to allow forwarding to login_redirector url
*
* @param string $hook_name    the name of the hook
* @param string $entity_type  the type of the hook
* @param string $return_value current return value
* @param array  $params       supplied params
*
* @return string
*/
function login_redirector_forward_hook($hook_name, $entity_type, $return_value, $params) {
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $return_value;
	}
	
	$forward_url = login_redirector_get_general_login_url($user);
	if (!empty($forward_url)) {
		$return_value = $forward_url;
	}
	
	return $return_value;
}