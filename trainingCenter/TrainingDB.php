<?php
class TrainingDB {

	/** Give a connection to the training DB, in UTF-8 */
	public static function getConnection() {
		// DB configuration
		$db = "training_center";
		$dsn = "mysql:dbname=$db;host=127.0.0.1";
		//$user = "training_center_user";
		$user = "root";
		//$password = "training_center_password";
		$password ="";
		// Get a DB connection with PDO library
		$bdd = new PDO($dsn, $user, $password);
		// Set communication in utf-8
		$bdd->exec("SET character_set_client = 'utf8'");
		return $bdd;
	}
}
