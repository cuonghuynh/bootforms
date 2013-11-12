<?php namespace AdamWathan\BootForms;

use AdamWathan\Form\FormBuilder;
use AdamWathan\BootForms\Elements\FormGroup;
use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\HelpBlock;

class BasicFormBuilder
{
	protected $builder;

	public function __construct(FormBuilder $builder)
	{
		$this->builder = $builder;
	}

	protected function formGroup($label, $name, $control)
	{
		$label = $this->builder->label($label, $name)->addClass('control-label')->forId($name);
		$control->id($name)->addClass('form-control');

		$formGroup = new FormGroup($label, $control);

		if ($this->builder->hasError($name)) {
			$formGroup->helpBlock(new HelpBlock($this->builder->getError($name)));
			$formGroup->addClass('has-error');
		}

		return $formGroup;		
	}

	public function text($label, $name, $value = null)
	{
		$control = $this->builder->text($name)->value($value);

		return $this->formGroup($label, $name, $control);
	}
	
	public function password($label, $name)
	{
		$control = $this->builder->password($name);

		return $this->formGroup($label, $name, $control);
	}

	public function submit($value = "Submit", $type = "btn-default")
	{
		return $this->builder->submit($value)->addClass('btn')->addClass($type);
	}

	public function select($label, $name, $options = array())
	{
		$control = $this->builder->select($name, $options);

		return $this->formGroup($label, $name, $control);
	}

	public function checkbox($label, $name)
	{
		$control = $this->builder->checkbox($name);

		return $this->checkGroup($label, $name, $control)->addClass('checkbox');
	}

	protected function checkGroup($label, $name, $control)
	{
		$label = $this->builder->label($label, $name)->after($control)->addClass('control-label');

		$checkGroup = new CheckGroup($label);

		if ($this->builder->hasError($name)) {
			$checkGroup->helpBlock(new HelpBlock($this->builder->getError($name)));
			$checkGroup->addClass('has-error');
		}

		return $checkGroup;
	}

	public function radio($label, $name, $value = null)
	{
		if (is_null($value)) {
			$value = $label;
		}

		$control = $this->builder->radio($name, $value);

		return $this->checkGroup($label, $name, $control)->addClass('radio');
	}

	public function textarea($label, $name)
	{
		$control = $this->builder->textarea($name);

		return $this->formGroup($label, $name, $control);
	}

	public function inlineCheckbox($label, $name)
	{
		$label = $this->builder->label($label)->addClass('checkbox-inline');
		$control = $this->builder->checkbox($name);

		return $label->after($control);
	}

	public function inlineRadio($label, $name, $value = null)
	{
		$value = $value ?: $label;
		$label = $this->builder->label($label)->addClass('radio-inline');
		$control = $this->builder->radio($name, $value);

		return $label->after($control);
	}

	public function date($label, $name, $value = null)
	{
		$control = $this->builder->date($name)->value($value);

		return $this->formGroup($label, $name, $control);
	}

	public function email($label, $name, $value = null)
	{
		$control = $this->builder->email($name)->value($value);

		return $this->formGroup($label, $name, $control);
	}

	public function file($label, $name, $value = null)
	{
		$control = $this->builder->file($name)->value($value);
		$label = $this->builder->label($label, $name)->addClass('control-label')->forId($name);
		$control->id($name);

		$formGroup = new FormGroup($label, $control);

		if ($this->builder->hasError($name)) {
			$formGroup->helpBlock(new HelpBlock($this->builder->getError($name)));
			$formGroup->addClass('has-error');
		}

		return $formGroup;	
	}

	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->builder, $method), $parameters);
	}
}