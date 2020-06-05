<?php

namespace frontend\modules\apprest\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * ExperienceTypeController implements the CRUD actions for Chef model.
 */
class ExperienceTypeController extends ActiveController {

       public $modelClass = 'common\models\ExperienceType';

       public function behaviors()
       {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
            return $behaviors;
       }

       public function actionExperiencesCountry() //Mostrar todas as experiencias disponiveis
       {

           $experiences = (new \yii\db\Query())
               ->select(['experience_type.id', 'chef.id_users','experience_type.title','experience_type.images','experience_type.maps', 'experience_type.price','experience_type.description', 'experience_type.start_time', 'experience_type.end_time', 'experience_type.id_meal', 'experience_type.id_countries', 'experience_type.id_chef', 'experience_type.status', 'experience_type.likes_total'])
               ->from('experience_type')
               ->leftJoin('chef', 'experience_type.id_chef=chef.id')
               ->leftJoin('user', 'chef.id_users=user.id')
               ->leftJoin('user_profile', 'user.id=user_profile.id_users')
               ->where(['and',['experience_type.status' => 2]])
               ->all();

           if($experiences)
               return $experiences;
           return "null";
       }
}
?>
