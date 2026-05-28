<?php

declare(strict_types=1);

namespace App\Core\Settings;


/** Website configuration (name, description) etc. */
class Settings
{
	public string $website;
	public string $description;


	public function __construct(
		string $website,
		string $description,
	) {
		$this->website = $website;
		$this->description = $description;
	}
}
