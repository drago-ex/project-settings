<?php declare(strict_types=1);

namespace App\Core\Settings;

use Dibi\Connection;
use Dibi\Exception;
use Drago\Database\Table;
use RuntimeException;


readonly class SettingsRepository
{
	public Table $table;


	public function __construct(Connection $db)
	{
		$this->table = new Table($db, SettingsEntity::Table);
	}


	/**
	 * Fetches all settings from the database as key-value pairs.
	 * @return array<string, string>
	 */
	public function getSettings(): array
	{
		try {
			return $this->table->read('*')
				->where('name != ?', 'installed')
				->fetchPairs(SettingsEntity::ColumnName, SettingsEntity::ColumnValue);

		} catch (\Throwable $e) {
			throw new RuntimeException('Failed to fetch settings from the database: ' . $e->getMessage(), 0, $e);
		}
	}


	/**
	 * Saves a single setting by name.
	 * @throws Exception
	 */
	public function saveSetting(string $name, string $value): void
	{
		$exists = $this->table->find(SettingsEntity::ColumnName, $name)
			->fetch();

		if ($exists === null) {
			$this->table->insert([
				SettingsEntity::ColumnName => $name,
				SettingsEntity::ColumnValue => $value,
			])->execute();
			return;
		}

		$this->table->update([
			SettingsEntity::ColumnValue => $value,
		])
			->where('%n = ?', SettingsEntity::ColumnName, $name)
			->execute();
	}
}
