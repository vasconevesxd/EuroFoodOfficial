<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>

<div class="container-fluid">
    <div class="row">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3 col-sm-offset-4 col-md-offset-4 col-lg-offset-4 col-lg-offset-4" style="margin-top:20px;">
            <h1 class="text-center" id="title">SIGN UP</h1>
            <h4 class="text-center" id="sub-title">enter your data</h4>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="form-group">
                <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'last_name')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'email') ?>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput() ?>
                <small id="emailHelp" class="form-text text-muted">Never show your password to anyone!</small>
            </div>

            <div class="text-center" style="margin-bottom:10px;">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-ghost-bordered btn-md btn-block center-block', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <p class="text-center">I have<a href="<?= yii\helpers\Url::to(['/site/login']) ?>" id="link"> an account</a></p>
        </div>
    </div>
</div>

