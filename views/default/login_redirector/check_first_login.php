<?php
/**
 * Check if we need to redirect your first login
 */

$user = elgg_get_logged_in_user_entity();
if (empty($user)) {
	return;
}

$session = elgg_get_session();
if ($session->has('login_redirector_first_login_check')) {
	return;
}
// don't check again this session
$session->set('login_redirector_first_login_check', true);

$site = elgg_get_site_entity();
// check if this is your first visit to this site
if (!check_entity_relationship($user->getGUID(), 'first_login', $site->getGUID())) {
	return;
}

// remove the flag
remove_entity_relationship($user->getGUID(), 'first_login', $site->getGUID());

// is a first login configured
$url = login_redirector_get_first_login_url($user);
if (!empty($url)) {
	// forward
	forward($url);
}
