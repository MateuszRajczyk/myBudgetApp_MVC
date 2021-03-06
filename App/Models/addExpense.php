<?php

namespace App\Models;

use App\Token;
use PDO;
use \App\Date;

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
			$sql = 'INSERT INTO expenses (userId, amount, expenseCategoryAssignedToUserId , paymentMethodAssignedToUserId,expenseComment, dateOfExpense) 
					VALUES (:userId, :amount, (SELECT id FROM expenses_category_assigned_to_users WHERE name=:categoryName AND userId=:userId), (SELECT id FROM payment_methods_assigned_to_users WHERE name=:paymentName AND userId=:userId) ,:expenseComment, :dateExpense)';

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

	public static function deleteExpensesAssignedToGivenCategory($category)
	{
		$sql = "DELETE FROM expenses WHERE userId=:userId AND expenseCategoryAssignedToUserId=:idCategory";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':idCategory', $category->categoryIdDel, PDO::PARAM_INT);

        return $stmt->execute();
	}

	public static function deleteExpensesAssignedToGivenPaymentMethod($category)
	{
		$sql = "DELETE FROM expenses WHERE userId=:userId AND paymentMethodAssignedToUserId=:idCategory";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':idCategory', $category->categoryIdDel, PDO::PARAM_INT);

        return $stmt->execute();
	}

	public function getLimitInfoCategory()
	{
		$startDate = Date::getMonthStartDate($this->date);
		$endDate = Date::getMonthEndDate($this->date);

		$sql = 'SELECT IFNULL(SUM(expenses.amount),0)
				AS catSumAmount, 
				IFNULL(expenses_category_assigned_to_users.limitAmount, 
				(SELECT limitAmount
					FROM expenses_category_assigned_to_users
					WHERE userId = :userId 
					AND name=:category)) 
				AS limitAmount
				FROM expenses, expenses_category_assigned_to_users 
				WHERE expenses_category_assigned_to_users.userId = :userId
        		AND expenses_category_assigned_to_users.id = (SELECT id 
					FROM expenses_category_assigned_to_users 
					WHERE userId=:userId 
					AND name=:category)
        		AND expenses_category_assigned_to_users.id = expenses.expenseCategoryAssignedToUserId
				AND expenses.dateOfExpense >=:date1 
				AND expenses.dateOfExpense <=:date2';
		
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
		$stmt->bindParam(':date1', $startDate, PDO::PARAM_STR);
		$stmt->bindParam(':date2', $endDate, PDO::PARAM_STR);
	
		$stmt->execute();
		
		return $stmt->fetchAll();
	}

	public static function categoryExpenseExists($category)
    {
		return static::findByExpenseCategory($category) !== false;
    }

	public static function findByExpenseCategory($category)
	{
		$sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE name = :category AND userId = :userId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
        $stmt->execute();

        return $stmt->fetch();
	}

	public static function categoryPaymentExists($category)
    {
		return static::findByPaymentCategory($category) !== false;
    }

	public static function findByPaymentCategory($category)
	{
		$sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE name = :category AND userId = :userId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
        $stmt->execute();

        return $stmt->fetch();
	}
	

}