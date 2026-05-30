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
The package has `extra.drago-project.skip` set to `false`, so `drago-install` copies the configured files automatically.
If `skip` is set to `true`, copy those files manually according to the `copy` section in `composer.json`.

## Use in the presenter
```php
use use App\Core\Settings\SettingsRequire;
```

## Use in latte template
```latte
{varType App\Core\Settings\Settings $settings}

{* website name *}
{$settings->website}

{* website description *}
{$settings->description}
```

We can customize the settings according to our needs.
