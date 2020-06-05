<?php namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests

    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('LoginForm[username]', 'VascoxD');
        $I->fillField('Password','1231234');
        $I->click('Login');
        $I->wait(2);
        $I->see('EXCEPTIONAL CULINARY EXPERIENCES WORLDWIDE');
    }
}
