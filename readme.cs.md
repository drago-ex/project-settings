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

## Soubory kopírované do projektu

Soubory do projektu kopíruje [drago-ex/project-tools](https://github.com/drago-ex/project-tools)
podle nastavení v `extra.drago-tools` v `composer.json` tohoto balíčku.

## Administrace

Stránka nastavení je dostupná jako:

```latte
{link :Backend:Settings:}
```

S [drago-ex/project-backend-ui](https://github.com/drago-ex/project-backend-ui) přidejte odkazy do jeho menu (viz jeho README).

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

---

## Volitelné doplňky

Balíček funguje i bez nich. Pokud je projekt potřebuje, nastavte je ručně podle popisu níže.

### Provider oprávnění

S [drago-ex/permission](https://github.com/drago-ex/permission) se pravidla přístupu z [`bin/create-settings-permission`](bin/create-settings-permission)
vygenerují do projektu příkazem:

```bash
php vendor/bin/drago-commands
```
