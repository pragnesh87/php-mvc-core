<?php

namespace Core\DB;

use Core\Constants\Path;
use PDO;

class Database
{
	public PDO $pdo;
	public function __construct(array $config)
	{
		$dsn = $config['dsn'] ?? '';
		$user = $config['user'] ?? '';
		$password = $config['password'] ?? '';
		$this->pdo = new PDO($dsn, $user, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function applyMigrations()
	{
		$this->createMigrationsTable();
		$appliedMigrations = $this->getAppliedMigrations();

		$files = array_diff(scandir(Path::$ROOT_DIR . '/Databases/Migrations'), ['.', '..']);
		$toApplyMigrations = array_diff($files, $appliedMigrations);
		$newMigrations = [];
		foreach ($toApplyMigrations as $migration) {
			require_once Path::$ROOT_DIR . '/Databases/Migrations/' . $migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);
			$instance = new $className();
			$this->log("Applying Migration $migration");
			$instance->up();
			$this->log("Applied Migration $migration");
			$newMigrations[] = $migration;
		}

		if (!empty($newMigrations)) {
			$this->saveMigrations($newMigrations);
		} else {
			$this->log("Nothing to migrate...");
		}
	}

	protected function createMigrationsTable()
	{
		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
	}

	protected function getAppliedMigrations()
	{
		$statement = $this->pdo->prepare("SELECT migration FROM migrations");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}

	protected function saveMigrations(array $migrations)
	{
		$str = join(',', array_map(fn ($m) => "('$m')", $migrations));

		$statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
		$statement->execute();
	}

	protected function log($message)
	{
		echo "[" . date('Y-m-d H:i:s') . "] - $message" . PHP_EOL;
	}
}