<?php

namespace Core\Forms;

use Core\Enums\FieldTypes;
use Core\Model;

class TextareaField extends BaseField
{
	public function  __construct(Model $model, string $attribute)
	{
		$this->type = FieldTypes::textarea->value;
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
			'<textarea id="%s" name="%s" class="form-control %s" >%s</textarea>',
			$this->attbribute,
			$this->attbribute,
			$this->model->hasError($this->attbribute) ? 'is-invalid' : '',
			$this->model->{$this->attbribute},
		);
	}
}