# Drago Project Settings

Settings of the application stored in the database, such as the website name and description, edited in the
administration and available in every template.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-settings.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-settings)
[![Tests](https://github.com/drago-ex/project-settings/actions/workflows/tests.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/tests.yml)
[![Coding Style](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml)

## Requirements

- PHP >= 8.3, < 9
- MySQL or MariaDB
- [Drago Project](https://github.com/drago-ex/project)

## Installation

```bash
composer require drago-ex/project-settings
```

[Project Tools](https://github.com/drago-ex/project-tools) copies the files of the package into the project,
where you adapt them. It also replaces `Accessory/Widget/@brand.latte` of the layouts once with one that shows
the `website` setting.

## Database

The migration creates the table `settings` (name and value), empty:

```bash
php vendor/bin/migration db:migrate --packages
```

Then add the website name and description:

```sql
INSERT INTO settings (name, value) VALUES ('website', 'My website'), ('description', 'What the website is about');
```

> [!WARNING]
> Without these rows the settings page of the administration shows an empty form: it edits only the settings that
> exist and does not create them, so the name and the description cannot be set there.

`bin/project-setup` of Drago Project does both steps for you: it runs the migration and, in a terminal, asks for the
name and the description.

## Administration

```latte
{link :Backend:Settings:}
```

The menu item comes from `Backend/Settings/2.menu.neon` with
[Backend UI](https://github.com/drago-ex/project-backend-ui). The form has a field for every row of `settings`,
labelled by its name; it does not create rows (see [Database](#database)). Add another setting as a row, e.g. by an
`INSERT` in a migration of your project (`migrations/`), and the translation of its name to
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

and the property to the template class of those presenters (the trait sets it before rendering; without it PHP
reports a dynamic property):

```php
use App\Core\Settings\Settings;
use Drago\Application\UI\ExtraTemplate;

abstract class BaseTemplate extends ExtraTemplate
{
	public Settings $settings;
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

The same file describes the privileges (`permissionLabels`) for the permissions page of [Project Permission](https://github.com/drago-ex/project-permission).
