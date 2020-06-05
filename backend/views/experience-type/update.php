<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ExperienceType */

$this->title = 'Update Experience Type: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Experience Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="experience-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
