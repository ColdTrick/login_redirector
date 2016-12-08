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
	public static function loginEvent($event, $type, $user) {
		
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		$site = elgg_get_site_entity();
		$session = elgg_get_session();
		
		// first login? And no flag
		if (empty($user->last_login) && !check_entity_relationship($user->getGUID(), 'first_login', $site->getGUID())) {
			// set flag
			add_entity_relationship($user->getGUID(), 'first_login', $site->getGUID());
		} elseif (!empty($user->last_login) && empty($session->get('last_forward_from'))) {
			elgg_register_plugin_hook_handler('login:forward', 'user', '\ColdTrick\LoginRedirector\Login::forward');
		}
	}
	
	/**
	 * Change the forward URL after login
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function forward($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('user', $params);
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		$forward_url = login_redirector_get_general_login_url($user);
		if (!empty($forward_url)) {
			return $forward_url;
		}
	}
}
