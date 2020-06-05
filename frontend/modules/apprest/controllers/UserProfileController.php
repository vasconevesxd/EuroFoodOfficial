<?php

namespace frontend\modules\apprest\controllers;
use common\models\UserProfile;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * UserProfileController implements the CRUD actions for Chef model.
 */
class UserProfileController extends ActiveController {

       public $modelClass = 'common\models\UserProfile';

        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
                'except' => ['showusers'] //A function actionShowusers não vai ser preciso o access-token

            ];
            return $behaviors;
        }

        public function actionShowusers() { //Mostrar todos os user_profiles

            $all_users = UserProfile::find()->all();

            return $all_users;

        }


        public function actionEdituserprofile() {

            $userprofile_id = Yii::$app->request->post('id');

            $rec = UserProfile::find()->where("id_users=".$userprofile_id)->one();

            $rec->first_name=Yii::$app->request->post('first_name');
            $rec->last_name=Yii::$app->request->post('last_name');
            $rec->birthday=Yii::$app->request->post('birthday');
            $rec->save(false);

            return ['edit_profile' => 'Ok'];

        }


}
?>
