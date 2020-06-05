<?php

namespace frontend\modules\apprest\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * LikeController implements the CRUD actions for Likes model.
 */
class LikesController extends ActiveController {

       public $modelClass = 'common\models\Likes';


       public function behaviors()
       {
               $behaviors = parent::behaviors();
               $behaviors['authenticator'] = [
                   'class' => QueryParamAuth::className(),
               ];
               return $behaviors;
       }
}
?>
