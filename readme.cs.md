# Drago Project settings

Vlastní nastavení aplikace.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-settings.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-settings)
[![Tests](https://github.com/drago-ex/project-settings/actions/workflows/tests.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/tests.yml)
[![Coding Style](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-settings/actions/workflows/coding-style.yml)

## Požadavky

- PHP >= 8.3, < 9
- Nette Framework
- Composer
- Základní balíčky Drago Project

## Instalace

```bash
composer require drago-ex/project-settings
```

## Soubory projektu

Kopírování souborů obstarává automaticky [drago-ex/project-tools](https://github.com/drago-ex/project-tools),
který musí být v projektu nainstalovaný. Bez něj zkopírujte soubory ručně podle sekce `copy`
v `composer.json` tohoto balíčku. Pro přeskočení balíčku nastavte `"skip": true` v
`extra.drago-tools.packages.<package-name>` v kořenovém `composer.json`.

## Administrace

S [drago-ex/project-backend-ui](https://github.com/drago-ex/project-backend-ui) se v postranním menu objeví
položka „Nastavení“ (`Backend/Settings/2.menu.neon`).

## Použití v presenteru

Přidejte trait do základního presenteru, jehož šablony potřebují nastavení aplikace:

```php
use App\Core\Settings\SettingsRequire;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
	use SettingsRequire;
}
```

## Použití v šabloně Latte

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

## Provider oprávnění

S [drago-ex/permission](https://github.com/drago-ex/permission) se pravidla přístupu z [`permission.php`](permission.php)
vygenerují do projektu příkazem:

```bash
php vendor/bin/create-permission --packages
```
