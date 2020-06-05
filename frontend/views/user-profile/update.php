<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */

$this->title = 'Update Profile: ' . $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container form-design">


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_role' => $user_role,
        'model_chef' =>$model_chef,
        'current_chef'=>$current_chef,
        'listDataLang' => $listDataLang,
        'listData' => $listData,
        'user_role' => $user_role
    ]) ?>

</div>
