<?php

declare(strict_types=1);

namespace App\Core\Settings\Factory;

use Drago\Application\UI\ExtraTemplate;


class SettingsTemplate extends ExtraTemplate
{
	/** @var array<string, string> */
	public array $inputsSettings = [];
}
