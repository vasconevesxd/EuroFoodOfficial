<?php namespace common\tests;

use common\models\Country;

class CountryTest extends \Codeception\Test\Unit
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

    public function testDataCountry()
    {
        $country = new Country();
        $country->name = 35324324;
        $country->image = 654365463432;
        $this->tester->assertFalse($country->save());


    }

    public function testSaveCountry()
    {
        $country = new Country();
        $country->name = 'Brazil';
        $country->image = 'upload/country_upload/Brazil.jpeg';
        $country->save();

    }

    function testViewSavedCountry()
    {
        $this->tester->seeRecord('common\models\Country',['name'=>'Brazil']);

    }

    function testUpdateSavedCountry()
    {
        $id = $this->tester->grabRecord('common\models\Country',['name'=>'Brazil']);

        $country = Country::findOne($id);
        $country->name = 'Braziles';
        $country->update();

    }

    function testViewUpdateCountry()
    {
        $this->tester->seeRecord('common\models\Country',['name'=>'Braziles']);

    }


    function testDeleteUpdatedSavedCountry()
    {
        $id = $this->tester->grabRecord('common\models\Country',['name'=>'Braziles']);

        $country = Country::findOne($id);
        $country->delete();
    }

    function testViewDeleteUser()
    {
        if($this->tester->grabRecord('common\models\Country',['name'=>'Braziles']) == null){


            $this->tester->comment("Doesn't exist!!!");

        }else{

            $this->tester->comment("Hi, Country!!!");

        }

    }

}