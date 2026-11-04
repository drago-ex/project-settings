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

The package also replaces the brand of the layouts, `app/Presentation/Accessory/Widget/@brand.latte` of
[drago-ex/project-auth](https://github.com/drago-ex/project-auth), with one that shows the `website` setting (the default
name without it). It is replaced once; a later update keeps your changes.

## Administration

The settings page is available as:

```latte
{link :Backend:Settings:}
```

With [drago-ex/project-backend-ui](https://github.com/drago-ex/project-backend-ui), the page gets its menu item from `Backend/Settings/2.menu.neon`.

The form has a field for every row of the `settings` table, labelled by its name (`website`, `description`). The
labels are translated: when you add a setting to the database, add the translation of its name to
`app/Presentation/Backend/Settings/Translate/cs.neon`, otherwise the field shows the name itself.

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

## Access rules

The access rules are in `app/Presentation/Backend/Settings/acl.neon`: the resource `Backend:Settings`, for the administrator only.
[drago-ex/permission](https://github.com/drago-ex/permission) merges them with its base roles, in which the administrator is allowed everything.
