<?php

namespace ColdTrick\LoginRedirector;

class Login {
	
	/**
	 * Listen to the login event
	 *
	 * @param string    $event the name of the event
	 * @param string    $type  the type of the event
	 * @param \ElggUser $user  the user logging in
	 *
	 * @return void
	 */
// 	public static function loginEvent($event, $type, $user) {
		
// 		if (!($user instanceof \ElggUser)) {
// 			return;
// 		}
		
// 		$site = elgg_get_site_entity();
// 		$session = elgg_get_session();
		
// 		// first login? And no flag
// 		if (empty($user->last_login) && !check_entity_relationship($user->getGUID(), 'first_login', $site->getGUID())) {
// 			// set flag
// 			add_entity_relationship($user->getGUID(), 'first_login', $site->getGUID());
// 		} elseif (!empty($user->last_login) && empty($session->get('last_forward_from'))) {
			
// 		}
// 	}
	
	/**
	 * Change the forward URL after login
	 *
	 * @param \Elgg\Hook $hook the hook
	 *
	 * @return void|string
	 */
	public static function forward(\Elgg\Hook $hook) {
		
		$user = $hook->getUserParam();
		if (!$user instanceof \ElggUser) {
			return;
		}
		
		// respect last forward from
		if ($hook->getParam('source') === 'last_forward_from') {
			return;
		}
		
		$forward_url = '';
		if (empty($user->prev_last_login)) {
			$forward_url = self::getFirstLoginURL($user);
		}
		
		if (empty($forward_url)) {
			$forward_url = self::getGeneralLoginURL($user);
		}
		
		if (!empty($forward_url)) {
			return $forward_url;
		}
	}
	
	/**
	* Returns the redirect url after login
	*
	* @param ElggUser $user the user to check
	*
	* @return false|string
	*/
	protected static function getGeneralLoginURL(\ElggUser $user) {
		
		$pref = '';
		$url = '';
		
		if (elgg_get_plugin_setting('useroverride', 'login_redirector') == 'yes') {
			$pref = elgg_get_plugin_user_setting('redirectpage', $user->guid, 'login_redirector');
		}
		
		if (empty($pref)) {
			$pref = elgg_get_plugin_setting('redirectpage', 'login_redirector');
		}
		
		switch ($pref) {
			case 'homepage':
				$url = elgg_get_site_url();
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
					$url = str_ireplace('[wwwroot]', elgg_get_site_url(), $custom);
					$url = str_ireplace('[username]', $user->username, $url);
				}
				break;
			default:
				if (!empty($pref)) {
					$url = str_ireplace('[wwwroot]', elgg_get_site_url(), $pref);
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
	
	/**
	 * Get the URL for the first login redirect
	 *
	 * @param ElggUser $user the user to check for
	 *
	 * @return false|string
	 */
	protected static function getFirstLoginURL(\ElggUser $user) {
		
		// check if first login is configured
		$pref = elgg_get_plugin_setting('first_login_redirectpage', 'login_redirector');
		if (empty($pref) || ($pref === 'none')) {
			return false;
		}
		
		$url = '';
		switch ($pref) {
			case 'homepage':
				$url = elgg_get_site_url();
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
					$url = str_ireplace('[wwwroot]', elgg_get_site_url(), $custom);
					$url = str_ireplace('[username]', $user->username, $url);
				}
				break;
		}
			
		if (!empty($url)) {
			return elgg_normalize_url($url);
		}
		
		return false;
	}
}
