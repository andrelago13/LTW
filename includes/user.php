<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/user.php");
class User {
	private $id;
	private $name;
	private $email;
	private $hash;
	public function setId($id) {
		$this->id = $id;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function setUsername($username) {
		$this->username = $username;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public static function find($id) {
		$user_query = getUser ( $id );
		
		$user = new User ();
		$user->setId ( $user_query ["id"] );
		$user->setName ( $user_query ["name"] );
		$user->setUsername ( $user_query ["username"] );
		$user->setEmail ( $user_query ["email"] );
		
		return $user;
	}
	public function update() {
		updateUser ( $this->id, $this->name, $this->username, $this->email );
	}
	public function expose() {
		return array (
				"id"  => $this->id,
				"name" => $this->name,
				"username" => $this->username,
				"email" => $this->email
		);
	}
}
?>