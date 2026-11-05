# Drago Project Settings

Settings of the application stored in the database, such as the website name and description, edited in the
administration and available in every template.

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

[Project Tools](https://github.com/drago-ex/project-tools) copies the files of the package into the project,
where you adapt them. It also replaces `Accessory/Widget/@brand.latte` of the layouts once with one that shows
the `website` setting.

## Database

The migration creates the table `settings` (name and value). `bin/project-setup` of Drago Project runs it and asks
for the website name and description; or run `php vendor/bin/migration db:migrate --packages` and add the rows
yourself.

## Administration

```latte
{link :Backend:Settings:}
```

The menu item comes from `Backend/Settings/2.menu.neon` with
[Backend UI](https://github.com/drago-ex/project-backend-ui). The form has a field for every row of `settings`,
labelled by its name. When you add a setting, add the translation of its name to
`Backend/Settings/Translate/cs.neon`.

## Use in Presenters and Templates

Add the trait to a base presenter whose templates need the settings:

```php
use App\Core\Settings\SettingsRequire;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
	use SettingsRequire;
}
```

```latte
{varType App\Core\Settings\Settings $settings}

{$settings->get('website')}
{$settings->get('description')}

{if $settings->has('website')}
	{$settings->get('website')}
{/if}
```

## Permissions

The rules are in `Backend/Settings/acl.neon`: the resource `Backend:Settings`, for the administrator only.
[Project Permission](https://github.com/drago-ex/project-permission) can give the page to other roles.
