<?php declare(strict_types=1);

namespace App\Presentation\Backend\Settings;

use App\Core\Settings\SettingsEntity;
use App\Core\Settings\SettingsRepository;
use App\Presentation\Backend\BackendPresenter;
use Drago\Application\UI\Alert;
use Drago\Attr\AttributeDetectionException;
use Exception;
use Nette\Application\UI\Form;
use Nette\DI\Attributes\Inject;
use function count;


/** @property-read SettingsTemplate $template */
class SettingsPresenter extends BackendPresenter
{
	#[Inject]
	public SettingsRepository $settingsRepository;

	/**
	 * Setting names by the names of their form controls. A setting name may contain characters a control name
	 * may not (e.g. a dot), so the controls are named by position, which never collides.
	 * @var array<string, string>
	 */
	private array $settingNames = [];


	public function renderDefault(): void
	{
		// the template lists exactly the controls the form has
		$this->getComponent('settings');
		$this->template->settingControls = array_keys($this->settingNames);
	}


	protected function createComponentSettings(): Form
	{
		$form = new Form;
		$form->setTranslator($this->translator);
		foreach ($this->settingsRepository->getSettings() as $name => $value) {
			$control = 'setting' . count($this->settingNames);
			$this->settingNames[$control] = (string) $name;
			// a value longer than the column would fail only in the database
			$form->addText($control, (string) $name)
				->setDefaultValue($value)
				->setRequired()
				->addRule($form::MaxLength, 'The value can have at most %d characters.', SettingsEntity::ColumnValueSize);
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
		foreach ($this->settingNames as $control => $name) {
			$this->settingsRepository->saveSetting($name, (string) $values[$control]);
		}

		$this->flashMessage('Successful save.', Alert::Success);
		$this->redirect('this');
	}
}
