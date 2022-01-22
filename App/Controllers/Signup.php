<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Sign Up/register-website.html');
    }

    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);

        if ($user->save()) {
			
			$user->sendActivationEmail();
			
			$user->assignDefaultPaymentMethods();
			$user->assignDefaultIncomesCategory();
			$user->assignDefaultExpensesCategory();

			$this->redirect('/signup/success');

        } else {

            View::renderTemplate('Sign Up/register-website.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Show the signup success page
     *
     * @return void
     */
    public function successAction()
    {
        View::renderTemplate('Sign Up/thank-you-for-registration.html');
    }
	
	public function activateAction()
	{
		User::activate($this->route_params['token']);
		
		$this->redirect('/signup/activated');
	}
	
	public function activatedAction()
	{
		View::renderTemplate('Sign Up/succesActivated.html');
	}
}
