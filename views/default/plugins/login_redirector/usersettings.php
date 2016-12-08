<?php
/**
* Login Redirector
*
* @package login_redirector
* @author ColdTrick IT Solutions
*/

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);
/* @var $page_owner \ElggUser */
$page_owner = elgg_get_page_owner_entity();

if ($plugin->useroverride !== 'yes') {
	return;
}
	
$redirect_options = [];
$redirect_options['homepage'] = elgg_echo('login_redirector:admin:option:homepage');
if (elgg_is_active_plugin('dashboard')) {
	$redirect_options['dashboard'] = elgg_echo('login_redirector:admin:option:dashboard');
}
if (elgg_is_active_plugin('profile')) {
	$redirect_options['profile'] = elgg_echo('login_redirector:admin:option:profile');
}

if ($plugin->redirectpage == 'custom') {
	$custom_redirect = $plugin->custom_redirect;
	if (!empty($custom_redirect)) {
		$custom_redirect = str_ireplace('[wwwroot]', '/', $custom_redirect);
		$custom_redirect = str_ireplace('[username]', elgg_get_logged_in_user_entity()->username, $custom_redirect);
		
		$redirect_options['custom_redirect'] = $custom_redirect;
	}
}

$custom_redirect_list = $plugin->custom_redirect_list;
if (!empty($custom_redirect_list)) {
	
	$custom_list = string_to_tag_array($custom_redirect_list);
	if (!empty($custom_list)) {
		foreach ($custom_list as $custom_link) {
			list($title, $url) = explode('|', $custom_link);
			
			if (!empty($title) && !empty($url)) {
				$redirect_options[$url] = ucwords($title);
			}
		}
	}
}

echo elgg_view_input('select', [
	'label' => elgg_echo('login_redirector:user:config'),
	'name' => 'params[redirectpage]',
	'options_values' => $redirect_options,
	'value' => $plugin->getUserSetting('redirectpage', $page_owner->getGUID()),
]);
