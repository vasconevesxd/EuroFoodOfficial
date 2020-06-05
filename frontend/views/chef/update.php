<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Chef */

$this->title = 'Update Chef: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chefs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chef-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
