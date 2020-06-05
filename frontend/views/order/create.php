<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Order */


?>

<?= $this->render('_form', [
    'model' => $model,
    'images'=>$images,
    'experience_type'=>$experience_type,
    'meal'=>$meal,
    'model_comment'=>$model_comment,
    'dataProvider'=>$dataProvider,
    'user_exis_exp'=>$user_exis_exp,
    'user_image' =>$user_image,

]) ?>

