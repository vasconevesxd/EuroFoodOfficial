<?php

namespace frontend\modules\apprest\controllers;
use common\models\Comment;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * CommentController implements the CRUD actions for Chef model.
 */
class CommentController extends ActiveController {

    public $modelClass = 'common\models\Comment';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionAllcomments() //Mostrar todos os comments
    {
        $rec = Comment::find()->all();

        return ['comments' => $rec];
    }

}
?>
