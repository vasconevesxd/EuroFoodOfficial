<?php namespace common\tests;

use common\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testDataUser()
    {
        $user = new User();
        $user->username = 54315132432;
        $user->password = 54521342241;
        $user->email = 43214432141;
        $user->generateAuthKey();
        $this->tester->assertFalse($user->save());


    }

    public function testSaveUser()
    {
        $user = new User();
        $user->username = 'Pieter';
        $user->password = '1231234';
        $user->email = 'peiter_98@hmail.pt';
        $user->generateAuthKey();
        $user->save();

    }

    function testViewSavedUser()
    {
        $this->tester->seeRecord('common\models\User',['username'=>'Pieter']);

    }

    function testUpdateSavedUser()
    {
        $id = $this->tester->grabRecord('common\models\User',['username'=>'Pieter']);

        $user = User::findOne($id);
        $user->username = 'Pieter Aparicio';
        $user->update();

    }

    function testViewUpdateUser()
    {
        $this->tester->seeRecord('common\models\User',['username'=>'Pieter Aparicio']);

    }

    function testDeleteUpdatedSavedUser()
    {
        $id = $this->tester->grabRecord('common\models\User',['username'=>'Pieter Aparicio']);

        $user = User::findOne($id);
        $user->delete();
    }

    function testViewDeleteUser()
    {
        if($this->tester->grabRecord('common\models\User',['username'=>'Pieter Aparicio']) == null){


            $this->tester->comment("Doesn't exist!!!");

        }else{

            $this->tester->comment("Hi, User!!!");

        }

    }


}