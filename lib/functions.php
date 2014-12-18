<?php
/**
 * All helper functions are bundled here
 */

/**
 * Get the URL for the first login redirect
 *
 * @param ElggUser $user the user to check for
 *
 * @return bool|string
 */
function login_redirector_get_first_login_url(ElggUser $user) {
	$result = false;
	
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $result;
	}
	
	// check if first login is configured
	$pref = elgg_get_plugin_setting("first_login_redirectpage", "login_redirector");
	if (empty($pref) || ($pref === "none")) {
		return $result;
	}
	
	$url = "";
	$site = elgg_get_site_entity();
	
	switch ($pref) {
		case "homepage":
			$url = $site->url;
			break;
		case "profile":
			if (elgg_is_active_plugin("profile")) {
				$url = $site->url . "profile/" . $user->username;
			}
			break;
		case "dashboard":
			if (elgg_is_active_plugin("dashboard")) {
				$url = $site->url . "dashboard";
			}
			break;
		case "custom":
			if ($custom = elgg_get_plugin_setting("first_login_custom_redirect", "login_redirector")) {
				$url = str_ireplace("[wwwroot]", $site->url, $custom);
				$url = str_ireplace("[username]", $user->username, $url);
			}
			break;
	}
		
	if (!empty($url)) {
		$result = elgg_normalize_url($url);
	}
	
	return $result;
}

/**
* Returns the redirect url after login
*
* @param ElggUser $user the user to check
*
* @return bool|string
*/
function login_redirector_get_general_login_url(ElggUser $user) {
	$result = false;

	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $result;
	}
	
	$pref = "";
	$url = "";
	$site = elgg_get_site_entity();
	
	if (elgg_get_plugin_setting("useroverride", "login_redirector") == "yes") {
		$pref = elgg_get_plugin_user_setting("redirectpage", $user->getGUID(), "login_redirector");
	}
	
	if (empty($pref)) {
		$pref = elgg_get_plugin_setting("redirectpage", "login_redirector");
	}

	switch ($pref) {
		case "homepage":
			$url = $site->url;
			break;
		case "profile":
			if (elgg_is_active_plugin("profile")) {
				$url = $site->url . "profile/" . $user->username;
			}
			break;
		case "dashboard":
			if (elgg_is_active_plugin("dashboard")) {
				$url = $site->url . "dashboard";
			}
			break;
		case "custom":
			if ($custom = elgg_get_plugin_setting("custom_redirect", "login_redirector")) {
				$url = str_ireplace("[wwwroot]", $site->url, $custom);
				$url = str_ireplace("[username]", $user->username, $url);
			}
			break;
		default:
			if (!empty($pref)) {
				$url = str_ireplace("[wwwroot]", $site->url, $pref);
				$url = str_ireplace("[username]", $user->username, $url);
			}
			break;
	}
		
	if (!empty($url)) {
		// set the redirect url correctly
		$result = elgg_normalize_url($url);
	}
	
	return $result;
}
	