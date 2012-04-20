<?php
	/**
	* Login Redirector
	* 
	* @package login_redirector
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$plugin = $vars["entity"];

	$redirect_options = array();
	$redirect_options["homepage"] = elgg_echo("login_redirector:admin:option:homepage");
	if(elgg_is_active_plugin("dashboard")){
		$redirect_options["dashboard"] = elgg_echo("login_redirector:admin:option:dashboard");
	}
	if(elgg_is_active_plugin("profile")){
		$redirect_options["profile"] = elgg_echo("login_redirector:admin:option:profile");
	}
	$redirect_options["custom"] = elgg_echo("login_redirector:admin:option:custom_redirect");
	
	$first_redirect_options = array("none" => elgg_echo("login_redirector:admin:option:none")) + $redirect_options;
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	$first_login =  elgg_echo("login_redirector:admin:first_login:config") . " ";
	$first_login .= elgg_view("input/dropdown", array("name" => "params[first_login_redirectpage]", "options_values" => $first_redirect_options, "value" => $plugin->first_login_redirectpage)) . "<br />";
	$first_login .= elgg_echo('login_redirector:admin:first_login:custom_redirect');
	$first_login .= elgg_view("input/text", array("name" => "params[first_login_custom_redirect]", "value" => $plugin->first_login_custom_redirect));
	
	echo elgg_view_module("inline", elgg_echo("login_redirector:admin:first_login:title"), $first_login);
	
	$general_login = elgg_echo("login_redirector:admin:config") . " "; 
	$general_login .= elgg_view("input/dropdown", array("name" => "params[redirectpage]", "options_values" => $redirect_options, "value" => $plugin->redirectpage)) . "<br />"; 
	$general_login .= elgg_echo('login_redirector:admin:custom_redirect'); 
	$general_login .= elgg_view("input/text", array("name" => "params[custom_redirect]", "value" => $plugin->custom_redirect)) . "<br />"; 
	$general_login .= elgg_echo('login_redirector:admin:useroverride'); 
	$general_login .= elgg_view("input/dropdown", array("name" => "params[useroverride]", "options_values" => $noyes_options, "value" => $plugin->useroverride)) . "<br />"; 
	$general_login .= elgg_echo('login_redirector:admin:custom_redirect_list');
	$general_login .= elgg_view("input/plaintext", array("name" => "params[custom_redirect_list]", "value" => $plugin->custom_redirect_list));
	
	echo elgg_view_module("inline", elgg_echo("login_redirector:admin:title"), $general_login);
	
	$custom_url_info = elgg_echo('login_redirector:admin:custom_redirect_info');
	$custom_url_info .= "<div>[wwwroot] = " . elgg_get_site_url() . "</div>";
	$custom_url_info .= "<div>[username] = " .  elgg_get_logged_in_user_entity()->username . "</div>";

	echo elgg_view_module("inline", elgg_echo("login_redirector:admin:custom_redirect_info:title"), $custom_url_info);
