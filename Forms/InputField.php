<?php

namespace Core\Forms;

use Core\Enums\FieldTypes;
use Core\Model;

class InputField extends BaseField
{
	public function  __construct(Model $model, string $attribute)
	{
		$this->type = FieldTypes::text->value;
		parent::__construct($model, $attribute);
	}

	public function __toString()
	{
		return sprintf(
			'
		<label for="%s" class="form-label">%s</label>
		%s
		<div class="invalid-feedback">
		%s
		</div>',
			$this->attbribute,
			$this->model->getLabel($this->attbribute),
			$this->renderInput(),
			$this->model->getErrors($this->attbribute),
		);
	}

	public function passwordField()
	{
		$this->type = FieldTypes::password->value;
		return $this;
	}

	public function renderInput(): string
	{
		return sprintf(
			'<input type="%s" id="%s" name="%s" value="%s" class="form-control %s" >',
			$this->type,
			$this->attbribute,
			$this->attbribute,
			$this->model->{$this->attbribute},
			$this->model->hasError($this->attbribute) ? 'is-invalid' : '',
		);
	}
}