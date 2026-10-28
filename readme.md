# Drago Project settings

Individual settings for the application.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-settings.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-settings)
[![Tests](https://github.com/drago-ex/project-settings/actions/workflows/tests.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/tests.yml)
[![Coding Style](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml)

## Requirements

- PHP >= 8.3, < 9
- [Drago Project](https://github.com/drago-ex/project)

## Installation

```bash
composer require drago-ex/project-settings
```

## Files copied into the project

The files are copied into the project by [drago-ex/project-tools](https://github.com/drago-ex/project-tools),
as set in `extra.drago-tools` of this package's `composer.json`.

## Administration

The settings page is available as:

```latte
{link :Backend:Settings:}
```

With [drago-ex/project-backend-ui](https://github.com/drago-ex/project-backend-ui), add the links to its menu (see its README).

## Use in the presenter

Add the trait to a base presenter whose templates need application settings:

```php
use App\Core\Settings\SettingsRequire;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
	use SettingsRequire;
}
```

## Use in Latte template

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

---

## Optional add-ons

The package works without them. Set them up by hand as described below when the project needs them.

### Permission provider

With [drago-ex/permission](https://github.com/drago-ex/permission), the access rules from [`bin/create-settings-permission`](bin/create-settings-permission)
are generated into the project by:

```bash
php vendor/bin/drago-commands
```
