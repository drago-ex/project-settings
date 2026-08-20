<?php

declare(strict_types=1);

namespace App\Core\Settings;

use Dibi\Connection;
use Dibi\Exception;
use Drago\Attr\AttributeDetectionException;
use Drago\Attr\Table;
use Drago\Database\Database;
use RuntimeException;


#[Table(SettingsEntity::Table)]
class SettingsRepository
{
	/** @use Database<SettingsEntity> */
	use Database;

	public function __construct(
		protected Connection $connection,
	) {
	}


	/**
	 * Fetches all settings from the database as key-value pairs.
	 * @return array<string, string>
	 */
	public function getSettings(): array
	{
		try {
			return $this->read('*')
				->where('name != ?', 'installed')
				->fetchPairs(SettingsEntity::ColumnName, SettingsEntity::ColumnValue);

		} catch (\Throwable $e) {
			throw new RuntimeException('Failed to fetch settings from the database: ' . $e->getMessage(), 0, $e);
		}
	}


	/**
	 * Saves a single setting by name.
	 * @throws AttributeDetectionException
	 * @throws Exception
	 */
	public function saveSetting(string $name, string $value): void
	{
		$exists = $this->find(SettingsEntity::ColumnName, $name)
			->fetch();

		if ($exists === null) {
			$this->insert([
				SettingsEntity::ColumnName => $name,
				SettingsEntity::ColumnValue => $value,
			])->execute();
			return;
		}

		$this->update([
			SettingsEntity::ColumnValue => $value,
		])
			->where('%n = ?', SettingsEntity::ColumnName, $name)
			->execute();
	}
}
