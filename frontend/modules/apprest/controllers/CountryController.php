<?php

namespace frontend\modules\apprest\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * CountryController implements the CRUD actions for Chef model.
 */
class CountryController extends ActiveController {

    public $modelClass = 'common\models\Country';

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
