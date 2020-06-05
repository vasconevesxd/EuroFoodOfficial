<?php

namespace frontend\modules\apprest\controllers;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\rest\ActiveController;


/**
 * UserController implements the CRUD actions for Chef model.
 */
class UserController extends ActiveController {

    public $modelClass = 'common\models\User';
    public $modelClassas = 'frontend\models\PasswordResetRequestForm';

    public $email;

    public function actionAllusers(){

        $alluser = User::find()->all();

        return $alluser;
    }

    public function actionAdduser() {

        /* === Inserir um novo User === */

        $usermodel = new User();
        $usermodel->username = Yii::$app->request->post('username');
        $usermodel->auth_key = Yii::$app->security->generateRandomString();
        $usermodel->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('password_hash'));
        $usermodel->email = Yii::$app->request->post('email');
        $usermodel->status = 10;
        $usermodel->created_at = time();
        $usermodel->updated_at = time();

        if(!$usermodel->validate()){
            \Yii::$app->response->statusCode=409;
            return $usermodel->getErrors();
        }

        $usermodel->save();

        /* === Inserir um novo UserProfile === */

        $userprofilemodel = new UserProfile();
        $userprofilemodel->first_name = Yii::$app->request->post('first_name');
        $userprofilemodel->last_name = Yii::$app->request->post('last_name');
        $same_user = $usermodel::find()->where(['created_at' => time()])->one();
        $userprofilemodel->id_users =  $same_user->id;

        if(!$userprofilemodel->validate()){
            \Yii::$app->response->statusCode=409; //Conflito com o estado do servidor
            return $userprofilemodel->getErrors();
        }

        $userprofilemodel->save();

        $user = User::find()->where(['created_at' => time()])->one();

        /* === Inserir um o role ao User === */
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('costumer');
        $auth->assign($authorRole, $user->id);

        $user_profile = UserProfile::find()->orderBy(['id'=>SORT_DESC])->one();

        if ($usermodel->save() && $userprofilemodel->save()){
            \Yii::$app->response->statusCode=201;  //Foi creado com sucesso
            return ['user'=>$user, 'userprofile'=>$user_profile];

        }else{
            return null;
        }


    }

    public function actionValidlogin() {

        $user = User::find()->where(['email'=>Yii::$app->request->post('email')])->one();

        if (User::find()->where(['email'=>Yii::$app->request->post('email')])->one() === null){ //Validar se o email não vem null

            return "False"; //"Email incorrect!!!"

        }else if($user->email == Yii::$app->request->post('email')){ //Validar se o email é o mesmo do User

            $user = User::find()->where(['email' => Yii::$app->request->post('email')])->one();

            $hash = $user->password_hash;
            $password = Yii::$app->request->post('password_hash');

            if (Yii::$app->getSecurity()->validatePassword($password, $hash) && $user != null) { //Validar se a password é valida e é a mesma do User


                $user->access_token = Yii::$app->security->generateRandomString() . '_' . time(); //Gerar um access-token
                $user->save(false);

                $role = Yii::$app->authManager->getRolesByUser($user->id);

                return [$user->access_token,$role];
            } else {

                return "False"; //"ERROR:. Password or User"
            }

        }

        return "False";
    }

    public function actionTokenuser()
    {
        $user_id = Yii::$app->request->post('id');

        $rec = User::find()->where("id=".$user_id)->one();

        $rec->access_token=''; //Limpar o token após o logout
        $rec->save(false);
        return ['token' => 'Ok'];

    }


    public function actionPassreset()
    {

        $user = User::findOne([
            'email' => Yii::$app->request->post('email'),
        ]);

        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo(Yii::$app->request->post('email'))
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();


        return 'True';

    }

}


?>
