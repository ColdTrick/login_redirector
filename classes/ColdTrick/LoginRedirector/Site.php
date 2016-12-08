<?php

namespace ColdTrick\LoginRedirector;

class Site {
	
	/**
	 * This events handles the joining of a site, we need to redirect you when you first go to the site
	 *
	 * @param string            $event  the name of the event
	 * @param string            $type   the type of the event
	 * @param \ElggRelationship $object supplied object
	 *
	 * @return void
	 */
	public static function createMemberOfSite($event, $type, $object) {
		
		if (!($object instanceof \ElggRelationship)) {
			return;
		}
		
		if ($object->relationship !== 'member_of_site') {
			return;
		}
		
		$user_guid = $object->guid_one;
		$site_guid = $object->guid_two;
		if (empty($user_guid) || empty($site_guid)) {
			return;
		}
		
		// add a flag so we can redirect you when you first visit the site
		add_entity_relationship($user_guid, 'first_login', $site_guid);
	}
	
	/**
	 * This event handles the leaving of a site, if you leave the site and you hadn't yet login there we need to remove the flag
	 *
	 * @param string            $event  the name of the event
	 * @param string            $type   the type of the event
	 * @param \ElggRelationship $object supplied object
	 *
	 * @return void
	 */
	public static function deleteMemberOfSite($event, $type, $object) {
		
		if (!($object instanceof \ElggRelationship)) {
			return;
		}
		
		if ($object->relationship !== 'member_of_site') {
			return;
		}
		
		$user_guid = $object->guid_one;
		$site_guid = $object->guid_two;
		if (empty($user_guid) || empty($site_guid)) {
			return;
		}
		
		// remove this flag
		remove_entity_relationship($user_guid, 'first_login', $site_guid);
	}
}
