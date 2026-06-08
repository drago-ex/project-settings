# Drago Project settings

Individual settings for the application.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/drago-ex/project-settings/blob/main/license)
[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-settings.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-settings)
[![Coding Style](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml)

## Requirements
- PHP >= 8.3
- Nette Framework
- Composer
- Drago Project core packages

## Installation
```bash
composer require drago-ex/project-settings
```

## Project files
File copying is handled automatically by [drago-ex/project-tools](https://github.com/drago-ex/project-tools),
which must be installed in your project. Without it, copy the files manually according to the `copy` section
in this package's `composer.json`. To skip this package, set `"skip": true` under
`extra.drago-tools.packages.<package-name>` in your root `composer.json`.

## Use in the presenter
```php
use App\Core\Settings\SettingsRequire;
```

## Use in latte template
```latte
{varType App\Core\Settings\Settings $settings}

{* website name *}
{$settings->get('website')}

{* website description *}
{$settings->get('description')}

{if $settings->has('website')}
	{$settings->get('website')}
{/if}
```

We can customize the settings according to our needs.

## Administration form
The package also provides a simple settings form component.

```php
use App\Core\Settings\Factory\SettingsControl;
use App\Core\Settings\SettingsRepository;

public function __construct(
	private readonly SettingsRepository $settingsRepository,
) {
	parent::__construct();
}

protected function createComponentSettings(): SettingsControl
{
	return new SettingsControl(
		settingsRepository: $this->settingsRepository,
	);
}
```

Render it in a Latte template:

```latte
{control settings}
```
