<?php namespace common\tests;

use common\models\Chef;
use common\models\User;

class ChefTest extends \Codeception\Test\Unit
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

    public function testDataChef()
    {
        $chef = new Chef();
        $chef->full_address = 43213312312;
        $chef->about = 542134214;
        $chef->files = 21342134;
        $chef->id_users = 'Pieter';
        $chef->id_language = 'Aparicio';
        $chef->id_countries = 'Natal';
        $this->tester->assertFalse($chef->save());
    }


    public function testSaveUser()
    {
        $user = new User();
        $user->username = 'Pieter';
        $user->password = '1231234';
        $user->email = 'peiter_98@gmail.pt';
        $user->generateAuthKey();
        $user->save();

    }

    public function testSaveChef()
    {
        $user = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);
        $country = $this->tester->grabRecord('common\models\Country', ['name' => 'Portugal']);
        $language = $this->tester->grabRecord('common\models\Language', ['name' => 'Portuguese']);

        $chef = new Chef();
        $chef->full_address = 'Rua Mirando Carvalho';
        $chef->about = 'He an thing rapid these after going drawn or. Timed she his law the spoil round defer. In surprise concerns informed betrayed he learning is ye.';
        $chef->files = '1231234';
        $chef->id_users = $user->id;
        $chef->id_language = $language->id;
        $chef->id_countries = $country->id;
        $chef->save();


    }

    function testViewSavedChef()
    {
        $user = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);
        $this->tester->seeRecord('common\models\Chef',['id_users'=>$user->id]);

    }

    function testUpdateSavedChef()
    {

        $user = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);

        $id = $this->tester->grabRecord('common\models\Chef',['id_users'=>$user->id]);

        $chef = Chef::findOne($id);

        $chef->full_address = 'Rua Antonio do Espirito';
        $chef->update();

        $this->tester->seeRecord('common\models\Chef', ['full_address' => 'Rua Antonio do Espirito']);

    }

    function testViewUpdateChef()
    {

        $this->tester->seeRecord('common\models\Chef',['full_address' => 'Rua Antonio do Espirito']);

    }


    function testDeleteUpdatedSavedChef()
    {

        $user = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);

        $id = $this->tester->grabRecord('common\models\Chef',['id_users'=>$user->id]);

        $chef = Chef::findOne($id);
        $chef->delete();
    }

    function testViewDeleteChef()
    {
        if($this->tester->grabRecord('common\models\Chef',['full_address'=>'Rua Antonio do Espirito']) == null){


            $this->tester->comment("Doesn't exist!!!");

        }else{

            $this->tester->comment("Hi, Chef!!!");

        }

    }


    function testDeleteUpdatedSavedUser()
    {
        $id = $this->tester->grabRecord('common\models\User',['username'=>'Pieter']);

        $user = User::findOne($id);
        $user->delete();
    }



}