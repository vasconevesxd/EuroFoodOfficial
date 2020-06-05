<?php

namespace frontend\modules\apprest\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * ChefController implements the CRUD actions for Chef model.
 */
class ChefController extends ActiveController {


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\Chef';

}
?>
