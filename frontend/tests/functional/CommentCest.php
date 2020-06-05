<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class CommentCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function tryToComment(FunctionalTester $I)
    {

        $I->amOnPage('site/index');
        $I->click('.experience_test');
        $I->comment('Inside a Experience to make a order!!!');

        //Insert Correct Data
        $I->submitForm('#comment-form', [
            'Comment[comments]' => 'tester',
        ]);
        $I->click('Comment');


    }

}
