<?php
/**
* Login Redirector
*
* @package login_redirector
* @author ColdTrick IT Solutions
*/

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default elgg events
elgg_register_event_handler('init', 'system', 'login_redirector_init');

/**
 * Gets called during system init
 *
 * @return void
 */
function login_redirector_init() {
	
	// extend views
	elgg_extend_view('page/elements/head', 'login_redirector/check_first_login');
	
	// register events
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\LoginRedirector\Site::createMemberOfSite');
	elgg_register_event_handler('delete', 'relationship', '\ColdTrick\LoginRedirector\Site::deleteMemberOfSite');
	
	elgg_register_event_handler('login', 'user', '\ColdTrick\LoginRedirector\Login::loginEvent', 10000); // needs to be last
}
