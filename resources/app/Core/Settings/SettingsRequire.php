<?php

declare(strict_types=1);

namespace App\Core\Settings;

use Nette\Application\UI\Presenter;
use Nette\DI\Attributes\Inject;
use Tracy\Debugger;
use Tracy\ILogger;


trait SettingsRequire
{
	#[Inject]
	public SettingsRepository $settingsRepository;


	public function injectSettings(Presenter $presenter): void
	{
		$presenter->onRender[] = function () use ($presenter) {
			try {
				$presenter->template->settings = new Settings(
					$this->settingsRepository->getSettings(),
				);

			} catch (\Throwable $e) {
				Debugger::log($e, ILogger::EXCEPTION);
			}
		};
	}
}
