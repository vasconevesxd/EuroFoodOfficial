<?php

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Chef */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Chef';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="container form-design">
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textarea(['maxlength' => true]) ?>


    <?=$form->field($model, 'files')->widget(FileInput::classname(), []); ?>

    <?= $form->field($model, 'id_language')->widget(Select2::classname(), [
        'data' => $listDataLang,
        'language' => 'en',
        'options' => ['placeholder' => 'Select a country ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <?= $form->field($model, 'id_countries')->widget(Select2::classname(), [
        'data' => $listData,
        'language' => 'en',
        'options' => ['placeholder' => 'Select a country ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn input-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
