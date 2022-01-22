<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mybudget-webapp';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
	
	const SECRET_KEY = 'E3MDjigrUAfoP1yPVglatmLCxnkVas7h';
	
	const USERNAME_GMAIL = 'mateuszrajczyk96@gmail.com';
	
	const PASSWORD_GMAIL = 'Babunia155!';
}
