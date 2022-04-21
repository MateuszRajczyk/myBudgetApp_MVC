<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class SettingsInfo extends \Core\Model
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

    public function getIncomeCategoriesInfo()
    {
        $sql = "SELECT id, name FROM incomes_category_assigned_to_users WHERE userId=:userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getExpenseCategoriesInfo()
    {
        $sql = "SELECT id,name, limitAmount FROM expenses_category_assigned_to_users WHERE userId=:userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getPaymentMethodsCategoriesInfo()
    {
        $sql = "SELECT id,name FROM payment_methods_assigned_to_users WHERE userId=:userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function editIncomeCategory()
    {
        $sql = "UPDATE incomes_category_assigned_to_users SET name=:newName WHERE userId=:userId AND id=:oldId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newName', $this->categoryNewName, PDO::PARAM_STR);
        $stmt->bindValue(':oldId', $this->categoryOldId, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteIncomeCategory()
    {
        $sql = "DELETE FROM incomes_category_assigned_to_users WHERE userId=:userId AND id=:idCategory";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':idCategory', $this->categoryIdDel, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addIncomeCategory()
    {
        $sql = "INSERT INTO incomes_category_assigned_to_users(userId, name) VALUES (:user_id, :nameCat)";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':nameCat', $this->categoryAdded, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function editExpenseCategory()
    {
        $sql = "UPDATE expenses_category_assigned_to_users SET name=:newName, limitAmount=:limit WHERE userId=:userId AND id=:oldId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newName', $this->categoryNewName, PDO::PARAM_STR);
        $stmt->bindValue(':oldId', $this->categoryOldId, PDO::PARAM_INT);
        if(isset($this->monthlyLimitAmount)){
            $stmt->bindValue(':limit', $this->monthlyLimitAmount, PDO::PARAM_STR);
        }else{
            $stmt->bindValue(':limit', NULL, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function deleteExpenseCategory()
    {
        $sql = "DELETE FROM expenses_category_assigned_to_users WHERE userId=:userId AND id=:idCategory";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':idCategory', $this->categoryIdDel, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addExpenseCategory()
    {
        $sql = "INSERT INTO expenses_category_assigned_to_users(userId, name) VALUES (:user_id, :nameCat)";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':nameCat', $this->categoryAdded, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function editPaymentCategory()
    {
        $sql = "UPDATE payment_methods_assigned_to_users SET name=:newName WHERE userId=:userId AND id=:oldId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newName', $this->categoryNewName, PDO::PARAM_STR);
        $stmt->bindValue(':oldId', $this->categoryOldId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deletePaymentCategory()
    {
        $sql = "DELETE FROM payment_methods_assigned_to_users WHERE userId=:userId AND id=:idCategory";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':idCategory', $this->categoryIdDel, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addPaymentCategory()
    {
        $sql = "INSERT INTO payment_methods_assigned_to_users(userId, name) VALUES (:user_id, :nameCat)";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':nameCat', $this->categoryAdded, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteAllData()
    {
        $sql = "DELETE a, b
                FROM (SELECT :userId AS id) user
                LEFT OUTER JOIN incomes a ON user.id = a.userId
                LEFT OUTER JOIN expenses b ON user.id = b.userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }
}