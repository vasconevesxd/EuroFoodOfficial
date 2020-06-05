<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#form-signup';


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('SIGN UP', 'h1');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('First Name cannot be blank.');
        $I->seeValidationError('Last Name cannot be blank.');
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
            'SignupForm[first_name]'  => 2321,
            'SignupForm[last_name]'  => 432432,
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
        ]
        );
        $I->dontSee('Username cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->see('Email is not a valid email address.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[first_name]'  => 'Pieter',
            'SignupForm[last_name]'  => 'Aparicio',
            'SignupForm[username]'  => 'PieAp',
            'SignupForm[email]'     => 'pieter.98@example.com',
            'SignupForm[password]'  => 'tester_password',
        ]);

        $I->seeRecord('common\models\User', [
            'username' => 'PieAp',
            'email' => 'pieter.98@example.com',
        ]);

    }
}
