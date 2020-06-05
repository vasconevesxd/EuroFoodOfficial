<?php

namespace backend\controllers;

use common\models\Chef;
use common\models\ExperienceType;
use Yii;
use common\models\UserProfile;
use app\models\UserProfileTypeSearch;
use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {

        $alluser = UserProfile::find()->where(['<>','id_users', Yii::$app->user->id])->all();

        if(isset($_POST['submit'])) {

            $values = explode('|', $_POST['submit']);
            $theuserprofile = UserProfile::find()->where(['id'=>$values[1]])->one();
            $role_user = Yii::$app->authManager->getRolesByUser($theuserprofile['id_users']);

            foreach ($role_user as $role_us => $key){
                $the_role = $key->name;
            }
        }


        if(isset($_POST['submit']) && $values[0]=='admin')
        {
            if($the_role == 'chef'){

                if(Chef::find()->where(['id_users'=>$theuserprofile['id_users']])->one() != null){

                    $the_chef = Chef::find()->where(['id_users'=>$theuserprofile['id_users']])->one();
                    $exp = ExperienceType::find()->where(['id_chef'=>$the_chef['id']])->all();

                    foreach ($exp as $experiences => $key){

                        $key['status'] = 1;
                        $key->save(false);


                    }

                }

            }

            $user = $theuserprofile['id_users'];
            $auth = new DbManager;
            $auth->init();
            $role = $auth->getRole($values[0]);
            $roles = $auth->getRole($the_role);
            $auth->revoke($roles,$user);
            $auth->assign($role, $user);


        }
        else if(isset($_POST['submit']) && $values[0]=='chef')
        {

            $user = $theuserprofile['id_users'];
            $auth = new DbManager;
            $auth->init();
            $role = $auth->getRole($values[0]);
            $roles = $auth->getRole($the_role);
            $auth->revoke($roles,$user);
            $auth->assign($role, $user);


            if(Chef::find()->where(['id_users' => $theuserprofile['id_users']])->one() == null){
                $model_chef = new Chef();
                $model_chef->id_users = $theuserprofile['id_users'];
                $model_chef->save(false);


            }

        }
        else if(isset($_POST['submit']) && $values[0]=='costumer')
        {

            if($the_role == 'chef'){

                if(Chef::find()->where(['id_users'=>$theuserprofile['id_users']])->one() != null){

                    $the_chef = Chef::find()->where(['id_users'=>$theuserprofile['id_users']])->one();
                    $exp = ExperienceType::find()->where(['id_chef'=>$the_chef['id']])->all();

                    foreach ($exp as $experiences => $key){

                        $key['status'] = 1;
                        $key->save(false);


                    }

                }

            }


            $user = $theuserprofile['id_users'];
            $auth = new DbManager;
            $auth->init();
            $role = $auth->getRole($values[0]);
            $roles = $auth->getRole($the_role);
            $auth->revoke($roles,$user);
            $auth->assign($role, $user);

        }

        return $this->render('index', [
            'alluser' => $alluser,

        ]);
    }


    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
