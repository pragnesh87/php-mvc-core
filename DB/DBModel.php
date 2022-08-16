<?php

namespace Core\DB;

use Core\Model;
use Core\Application;

abstract class DBModel extends Model
{
	abstract protected static function tableName(): string;

	abstract protected function attributes(): array;

	public static function primaryKey(): string
	{
		return 'id';
	}

	public function save()
	{
		$tableName = $this->tableName();
		$attributes = $this->attributes();
		$params = array_map(fn ($attr) => ":$attr", $attributes);
		$statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");

		foreach ($attributes as $attribute) {
			$statement->bindValue(":$attribute", $this->{$attribute});
		}

		return $statement->execute();
	}

	public static function prepare($sql, $options = [])
	{
		return Application::$app->db->pdo->prepare($sql, $options);
	}

	public static function findOne(array $where)
	{
		$tableName = static::tableName();
		$attributes = array_keys($where);
		$sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));
		$statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
		foreach ($where as $key => $item) {
			$statement->bindValue(":$key", $item);
		}
		$statement->execute();
		return $statement->fetchObject(static::class);
	}
}