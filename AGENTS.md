# Agent Guide

`drago-ex/project-settings` (type drago-tools-resource, PHP >=8.3 <9): application settings (name → value) in the
database, edited in the administration and passed to templates. The workspace rules are in `../AGENTS.md`;
dependencies are in `composer.json`.

## Layout
- `migrations/001_settings.sql`: `settings(name VARCHAR(100) PK, value VARCHAR(255))`, utf8mb4, no seed rows
  (`bin/project-setup` of drago-ex/project inserts `website` and `description`).
- `resources/app/Core/Settings`: `Settings`, `SettingsEntity`, `SettingsRepository`, `SettingsRequire` (trait).
- `resources/app/Presentation/Backend/Settings`: `SettingsPresenter`, `default.latte`, `2.menu.neon`, `acl.neon`,
  `Translate/cs.neon`.
- `resources/brand/@brand.latte`: the brand of the layouts.

## How it works
- Other packages may add their own rows in their migrations with `INSERT … WHERE NOT EXISTS` (they run after
  this package's default priority 100).
- `SettingsRepository::getSettings()` reads all rows; `SettingsRequire` puts them into templates as `Settings`;
  `get()` throws for a missing setting, `has()` checks it.
- The administration edits every row as a text field of at most 255 characters. Setting names may contain
  characters a control name may not, so the controls are named by position (`setting0`, …) and
  `SettingsPresenter::$settingNames` maps them back; the template lists exactly the controls of the form.
- The website name belongs to this package: `resources/brand/@brand.latte` is installed by `replace`
  (`replace-once`, priority 100) over `app/Presentation/Accessory/Widget/@brand.latte`, which project-auth installs
  by `copy`. It prints `$settings->get('website')` only when `$settings` is set and has the row, else "Project".

## Commands
```bash
composer phpstan
composer tester
```
