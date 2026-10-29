<?php declare(strict_types=1);

namespace App\Presentation\Backend\Settings;

use App\Presentation\Backend\BackendTemplate;


class SettingsTemplate extends BackendTemplate
{
	/** @var list<string> names of the form controls, one per setting */
	public array $settingControls = [];
}
