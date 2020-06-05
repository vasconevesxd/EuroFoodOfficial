<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ExperienceType */

$this->title = 'Create Experience Type';
$this->params['breadcrumbs'][] = ['label' => 'Experience Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experience-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
