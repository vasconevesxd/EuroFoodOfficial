<?php

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->widget(\janisto\timepicker\TimePicker::className(), [
        //'language' => 'fi',
        'mode' => 'date',
        'clientOptions' => [
            'dateFormat' => 'yy-mm-dd',
        ]
    ]); ?>

    <?=$form->field($model, 'image')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'showUpload' => false,
        ]
    ]); ?>


    <?php foreach ($user_role as $role => $key):?>
        <?php if($key->name == 'chef'):?>
            <hr>
            <h3 class="text-center">== CHEF ==</h3>

            <?= $form->field($current_chef, 'full_address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($current_chef, 'about')->textarea(['maxlength' => true]) ?>


            <?=$form->field($current_chef, 'files')->widget(FileInput::classname(), [
                'pluginOptions' => [
                    'showUpload' => false,
                ]
            ]); ?>

            <?= $form->field($current_chef, 'id_language')->widget(Select2::classname(), [
                'data' => $listDataLang,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a language ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

            ?>

            <?= $form->field($current_chef, 'id_countries')->widget(Select2::classname(), [
                'data' => $listData,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a country ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        <?php endif; ?>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block input-button']) ?>
    </div>
    <h3 class="text-center">OR</h3>
        <?php foreach ($user_role as $role => $key):?>
            <div class="form-group">
                <?php if($key->name == 'chef'){
                    echo Html::submitButton('Save & Back to be a Costummer',[ 'name'=>'submit', 'value' => 'costummer', 'class' => 'btn btn-block input-button']);

                }else{
                    echo Html::submitButton('Save & Be a Chef',[ 'name'=>'submit', 'value' => 'chef', 'class' => 'btn btn-block input-button']);
                }  ?>

            </div>
        <?php endforeach; ?>

    <?php ActiveForm::end(); ?>


