<?php namespace common\tests;

use common\models\User;
use common\models\UserProfile;
use Yii;

class UserProfileTest extends \Codeception\Test\Unit
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

    public function testDataUserProfile()
    {

        $user_profile = new UserProfile();
        $user_profile->first_name = 321321;
        $user_profile->last_name = 546262456154123;
        $user_profile->birthday = 6416413616146;
        $user_profile->image = 6413661;
        $user_profile->id_users = 'dsjjasj';
        $this->tester->assertFalse($user_profile->save());

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

    public function testSaveUserProfile()
    {
        $user = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);

        $user_profile = new UserProfile();
        $user_profile->first_name = 'Pieter';
        $user_profile->last_name = '1231234';
        $user_profile->birthday = '1998-02-21';
        $user_profile->image = 'upload/user_profile/'.$user->id.'/5c06c3468231f_image_Pieter.jpg';
        $user_profile->id_users = $user->id;
        $user_profile->save();


    }

    function testViewSavedUserProfile()
    {
        $id = $this->tester->grabRecord('common\models\UserProfile',['first_name'=>'Pieter']);

        $this->tester->seeRecord('common\models\UserProfile',['id_users'=>$id]);

    }

    function testUpdateSavedUserProfile()
    {

        $id = $this->tester->grabRecord('common\models\UserProfile',['first_name'=>'Pieter']);

        $user_profile = UserProfile::findOne($id);
        $user_profile->first_name = 'Pieterino';
        $user_profile->update();

    }


    function testViewUpdateUserProfile()
    {

        $id = $this->tester->grabRecord('common\models\UserProfile',['first_name'=>'Pieterino']);

        $this->tester->seeRecord('common\models\UserProfile',['id_users'=>$id]);

    }

    function testDeleteUpdatedSavedUserProfile()
    {
        $id = $this->tester->grabRecord('common\models\UserProfile',['first_name'=>'Pieterino']);

        $user_profile = UserProfile::findOne($id);
        $user_profile->delete();
    }

    function testViewDeleteUserProfile()
    {
        if($this->tester->grabRecord('common\models\UserProfile',['first_name'=>'Pieterino']) == null){


            $this->tester->comment("Doesn't exist!!!");

        }else{

            $this->tester->comment("Hi, User Profile!!!");

        }

    }


    function testDeleteUpdatedSavedUser()
    {
        $id = $this->tester->grabRecord('common\models\User',['username'=>'Pieter']);

        $user = User::findOne($id);
        $user->delete();
    }

}