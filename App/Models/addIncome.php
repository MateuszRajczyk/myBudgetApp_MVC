<?php

namespace App\Models;

use App\Token;
use PDO;

class addIncome extends \Core\Model
{
	public $errorAddIncome = [];
	
	public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
	
	
	public function sendIncomeToDB()
	{
		$this->validateIncomeForm();
		
		if(empty($this->errorAddIncome))
		{
			$sql = 'INSERT INTO incomes (userId, amount, incomeCategoryAssignedToUserId ,incomeComment, dateOfIncome) 
					VALUES (:userId, :amount, (SELECT id FROM incomes_category_assigned_to_users WHERE name=:categoryName AND userId=:userId) ,:incomeComment, :dateIncome)';

			$db = static::getDB();
			
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
			$stmt->bindValue(':categoryName', $this->category, PDO::PARAM_STR);
			$stmt->bindValue(':incomeComment', $this->comment, PDO::PARAM_STR);
			$stmt->bindValue(':dateIncome', $this->date, PDO::PARAM_STR);
			
			
			return $stmt->execute();
		}
		
		return false;

	}
	
	public static function incomeCategoryName()
	{
		$sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE userId = :userId ';
		
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
	
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public function validateIncomeForm()
    {
        // Amount
        if ($this->amount == NULL) {
            $this->errorAddIncome['ErrAmount'] = 'Amount field is required';
        }
		
		// Category income
        if (!isset($this->category)) {
            $this->errorAddIncome['ErrCategory'] = 'Category field is required';
        }
		
		// Comments
        if ((strlen($this->comment)>50)) {
            $this->errorAddIncome['ErrComment'] = 'Comment must have max 50 characters';
        }

    }

	public static function deleteIncomesAssignedToGivenCategory($category)
	{
		$sql = "DELETE FROM incomes WHERE userId=:userId AND incomeCategoryAssignedToUserId=:idCategory";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':idCategory', $category->categoryIdDel, PDO::PARAM_INT);

        return $stmt->execute();
	}

	public static function categoryIncomeExists($category)
    {
		return static::findByIncomeCategory($category) !== false;
    }

	public static function findByIncomeCategory($category)
	{
		$sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE name = :category AND userId = :userId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
		$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
        $stmt->execute();

        return $stmt->fetch();
	}
	

}