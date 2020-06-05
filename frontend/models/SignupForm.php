<?php
namespace frontend\models;

use common\models\UserProfile;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],


            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['first_name', 'string', 'max' => 40],

            ['last_name', 'trim'],
            ['last_name', 'required'],
            ['last_name', 'string', 'max' => 40],


        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save(false);

        $user_profile = new UserProfile();
        $user_profile->first_name = $this->first_name;
        $user_profile->last_name = $this->last_name;
        $user_profid = User::findOne(['username'=>$this->username]);
        $user_profile->id_users = $user_profid->id;
        $user_profile->save();


        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('costumer');
        $auth->assign($authorRole, $user->getId());


        return $user;
    }
}
