<?php
/**
* Login Redirector
*/

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

$redirect_options = [
	'homepage' => elgg_echo('login_redirector:admin:option:homepage'),
];

if (elgg_is_active_plugin('dashboard')) {
	$redirect_options['dashboard'] = elgg_echo('login_redirector:admin:option:dashboard');
}
if (elgg_is_active_plugin('profile')) {
	$redirect_options['profile'] = elgg_echo('login_redirector:admin:option:profile');
}
$redirect_options['custom'] = elgg_echo('login_redirector:admin:option:custom_redirect');

$first_redirect_options = [
	'none' => elgg_echo('login_redirector:admin:option:none'),
] + $redirect_options;

// first login settings
$first_login = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('login_redirector:admin:first_login:config'),
	'name' => 'params[first_login_redirectpage]',
	'options_values' => $first_redirect_options,
	'value' => $plugin->first_login_redirectpage,
]);

$first_login .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('login_redirector:admin:first_login:custom_redirect'),
	'name' => 'params[first_login_custom_redirect]',
	'value' => $plugin->first_login_custom_redirect,
]);

echo elgg_view_module('info', elgg_echo('login_redirector:admin:first_login:title'), $first_login);

// general redirect settings
$general_login = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('login_redirector:admin:config'),
	'name' => 'params[redirectpage]',
	'options_values' => $redirect_options,
	'value' => $plugin->redirectpage,
]);
$general_login .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('login_redirector:admin:custom_redirect'),
	'name' => 'params[custom_redirect]',
	'value' => $plugin->custom_redirect,
]);
$general_login .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('login_redirector:admin:useroverride'),
	'name' => 'params[useroverride]',
	'checked' => $plugin->useroverride === 'yes',
	'switch' => true,
	'default' => 'no',
	'value' => 'yes',
]);

$general_login .= elgg_view_field([
	'#type' => 'plaintext',
	'#label' => elgg_echo('login_redirector:admin:custom_redirect_list'),
	'name' => 'params[custom_redirect_list]',
	'value' => $plugin->custom_redirect_list,
]);

echo elgg_view_module('info', elgg_echo('login_redirector:admin:title'), $general_login);

// help for custom urls
$custom_url_info = [
	elgg_echo('login_redirector:admin:custom_redirect_info'),
	'[wwwroot] = ' . elgg_get_site_url(),
	'[username] = ' .  elgg_get_logged_in_user_entity()->username,
];

echo elgg_view_message('help', implode('<br />', $custom_url_info), ['title' => elgg_echo('login_redirector:admin:custom_redirect_info:title')]);
