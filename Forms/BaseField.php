<?php

namespace Core\Forms;

use Core\Model;
use Core\Enums\FieldTypes;

abstract class BaseField
{
	public string $type;
	public function __construct(
		public Model $model = new Model,
		public string $attbribute
	) {
	}

	abstract public function renderInput(): string;
}