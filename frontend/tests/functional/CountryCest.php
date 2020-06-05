<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class CountryCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function tryToCountries(FunctionalTester $I)
    {
        $I->amOnRoute('site/country');
        $I->see('WINE AND DINE IN OUR TOP FALL DESTINATIONS', 'h3');
        $I->comment('== All Countries ==');
        $I->seeLink('Login');
        $I->dontSeeLink('Signup');
    }

}
