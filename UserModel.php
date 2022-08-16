<?php

namespace Core;

use Core\DB\DBModel;

abstract class UserModel extends DBModel
{
	abstract public function getDisplayName(): string;
}