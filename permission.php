<?php

declare(strict_types=1);

/**
 * Basic access rules of this package for drago-ex/permission.
 * Generated into the project by: php vendor/bin/create-permission --packages
 */
return [
	// Registers the settings; administrators are allowed everything.
	[
		'className' => 'PermissionProvider',
		'namespace' => 'App\Presentation\Backend\Settings',
		'resource' => 'Backend:Settings',
		'outputDir' => 'app/Presentation/Backend/Settings',
		'allow' => ['RoleAdmin'],
	],
];
