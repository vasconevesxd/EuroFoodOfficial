<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class ListExperiencesCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToListExperience(FunctionalTester $I)
    {
        $I->amOnRoute('site/country');
        $I->see('WINE AND DINE IN OUR TOP FALL DESTINATIONS', 'h3');
        $I->comment('== All Countries ==');

        $I->click('.allexperience');
        $I->see('EXPLORE DELICIOUS FOOD EXPERIENCES WITH HAND-SELECTED HOSTS');
    }
}
