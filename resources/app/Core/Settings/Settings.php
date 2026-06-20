<?php

declare(strict_types=1);

namespace App\Core\Settings;

use RuntimeException;


class Settings
{
	/** @param array<string, string> $values */
	public function __construct(
		private readonly array $values,
	) {
	}


	public function get(string $name): string
	{
		return $this->values[$name]
			?? throw new RuntimeException(sprintf('Missing setting "%s".', $name));
	}


	public function has(string $name): bool
	{
		return isset($this->values[$name]);
	}


	public function __get(string $name): string
	{
		return $this->get($name);
	}


	public function __isset(string $name): bool
	{
		return $this->has($name);
	}


	/** @return array<string, string> */
	public function all(): array
	{
		return $this->values;
	}
}
