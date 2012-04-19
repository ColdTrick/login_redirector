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
	$redirect_options["dashboard"] = elgg_echo("login_redirector:admin:option:dashboard");
	if(is_plugin_enabled("profile")){
		$redirect_options["profile"] = elgg_echo("login_redirector:admin:option:profile");
	}
	$redirect_options["custom"] = elgg_echo("login_redirector:admin:option:custom_redirect");
	
	$first_redirect_options = array("none" => elgg_echo("login_redirector:admin:option:none")) + $redirect_options;
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
?>
<h3 class="settings"><?php echo elgg_echo("login_redirector:admin:first_login:title"); ?></h3>
<div>
	<?php 
		echo elgg_echo("login_redirector:admin:first_login:config"); 
		echo " " . elgg_view("input/pulldown", array("internalname" => "params[first_login_redirectpage]", "options_values" => $first_redirect_options, "value" => $plugin->first_login_redirectpage));
	?>
</div>
<div>
	<div><?php echo elgg_echo('login_redirector:admin:first_login:custom_redirect'); ?></div>
	<?php echo elgg_view("input/text", array("internalname" => "params[first_login_custom_redirect]", "value" => $plugin->first_login_custom_redirect)); ?><br />
</div>
<h3 class="settings"><?php echo elgg_echo("login_redirector:admin:title"); ?></h3>
<div>
	<?php 
		echo elgg_echo("login_redirector:admin:config"); 
		echo " " . elgg_view("input/pulldown", array("internalname" => "params[redirectpage]", "options_values" => $redirect_options, "value" => $plugin->redirectpage));
	?>
</div>
<div>
	<div><?php echo elgg_echo('login_redirector:admin:custom_redirect'); ?></div>
	<?php echo elgg_view("input/text", array("internalname" => "params[custom_redirect]", "value" => $plugin->custom_redirect)); ?><br />
</div>
<br />

<div>
	<?php 
		echo elgg_echo('login_redirector:admin:useroverride'); 
		echo " " . elgg_view("input/pulldown", array("internalname" => "params[useroverride]", "options_values" => $noyes_options, "value" => $plugin->useroverride));
	?>
</div>
<br />

<div>
	<div><?php echo elgg_echo('login_redirector:admin:custom_redirect_list'); ?></div>
	<?php echo elgg_view("input/plaintext", array("internalname" => "params[custom_redirect_list]", "value" => $plugin->custom_redirect_list)); ?>
</div>

<h3 class="settings"><?php echo elgg_echo('login_redirector:admin:custom_redirect_info:title'); ?></h3>
<div>
	<?php echo elgg_echo('login_redirector:admin:custom_redirect_info'); ?>
	<br />
	[wwwroot] = <?php echo $vars["url"]; ?><br />
	[username] = <?php echo get_loggedin_user()->username; ?>
</div>