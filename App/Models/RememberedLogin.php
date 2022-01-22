<?php

namespace App\Models;

use App\Token;
use PDO;

class RememberedLogin extends \Core\Model
{
	public static function findByToken($token)
	{
		$token = new Token();
		
		$tokenHash = $token->getHash();
		
		$sql = 'SELECT * FROM remembered_logins WHERE tokenHash = :tokenHash';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':tokenHash', $tokenHash, PDO::PARAM_STR);
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	public function getUser()
	{
		return User::findByID($this->userId);
	}
	
	public function hasExpired()
	{
		return strtotime($this->expiresAt) < time();
	}
	
	public function delete()
	{
		$sql = 'DELETE FROM remembered_logins WHERE tokenHash = :tokenHash';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':tokenHash', $this->tokenHash, PDO::PARAM_STR);
		
		$stmt->execute();
	}
}