<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'EuroFood';
?>
<div class="container-fluid show-chefs">
    <div class="container">
        <h3 class="text-center" style="color:#4a525d">EXPLORE DELICIOUS FOOD EXPERIENCES WITH HAND-SELECTED
            HOSTS</h3>
        <div class="row">
            <div class="container">
                <div class="row userMain">
                <?php foreach ($experiences as $experience => $key): ?>
                    <a href="<?= Url::to(['/order/create', 'id' => $key['id']]) ?>">
                        <div class="col-md-4 col-sm-4">
                            <div class="userBlock">
                                <div class="backgrounImg">
                                    <img class="img-responsive" src="../<?=explode(",", $key['images'])[0] ?>">
                                </div>
                                <div class="userImg">
                                    <img src="../<?= $key['image']?>">
                                </div>
                                <div class="userDescription">
                                    <h4><?= Html::encode("{$key['title']}") ?></h4>
                                    <div class="likes">
                                        <span class="number"><?= Html::encode("{$key['likes_total']}") ?></span>
                                        <span>Likes</span>
                                    </div>
                                    <div class="show_price">
                                        <span>€<?= Html::encode("{$key['price']}") ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>