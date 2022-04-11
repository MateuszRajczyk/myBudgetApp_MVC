<?php

namespace App\Models;

use PDO;
use App\Token;
use App\Mail;
use \Core\View;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {	
        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash(($this->password1), PASSWORD_DEFAULT);
			
			$token = new Token();
			$hashedToken = $token->getHash();
			$this->activationToken = $token->getValue();

            $sql = 'INSERT INTO users (username, password, email, activationHash)
                    VALUES (:userName, :password_hash, :email, :activationHash)';
                                              
            $db = static::getDB();
            $stmt = $db->prepare($sql);
                                                  
            $stmt->bindValue(':userName', $this->userName, PDO::PARAM_STR);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':activationHash', $hashedToken, PDO::PARAM_STR);
            
                                          
            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {

        // Name
        if ($this->userName == '') {
            $this->errors['ErrName1'] = 'Name is required';
        }
		
		if ((strlen($this->userName)<3) || (strlen($this->userName)>20)) {
			$this->errors['ErrName2']='Name of user must have from 3 to 20 characters!';
		}

		if (ctype_alnum($this->userName)==false)
		{
			$this->errors['ErrName3']='Name of user must have only letters and numbers!';
		}

        // email address
		if ($this->email == '') {
            $this->errors['ErrEmail1'] = 'Email is required';
        }
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors['ErrEmail2'] = 'Invalid email';
        }
		
        if (static::emailExists($this->email)) {
            $this->errors['ErrEmail3'] = 'Email already taken';
        }
		
		$this->validatePassword();

    }
	
	protected function validatePassword()
	{
		// Password

        if (strlen($this->password1) < 6) {
            $this->errors['ErrPassword2'] = 'Please enter at least 6 characters for the password';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password1) == 0) {
            $this->errors['ErrPassword3'] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/', $this->password1) == 0) {
            $this->errors['ErrPassword4'] = 'Password needs at least one number';
        }
	}

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email)
    {
		return static::findByEmail($email) !== false;
    }
	
	public static function findByEmail($email)
	{
		$sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
        $stmt->execute();

        return $stmt->fetch();
	}
	
	public static function authenticate($email, $password)
	{
		$user = static::findByEmail($email);
		
		if($user)
		{
			if(password_verify($password, $user->password))
			{
				$_SESSION['password'] = $password;
				return $user;
			}
		}
		else
		{
			return false;
		}
	}
	
	public static function findByID($id)
	{
		$sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
        $stmt->execute();

        return $stmt->fetch();
	}
	
	public function rememberLogin()
	{
		$token = new Token();
		
		$hashedToken = $token->getHash();
		$this->rememberToken = $token->getValue();
		
		$this->expiryTimestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now
		
		$sql = 'INSERT INTO remembered_logins (tokenHash, userId, expiresAt) VALUES (:tokenHash, :userId, :expiresAt)';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':tokenHash', $hashedToken, PDO::PARAM_STR);
		$stmt->bindValue(':userId', $this->id, PDO::PARAM_INT);
		$stmt->bindValue(':expiresAt', date('Y-m-d H:i:s', $this->expiryTimestamp), PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	
	public static function sendPasswordReset($email)
	{
		$user = static::findByEmail($email);
		
		if($user)
		{
			if($user->startPasswordReset())
			{
				$user->sendPasswordResetEmail();
				return true;
			}
		}
	}
	
	protected function startPasswordReset()
	{
		$token = new Token();
		
		$hashedToken = $token->getHash();
		
		$this->passwordResetToken = $token->getValue();
		
		$expiryTimestamp = time() + 60 * 60 * 2; // 2 hours from now
		
		$sql = 'UPDATE users SET passwordResetHash = :tokenHash, passwordResetExp = :expiresAt WHERE id = :id';
		
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':tokenHash', $hashedToken, PDO::PARAM_STR);
		$stmt->bindValue(':expiresAt', date('Y-m-d H:i:s', $expiryTimestamp), PDO::PARAM_STR);
		$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
		
		return $stmt->execute();
	}
	
	protected function sendPasswordResetEmail()
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/password/reset/'.$this->passwordResetToken;
		
		$message = View::getTemplate('Password/resetEmail.html', ['url' => $url]);
		
		Mail::send($this->email, 'Password reset', $message);
	}
	
	public static function findByPasswordReset($token)
	{
		$token = new Token($token);
		
		$hashedToken = $token->getHash();
		
		$sql = 'SELECT * FROM users WHERE passwordResetHash = :tokenHash';
		
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':tokenHash', $hashedToken, PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		$user = $stmt->fetch();
		
		if($user)
		{
			if((strtotime($user->passwordResetExp)) > time())
			{
				return $user;
			}
		}
	}
	
	public function resetPassword($password1)
	{
		$this->password1 = $password1;
		
		$this->validatePassword();
		
		if (empty($this->errors))
		{
			$passwordHash = password_hash($this->password1, PASSWORD_DEFAULT);
			
			$sql = 'UPDATE users SET password = :passwordHash, 
									 passwordResetHash = NULL,
									 passwordResetExp = NULL
								 WHERE id = :id';
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindValue(':passwordHash', $passwordHash, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		
		return false;
	}
	
	public function sendActivationEmail()
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/signup/activate/'.$this->activationToken;
		
		$message = View::getTemplate('Sign Up/activationEmail.html', ['url' => $url]);
		
		Mail::send($this->email, 'Account activation - Home Budget', $message);
	}
	
	public static function activate($value)
	{
		$token = new Token($value);
		$hashedToken = $token->getHash();
		
		$sql = 'UPDATE users
				SET isActive = 1, activationHash = NULL
				WHERE  activationHash = :hashedToken';
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':hashedToken', $hashedToken, PDO::PARAM_STR);
		
		$stmt->execute();
	}
	
	public function assignDefaultPaymentMethods()
	{
		$sql = "INSERT INTO payment_methods_assigned_to_users(userId, name) 
				SELECT users.id, payment_methods_default.name 
				FROM users, payment_methods_default 
				WHERE users.username= :username";
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':username', $this->userName, PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	
	public function assignDefaultIncomesCategory()
	{
		$sql = "INSERT INTO incomes_category_assigned_to_users(userId, name) 
				SELECT users.id, incomes_category_default.name 
				FROM users, incomes_category_default 
				WHERE users.username = :username";
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':username', $this->userName, PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	
	public function assignDefaultExpensesCategory()
	{
		$sql = "INSERT INTO expenses_category_assigned_to_users(userId, name) 
				SELECT users.id, expenses_category_default.name 
				FROM users, expenses_category_default 
				WHERE users.username= :username";
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':username', $this->userName, PDO::PARAM_STR);
		
		return $stmt->execute();
	}

	public function editUserDetails()
	{
		$sql = "UPDATE users SET username=:name, email=:email, password=:password WHERE id=:userId";

		$db = static::getDB();

		$stmt = $db->prepare($sql);

		if(isset($this->username)){
			$stmt->bindValue(':name', $this->username, PDO::PARAM_STR);
			$stmt->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
			$stmt->bindValue(':password',password_hash(($_SESSION['password']), PASSWORD_DEFAULT), PDO::PARAM_STR);
			$_SESSION['username'] = $this->username;
		}else if(isset($this->email)){
			$stmt->bindValue(':name', $_SESSION['username'], PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':password',password_hash(($_SESSION['password']), PASSWORD_DEFAULT), PDO::PARAM_STR);
			$_SESSION['email'] = $this->email;
		}else if(isset($this->new_password)){
			$new_password_hash = password_hash(($this->new_password), PASSWORD_DEFAULT);

			$stmt->bindValue(':name', $_SESSION['username'], PDO::PARAM_STR);
			$stmt->bindValue(':email',$_SESSION['email'], PDO::PARAM_STR);
			$stmt->bindValue(':password',$new_password_hash, PDO::PARAM_STR);
			$_SESSION['password'] = $this->new_password;
		}

		$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function deleteAccount()
	{
		$sql = "DELETE users, incomes, expenses, incomes_category_assigned_to_users, expenses_category_assigned_to_users, payment_methods_assigned_to_users
		FROM users
		INNER JOIN incomes
		INNER JOIN expenses
		INNER JOIN incomes_category_assigned_to_users
		INNER JOIN expenses_category_assigned_to_users
		INNER JOIN payment_methods_assigned_to_users
		WHERE users.id = :userId 
		AND users.id = incomes.userId
		AND users.id = expenses.userId
		AND users.id = incomes_category_assigned_to_users.userId
		AND users.id = expenses_category_assigned_to_users.userId
		AND users.id = payment_methods_assigned_to_users.userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
	}
	
	
}
