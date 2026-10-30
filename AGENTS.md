# Agent Guide

Use this file as package-specific guidance when working in this repository. Keep changes aligned with the existing public API, project conventions, and supported PHP range.

## Package Overview
- **Package**: `drago-ex/project-settings`
- **Type**: drago-tools-resource
- **Purpose**: Individual settings for the application.
- **PHP**: >=8.3 <9
- **Runtime dependencies**: nette/application (^3.0), nette/di (^3.0), tracy/tracy (^2.0), drago-ex/translator (^4.0.1), drago-ex/database (^4.1), drago-ex/application (^4.0), drago-ex/project-backend (^1.0), drago-ex/form (^3.0)
- **License**: MIT

## Repository Layout
- `bin/create-settings-permission`: generates the basic access rules (permission providers) with `create-permission` of `drago-ex/permission`; listed in `extra.drago-tools.commands` and run by `drago-commands` of drago-ex/project-tools. Existing providers are kept; without drago-ex/permission it does nothing.
- `migrations/`: database migrations.
- `resources/`: application resources contributed to the consuming Drago project.
- `tests/`: automated tests.
- `.github/`: CI workflows; keep their PHP versions and commands consistent with Composer and the package scripts.
- `composer.json`: package metadata, dependency constraints, autoloading, and available Composer scripts.

## Key Parts
- Table `settings` (name → value strings, primary key on `name`, utf8mb4): `001_settings.sql`. Other packages may add their own rows in their migrations with `INSERT … WHERE NOT EXISTS` (after this package's default priority 100); the web installer writes the `installed` row, which `getSettings()` leaves out.
- `Core\Settings\SettingsRepository::getSettings()` reads all rows; `SettingsRequire` puts them into templates as `Settings`; the administration (`Backend:Settings`) edits every row as a text field of at most 255 characters (the column). A setting name may contain characters a control name may not, so the controls are named by position (`setting0`, …) and `SettingsPresenter::$settingNames` maps them back; the template lists exactly the controls of the form (2026-10-25, code review: the earlier name rewrite made `site.name` and `site_name` collide and the page fail).
- Migrations: see the workspace rule (one complete `CREATE TABLE` per table while no real project runs).

## Dependencies

Composer constraints describe the package contract. Before changing integration behavior, inspect the source and the actual call sites in this package; do not infer runtime usage solely from dependency declarations.
Development dependencies include nette/tester (^2.5), phpstan/phpstan-nette (^2.0), drago-ex/project-tools (^1.0).

## Essential Commands

```bash
composer phpstan                # phpstan analyse
composer tester                 # tester tests -s
```

## Tests

The package defines `composer tester` and contains a small Nette Tester suite under `tests/`.
Do not claim behavior is covered by tests unless you find and run a relevant suite. When adding a test suite, follow the package’s existing Nette Tester setup if one is present and add an explicit Composer script.

## Installation Hooks

Composer install and update hooks invoke Drago project setup/cleanup commands. Inspect those scripts and their effects before invoking Composer operations that trigger them; they may modify generated project files.

## Conventions & Rules

- Preserve backward compatibility unless the task explicitly permits a breaking change. Check callers and public signatures before changing behavior.
- Follow the existing PHP style: strict types, explicit parameter and return types, tabs for indentation, and single-quoted strings where practical. Match nearby code when a convention is unclear.
- Keep package-specific configuration, resources, and migrations in their established directories. Do not edit generated or consuming-project files without confirming they are part of this repository’s intended output.
- Add or update focused tests for behavioral changes when this package has a runnable test setup. Do not invent test commands; use only the scripts and configuration present here.
- Update README examples and Composer metadata when a public API or supported requirement changes.
