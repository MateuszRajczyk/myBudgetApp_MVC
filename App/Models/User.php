<?php

namespace App\Models;

use PDO;

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
    public function __construct($data)
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

            $sql = 'INSERT INTO users (username, password, email)
                    VALUES (:userName, :password_hash, :email)';
                                              
            $db = static::getDB();
            $stmt = $db->prepare($sql);
                                                  
            $stmt->bindValue(':userName', $this->userName, PDO::PARAM_STR);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            
                                          
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

        // Password
        if ($this->password1 != $this->password2) {
            $this->errors['ErrPassword1'] = 'Entered passwords are not match!';
        }

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
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch() !== false;
    }
}
