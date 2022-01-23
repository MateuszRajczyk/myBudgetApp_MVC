<?php

namespace App\Models;

use App\Token;
use PDO;

class addExpense extends \Core\Model
{
	public $errorAddExpense = [];
	
	public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
	
	
	public function sendExpenseToDB()
	{
		$this->validateExpenseForm();
		
		if(empty($this->errorAddExpense))
		{
			$sql = 'INSERT INTO expenses (userId, amount, expenseCategoryAssignedToUserId , paymentMethodAssignedToUserId,expenseComment, dateOfExpense) VALUES (:userId, :amount, (SELECT id FROM expenses_category_assigned_to_users WHERE name=:categoryName), (SELECT id FROM payment_methods_assigned_to_users WHERE name=:paymentName) ,:expenseComment, :dateExpense)';

			$db = static::getDB();
			
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
			$stmt->bindValue(':categoryName', $this->category, PDO::PARAM_STR);
			$stmt->bindValue(':paymentName', $this->payment, PDO::PARAM_STR);
			$stmt->bindValue(':expenseComment', $this->comment, PDO::PARAM_STR);
			$stmt->bindValue(':dateExpense', $this->date, PDO::PARAM_STR);
			
			
			return $stmt->execute();
		}
		
		return false;

	}
	
	public static function expenseCategoryName()
	{
		$sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE userId = :userId ';
		
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
	
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function expensePaymentName()
	{
		$sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE userId = :userId ';
		
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
	
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public function validateExpenseForm()
    {
        // Amount
        if ($this->amount == NULL) {
            $this->errorAddExpense['ErrAmount'] = 'Amount field is required';
        }
		
		// Category income
        if (!isset($this->category)) {
            $this->errorAddExpense['ErrCategory'] = 'Category field is required';
        }
		
		// Payment method
        if (!isset($this->payment)) {
            $this->errorAddExpense['ErrPayment'] = 'Payment method field is required';
        }
		
		// Comments
        if ((strlen($this->comment)>50)) {
            $this->errorAddExpense['ErrComment'] = 'Comment must have max 50 characters';
        }

    }
	

}