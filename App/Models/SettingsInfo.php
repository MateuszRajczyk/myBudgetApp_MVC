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
        $sql = "SELECT name FROM incomes_category_assigned_to_users WHERE userId=:userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getExpenseCategoriesInfo()
    {
        $sql = "SELECT name FROM expenses_category_assigned_to_users WHERE userId=:userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getPaymentMethodsCategoriesInfo()
    {
        $sql = "SELECT name FROM payment_methods_assigned_to_users WHERE userId=:userId";
        
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }
}