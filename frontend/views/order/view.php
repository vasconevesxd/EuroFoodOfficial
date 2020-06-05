<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ExperienceType */

$this->title = 'CHECKOUT';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-lg-offset-3 form-design">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $i=0; foreach ($images as $img): $i++ ?>

                <img class="img-responsive center-block" style="max-height: 400px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" src="../<?=$img;?>">

                <?php $i=1;break; endforeach; ?>
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bold;"><?=$experience_type->title; ?></h1>
                </div>
                <div class="row">
                    <i style="color:#e84d00" class="fas fa-calendar-check fa-lg"></i>
                    <h4 style="display: inline-block;"><?=date("l jS \of F Y", strtotime($order->experience_time)); ?></h4>
                    <div class="row">
                        <br>
                        <div class="col-md-3">
                            <i style="color:#e84d00" class="fas fa-users fa-lg"></i>
                            <h4 style="display: inline-block;"><?=$order->guest_number; ?> guests</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3 style="font-weight: bold;">TOTAL</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-xs-8 col-md-8" style="padding-left:0px;">
                                <h4><?=$order->guest_number; ?> guests x €<?=$experience_type->price; ?></h4>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                <h2 style="text-align: right;margin-top:0px;font-weight: bold;">€<?=$final_price;?></h2>
                            </div>
                            <div class="col-xs-12 col-md-12" style="margin-bottom: 10px;">
                                <a class="btn btn-exp input-button btn-block" id="button-to-payment" href="<?= yii\helpers\Url::to(['/payment/create','id' => $model->id]) ?>">CHECKOUT</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

