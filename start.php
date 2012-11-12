<?php
	/**
	* Login Redirector
	* 
	* @package login_redirector
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	require_once(dirname(__FILE__) . "/lib/events.php");
	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	
	// register default elgg events
	elgg_register_event_handler("init", "system", "login_redirector_init");
	elgg_register_event_handler("pagesetup", "system", "login_redirector_pagesetup");

	function login_redirector_init(){
		// register events
		elgg_register_event_handler("create", "member_of_site", "login_redirector_create_member_of_site_handler");
		elgg_register_event_handler("delete", "member_of_site", "login_redirector_delete_member_of_site_handler");
		
		elgg_register_event_handler("login", "user", "login_redirector_login_handler", 10000); // needs to be last
		
	}
	
	function login_redirector_pagesetup(){
		
		if($user = elgg_get_logged_in_user_entity()){
			$site = elgg_get_site_entity();
			
			// check if this is your first visit to this site
			if(check_entity_relationship($user->getGUID(), "first_login", $site->getGUID())){
				// remove the flag
				remove_entity_relationship($user->getGUID(), "first_login", $site->getGUID());
				
				// is a first login configured
				if($url = login_redirector_get_first_login_url($user)){
					// forward
					forward($url);
				}
			}
		}
	}
