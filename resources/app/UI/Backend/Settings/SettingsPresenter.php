<?php

declare(strict_types=1);

namespace App\UI\Backend\Settings;

use App\UI\Backend\BackendPresenter;
use Drago\Application\UI\Alert;
use Drago\Attr\AttributeDetectionException;
use Exception;
use Nette\Application\UI\Form;


/** @property-read SettingsTemplate $template */
class SettingsPresenter extends BackendPresenter
{
	public function renderDefault(): void
	{
		$this->template->inputsSettings = $this->settingsRepository
			->getSettings();
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

		$this->getPresenter()
			->flashMessage('Successful save.', Alert::Success);

		$this->getPresenter()
			->redirect('this');
	}
}
