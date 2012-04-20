<?php
	$english = array(
		// Main title
		'login_redirector' => "Login Redirector",
		
		// Admin configuration
		'login_redirector:admin:first_login:title' => "First login redirect settings",	
		'login_redirector:admin:title' => "General login redirect settings",
	
		'login_redirector:admin:first_login:config' => "Select the page users will go to after their first login:",
		'login_redirector:admin:first_login:custom_redirect' => "Enter a custom redirect here:",
		
		'login_redirector:admin:config' => "Select the page users will go to after they are logged in:",
		'login_redirector:admin:option:none' => "No redirect on first login",
		'login_redirector:admin:option:profile' => "User's Profile",
		'login_redirector:admin:option:dashboard' => "Dashboard",
		'login_redirector:admin:option:homepage' => "Homepage",
		'login_redirector:admin:option:custom_redirect' => "Use custom redirect",
	
		'login_redirector:admin:useroverride' => "Is a user permitted to override this setting?",
	
		'login_redirector:admin:custom_redirect' => "Enter a custom redirect here",
		'login_redirector:admin:custom_redirect_info:title' => "Custom URL options",
		'login_redirector:admin:custom_redirect_info' => "To redirect a user to a site or page of your liking, enter the custom url.<br />Enter the complete url (including http or https) or use one of the following shortcuts (including brackets):",
		
		'login_redirector:admin:custom_redirect_list' => "Add custom pages for the users to select from (comma seperated, in the format: title|url)",
	
		'login_redirector:user:config' => "Select the page you will go to after you are logged in:",
		
	);
	
	add_translation("en", $english);
?>