<?php

declare(strict_types=1);

namespace App\Core\Settings\Factory;

use App\Core\Settings\SettingsRepository;
use Dibi\Exception;
use Drago\Application\UI\Alert;
use Drago\Application\UI\ExtraControl;
use Drago\Attr\AttributeDetectionException;
use Nette\Application\UI\Form;


/**  @property-read SettingsTemplate $template */
class SettingsControl extends ExtraControl
{
	public function __construct(
		private readonly SettingsRepository $settingsRepository,
	) {
	}


	public function render(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/settings.latte');
		$template->setTranslator($this->translator);
		$template->inputsSettings = $this->settingsRepository->getSettings();
		$template->render();
	}


	protected function createComponentSettings(): Form
	{
		$form = new Form;
		$settings = $this->settingsRepository->getSettings();
		foreach ($settings as $name => $value) {
			$form->addText($name, $name)
				->setRequired();
		}

		$form->setDefaults($settings);
		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = $this->success(...);
		return $form;
	}


	/**
	 * @throws Exception
	 * @throws AttributeDetectionException
	 */
	private function success(Form $form): void
	{
		foreach ((array) $form->getValues('array') as $name => $value) {
			$this->settingsRepository->saveSetting($name, (string) $value);
		}

		$this->flashMessage('Successful save.', Alert::Success);
	}
}
