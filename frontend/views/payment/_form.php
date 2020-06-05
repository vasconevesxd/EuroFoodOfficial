<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-design" style="margin-bottom: 117px;margin-top: 80px;">
    <div class="container" style="margin-top: 10px;">
        <div class="row">
            <div class="col-xs-12 col-md-4 col-lg-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="display: inline;font-weight: bold;">
                            Payment Details
                        </h3>
                    </div>
                    <div class="panel-body">

                        <?php $form = ActiveForm::begin(); ?>
                            <div class="form-group">
                                <label for="cardNumber">
                                    CARD NUMBER</label>
                                    <?= $form->field($model, 'card_number')->textInput(['class'=>'form-control','placeholder'=>'Valid Card Number','maxlength'=>'16'])->label(false) ?>
                            </div>
                            <div class="row">
                                <div class="col-xs-7 col-md-7">
                                    <div class="form-group">
                                        <label for="expityMonth">
                                            EXPIRY DATE</label>
                                        <div class="col-xs-6 col-lg-6 pl-ziro" style="padding-left: 0px;">
                                            <?= $form->field($model, 'expiration_month')->textInput(['class'=>'form-control','placeholder'=>'MM','maxlength'=>'2'])->label(false) ?>
                                        </div>
                                        <div class="col-xs-6 col-lg-6 pl-ziro" style="padding-left: 0px;">
                                            <?= $form->field($model, 'expiration_year')->textInput(['class'=>'form-control','placeholder'=>'YY','maxlength'=>'4'])->label(false) ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5 pull-right">
                                    <div class="form-group">
                                        <label for="cvCode">
                                            CV CODE</label>
                                        <?= $form->field($model, 'cvcode')->passwordInput(['maxlength'=>'3','type' => 'password'])->label(false) ?>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-euro"></span><?=$experience_type->price?></span> Final Payment</a>
                    </li>
                </ul>
                <br/>

                    <?= Html::submitButton('REQUEST BOOKING', ['class' => 'btn btn-block input-button btn-lg','onclick'=>'resetasd()']) ?>

                <?php ActiveForm::end(); ?>

                <div class="form-group">

                    <script>

                        function resetasd () {
                            swal({
                                title: "Good job!",
                                text: "Payment successful!",
                                icon: "success",
                                buttons: false
                            });
                            setTimeout(function(){
                                //window.location.replace("<!?php echo "/" ?>");
                            }, 1000);
                        }

                    </script>
                </div>

            </div>
        </div>
    </div>
</div>
