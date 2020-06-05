<?php namespace common\tests;

use common\models\Comment;
use common\models\ExperienceType;
use common\models\User;

class CommentTest extends \Codeception\Test\Unit
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

    public function testSaveUser()
    {
        $user = new User();
        $user->username = 'Pieter';
        $user->password = '1231234';
        $user->email = 'peiter_98@hmail.pt';
        $user->generateAuthKey();
        $user->save();

    }

    public function testDataCommnet()
    {
        $comment = new Comment();
        $comment->comments = 4321412412;
        $comment->id_experiences_type = 'asdasdsa';
        $comment->id_users = 'fdsafasd';
        $comment->create_at = 12312312;
        $this->tester->assertFalse($comment->save());


    }

    public function testSaveCommnet()
    {
        $user = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);
        $experiences = $this->tester->grabRecord('common\models\ExperienceType', ['maps' => '-9.16667,38.71667']);

        $comment = new Comment();
        $comment->comments = 'Great Food !!!';
        $comment->id_experiences_type = $experiences->id;
        $comment->id_users = $user->id;
        $comment->create_at = date("Y-m-d");
        $comment->save();


    }

    function testViewSavedCommnet()
    {

        $user_id = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);

        $this->tester->seeRecord('common\models\Comment',['id_users'=>$user_id->id]);

    }

    function testUpdateSavedUserCommnet()
    {
        $user_id = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);


        $comment = $this->tester->grabRecord('common\models\Comment',['id_users'=>$user_id->id]);

        $country = Comment::findOne($comment->id);
        $country->comments = 'Amazing';
        $country->update();

    }

    function testViewUpdateCommnet()
    {

        $user_id = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);


        $this->tester->seeRecord('common\models\Comment',['id_users'=>$user_id->id]);

    }


    function testDeleteUpdatedSavedCommnet()
    {
        $user_id = $this->tester->grabRecord('common\models\User', ['username' => 'Pieter']);

        $comment = $this->tester->grabRecord('common\models\Comment',['id_users'=>$user_id->id]);

        $country = Comment::findOne($comment->id);
        $country->delete();
    }

    function testDeleteUpdatedSavedUser()
    {
        $id = $this->tester->grabRecord('common\models\User',['username'=>'Pieter']);

        $user = User::findOne($id);
        $user->delete();
    }
}