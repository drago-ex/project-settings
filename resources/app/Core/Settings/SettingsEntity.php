<?php

declare(strict_types=1);

namespace App\Core\Settings;

use Drago\Database\Entity;


class SettingsEntity extends Entity
{
	public const string
		Table = 'settings',
		ColumnName = 'name',
		ColumnValue = 'value';

	public string $name;
	public string $value;
}
