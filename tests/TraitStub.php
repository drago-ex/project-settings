<?php declare(strict_types=1);

use App\Core\Settings\SettingsRequire;


/** Lets PHPStan analyse the SettingsRequire trait, which no class in the package uses. */
class TraitStub
{
	use SettingsRequire;
}
