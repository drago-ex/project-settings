<?php

declare(strict_types=1);

namespace App\Presentation\Backend\Settings;

use App\Core\Settings\SettingsRepository;
use App\Presentation\Backend\BackendPresenter;
use Drago\Application\UI\Alert;
use Drago\Attr\AttributeDetectionException;
use Exception;
use Nette\Application\UI\Form;
use Nette\DI\Attributes\Inject;


/** @property-read SettingsTemplate $template */
class SettingsPresenter extends BackendPresenter
{
	#[Inject]
	public SettingsRepository $settingsRepository;


	public function renderDefault(): void
	{
		$this->template->settingControls = array_map(
			self::controlName(...),
			array_keys($this->settingsRepository->getSettings()),
		);
	}


	/**
	 * Setting names may contain dots (e.g. blog.comments_enabled), which a form control name may not,
	 * so other characters than letters, digits and underscores become underscores.
	 */
	public static function controlName(string $name): string
	{
		return (string) preg_replace('~\W~', '_', $name);
	}


	protected function createComponentSettings(): Form
	{
		$form = new Form;
		$form->setTranslator($this->translator);
		$settings = $this->settingsRepository->getSettings();
		foreach ($settings as $name => $value) {
			$form->addText(self::controlName($name), $name)
				->setDefaultValue($value)
				->setRequired();
		}

		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = $this->processSettingsForm(...);
		return $form;
	}


	/**
	 * @throws Exception
	 * @throws AttributeDetectionException
	 */
	private function processSettingsForm(Form $form): void
	{
		$values = (array) $form->getValues('array');
		foreach (array_keys($this->settingsRepository->getSettings()) as $name) {
			// A setting added after the form was shown has no field in it.
			$control = self::controlName($name);
			if (array_key_exists($control, $values)) {
				$this->settingsRepository->saveSetting($name, (string) $values[$control]);
			}
		}

		$this->flashMessage('Successful save.', Alert::Success);
		$this->redirect('this');
	}
}
