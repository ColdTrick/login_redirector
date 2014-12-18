<?php
/**
 * All event handlers are bundled here
 */

/**
 * This events handles the join of a site, we need to redirect you when you first go to the site
 *
 * @param string           $event  the name of the event
 * @param string           $type   the type of the event
 * @param ElggRelationship $object supplied object
 *
 * @return void
 */
function login_redirector_create_member_of_site_handler($event, $type, $object) {
	
	if (empty($object) || !($object instanceof ElggRelationship)) {
		return;
	}
	
	if ($object->relationship !== "member_of_site") {
		return;
	}
	
	$user_guid = $object->guid_one;
	$site_guid = $object->guid_two;
	
	if (empty($user_guid) || empty($site_guid)) {
		return;
	}
	
	// add a flag so we can redirect you when you first visit the site
	add_entity_relationship($user_guid, "first_login", $site_guid);
}

/**
 * This event handles the leaving of a site, if you leave the site and you hadn't yet login there we need to remove the flag
 *
 * @param string           $event  the name of the event
 * @param string           $type   the type of the event
 * @param ElggRelationship $object supplied object
 *
 * @return void
 */
function login_redirector_delete_member_of_site_handler($event, $type, $object) {
	
	if (empty($object) || !($object instanceof ElggRelationship)) {
		return;
	}
	
	if ($object->relationship !== "member_of_site") {
		return;
	}
	
	$user_guid = $object->guid_one;
	$site_guid = $object->guid_two;
		
	if (empty($user_guid) || empty($site_guid)) {
		return;
	}
	
	// do you have a flag for first login
	if (check_entity_relationship($user_guid, "first_login", $site_guid)) {
		// remove this flag
		remove_entity_relationship($user_guid, "first_login", $site_guid);
	}
}

/**
 * Listen to the login event to set the correct redirect
 *
 * @param string   $event the name of the event
 * @param string   $type  the type of the event
 * @param ElggUser $user  supplied user
 *
 * @return void
 */
function login_redirector_login_handler($event, $type, $user) {
	
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return;
	}
	
	$site = elgg_get_site_entity();
	
	// first login? And no flag
	if (empty($user->last_login) && !check_entity_relationship($user->getGUID(), "first_login", $site->getGUID())) {
		// set flag
		add_entity_relationship($user->getGUID(), "first_login", $site->getGUID());
	} elseif (!empty($user->last_login) && empty($_SESSION["last_forward_from"])) {
		elgg_register_plugin_hook_handler("forward", "system", "login_redirector_forward_hook");
	}
}
