<?php
/**
 * All helper functions are bundled here
 */

/**
 * Get the URL for the first login redirect
 *
 * @param ElggUser $user the user to check for
 *
 * @return false|string
 */
function login_redirector_get_first_login_url(ElggUser $user) {
	
	if (!($user instanceof ElggUser)) {
		return false;
	}
	
	// check if first login is configured
	$pref = elgg_get_plugin_setting('first_login_redirectpage', 'login_redirector');
	if (empty($pref) || ($pref === 'none')) {
		return false;
	}
	
	$url = '';
	$site = elgg_get_site_entity();
	
	switch ($pref) {
		case 'homepage':
			$url = $site->getURL();
			break;
		case 'profile':
			if (elgg_is_active_plugin('profile')) {
				$url = "profile/{$user->username}";
			}
			break;
		case 'dashboard':
			if (elgg_is_active_plugin('dashboard')) {
				$url = 'dashboard';
			}
			break;
		case 'custom':
			$custom = elgg_get_plugin_setting('first_login_custom_redirect', 'login_redirector');
			if (!empty($custom)) {
				$url = str_ireplace('[wwwroot]', $site->getURL(), $custom);
				$url = str_ireplace('[username]', $user->username, $url);
			}
			break;
	}
		
	if (!empty($url)) {
		return elgg_normalize_url($url);
	}
	
	return false;
}

/**
* Returns the redirect url after login
*
* @param ElggUser $user the user to check
*
* @return false|string
*/
function login_redirector_get_general_login_url(ElggUser $user) {
	
	if (!($user instanceof ElggUser)) {
		return false;
	}
	
	$pref = '';
	$url = '';
	$site = elgg_get_site_entity();
	
	if (elgg_get_plugin_setting('useroverride', 'login_redirector') == 'yes') {
		$pref = elgg_get_plugin_user_setting('redirectpage', $user->getGUID(), 'login_redirector');
	}
	
	if (empty($pref)) {
		$pref = elgg_get_plugin_setting('redirectpage', 'login_redirector');
	}
	
	switch ($pref) {
		case 'homepage':
			$url = $site->getURL();
			break;
		case 'profile':
			if (elgg_is_active_plugin('profile')) {
				$url = "profile/{$user->username}";
			}
			break;
		case 'dashboard':
			if (elgg_is_active_plugin('dashboard')) {
				$url = 'dashboard';
			}
			break;
		case 'custom':
			$custom = elgg_get_plugin_setting('custom_redirect', 'login_redirector');
			if (!empty($custom)) {
				$url = str_ireplace('[wwwroot]', $site->getURL(), $custom);
				$url = str_ireplace('[username]', $user->username, $url);
			}
			break;
		default:
			if (!empty($pref)) {
				$url = str_ireplace('[wwwroot]', $site->getURL(), $pref);
				$url = str_ireplace('[username]', $user->username, $url);
			}
			break;
	}
		
	if (!empty($url)) {
		// set the redirect url correctly
		return elgg_normalize_url($url);
	}
	
	return false;
}
