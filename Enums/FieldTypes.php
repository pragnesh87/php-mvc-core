<?php

namespace Core\Enums;

enum FieldTypes: string
{
	case button = 'button';
	case checkbox = 'checkbox';
	case color = 'color';
	case date = 'date';
	case datetimelocal = 'datetime-local';
	case email = 'email';
	case file = 'file';
	case hidden = 'hidden';
	case image = 'image';
	case month = 'month';
	case number = 'number';
	case password = 'password';
	case radio = 'radio';
	case range = 'range';
	case reset = 'reset';
	case search = 'search';
	case submit = 'submit';
	case tel = 'tel';
	case text = 'text';
	case time = 'time';
	case url = 'url';
	case week = 'week';
	case textarea = 'textarea';
}