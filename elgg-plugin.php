<?php

return [
	'hooks' => [
		'login:forward' => [
			'user' => [
				'\ColdTrick\LoginRedirector\Login::forward' => [],
			],
		],
	],
];
