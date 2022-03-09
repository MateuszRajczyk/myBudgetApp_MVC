<?php

namespace App\Models;

use PDO;
use App\Date;

class searchFinance extends \Core\Model
{
	public $errorAddIncome = [];
	
	public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
	
	public function currentMonth()
	{
		$this->startDate = Date::getStartCurrentDate();
		$this->endDate = Date::getEndCurrentDate();
		
		$this->getAllIncomes();
		$this->getAllExpenses();
		$this->getCategoryIncomes();
		$this->getCategoryExpenses();
		$this->sumIncomes();
		$this->sumExpenses();
		$this->balanceFinance();
	}
	
	public function lastMonth()
	{
		$this->startDate = Date::getStartLastMonthDate();
		$this->endDate = Date::getEndLastMonthDate();
		
		$this->getAllIncomes();
		$this->getAllExpenses();
		$this->getCategoryIncomes();
		$this->getCategoryExpenses();
		$this->sumIncomes();
		$this->sumExpenses();
		$this->balanceFinance();
	}
	
	public function currentYear()
	{
		$this->startDate = Date::getStartCurrentYearDate();
		$this->endDate = Date::getEndCurrentYearDate();
		
		$this->getAllIncomes();
		$this->getAllExpenses();
		$this->getCategoryIncomes();
		$this->getCategoryExpenses();
		$this->sumIncomes();
		$this->sumExpenses();
		$this->balanceFinance();
	}
	
	public function selectPeriod()
	{
		$this->startDate = $this->date1;
		$this->endDate = $this->date2;
		
		$this->getAllIncomes();
		$this->getAllExpenses();
		$this->getCategoryIncomes();
		$this->getCategoryExpenses();
		$this->sumIncomes();
		$this->sumExpenses();
		$this->balanceFinance();
	}
	
	public function getAllIncomes()
	{
		$sql = "SELECT incomes.amount, incomes.incomeCategoryAssignedToUserId, incomes_category_assigned_to_users.name, incomes.incomeComment, incomes.dateOfIncome 
				FROM incomes, incomes_category_assigned_to_users 
				WHERE incomes.userId=:userId 
				AND incomes.userId = incomes_category_assigned_to_users.userId 
				AND incomes.incomeCategoryAssignedToUserId = incomes_category_assigned_to_users.id 
				AND incomes.dateOfIncome >=:date1 
				AND incomes.dateOfIncome <=:date2 
				ORDER BY incomes.incomeCategoryAssignedToUserId ASC";
				
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':date1', $this->startDate, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $this->endDate, PDO::PARAM_STR);
		
		$stmt->execute();
		
		$this->allIncomes = $stmt->fetchAll();
		
	}

	public function getCategoryIncomes()
	{
		$sql = "SELECT SUM(incomes.amount) AS catIncomeAmount, incomes.incomeCategoryAssignedToUserId, incomes_category_assigned_to_users.name 
				FROM incomes, incomes_category_assigned_to_users 
				WHERE incomes.userId=:userId 
				AND incomes.userId = incomes_category_assigned_to_users.userId 
				AND incomes.incomeCategoryAssignedToUserId = incomes_category_assigned_to_users.id 
				AND incomes.dateOfIncome >=:date1 
				AND incomes.dateOfIncome <=:date2 
				GROUP BY incomes.incomeCategoryAssignedToUserId
				ORDER BY incomes.incomeCategoryAssignedToUserId ASC";
				
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':date1', $this->startDate, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $this->endDate, PDO::PARAM_STR);
		
		$stmt->execute();
		
		$this->categoryIncomes = $stmt->fetchAll();
		
	}
	
	public function getAllExpenses()
	{
		$sql = "SELECT expenses.amount, expenses.expenseCategoryAssignedToUserId, expenses_category_assigned_to_users.name, expenses.expenseComment, expenses.dateOfExpense 
				FROM expenses, expenses_category_assigned_to_users 
				WHERE expenses.userId=:userId 
				AND expenses.userId = expenses_category_assigned_to_users.userId 
				AND expenses.expenseCategoryAssignedToUserId = expenses_category_assigned_to_users.id 
				AND expenses.dateOfExpense >=:date1 
				AND expenses.dateOfExpense <=:date2 
				ORDER BY expenses.expenseCategoryAssignedToUserId ASC";
				
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':date1', $this->startDate, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $this->endDate, PDO::PARAM_STR);
		
		$stmt->execute();
		
		$this->allExpenses = $stmt->fetchAll();
	}

	public function getCategoryExpenses()
	{
		$sql = "SELECT SUM(expenses.amount) AS catExpenseAmount, expenses.expenseCategoryAssignedToUserId, expenses_category_assigned_to_users.name
				FROM expenses, expenses_category_assigned_to_users 
				WHERE expenses.userId=:userId 
				AND expenses.userId = expenses_category_assigned_to_users.userId 
				AND expenses.expenseCategoryAssignedToUserId = expenses_category_assigned_to_users.id 
				AND expenses.dateOfExpense >=:date1 
				AND expenses.dateOfExpense <=:date2 
				GROUP BY expenses.expenseCategoryAssignedToUserId
				ORDER BY expenses.expenseCategoryAssignedToUserId ASC";
				
		$db = static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':date1', $this->startDate, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $this->endDate, PDO::PARAM_STR);
		
		$stmt->execute();
		
		$this->categoryExpenses = $stmt->fetchAll();
	}

	protected function sumIncomes()
	{
		$this->countIncomes = 0;
		
		foreach($this->categoryIncomes as $income)
		{
			$this->countIncomes += $income['catIncomeAmount'];
		}
		
		return $this->countIncomes;
	}
	
	protected function sumExpenses()
	{
		$this->countExpenses = 0;
		
		foreach($this->categoryExpenses as $expense)
		{
			$this->countExpenses += $expense['catExpenseAmount'];
		}
		
		return $this->countExpenses;
	}
	
	protected function balanceFinance()
	{
		$this->balance = $this->sumIncomes() - $this->sumExpenses();
		
		return $this->balance;
	}
	

	
	
	

}