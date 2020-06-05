<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3 col-sm-offset-4 col-md-offset-4 col-lg-offset-4 col-lg-offset-4" style="margin-top:20px;">
            <h1 class="text-center" id="title">SIGN IN</h1>
            <h4 class="text-center" id="sub-title">enter your data</h4>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <small id="emailHelp" class="form-text text-muted">We'll never share your private data with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            <div class="form-group">
                <p class="text-right"> <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['id' => 'forgot-password']) ?></p>
            </div>

            <div class="text-center" style="margin-bottom:10px;">
                <?= Html::submitButton('Login', ['class' => 'btn btn-ghost-bordered btn-md btn-block center-block', 'name' => 'login-button']) ?>

            </div>

            <?php ActiveForm::end(); ?>
            <p class="text-center">New here?<a href="<?= yii\helpers\Url::to(['/site/signup']) ?>" id="link"> Sign Up</a></p>
        </div>
    </div>
</div>
