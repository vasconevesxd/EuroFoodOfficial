<?php

/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;
$this->title = 'EuroFood';
?>
<div class="container-fluid show-countries">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center" style="color:#4a525d">WINE AND DINE IN OUR TOP FALL DESTINATIONS</h3>
                <h6 class="text-center" style="color:#4a525d;padding-bottom:20px;font-size: 16px">Join dinner parties, cooking
                    classes, food tours &
                    supper clubs</h6>
            </div>
        </div>
        <?php foreach ($country as $disp_country): ?>
            <a class="allexperience" href="<?= Url::to(['/experience-type/list-experience', 'id' => $disp_country->id]) ?>">
                <div class="cat-fav">
                    <div class="card text-white ">
                        <?php
                        $image = $disp_country->image;
                        ?>
                        <img class="card-img img-responsive" src="../<?php echo $image ;?>" alt="Card image">
                        <div class="card-img-overlay">
                            <h5 class="card-title centered country-card"><?= Html::encode("{$disp_country->name}") ?></h5>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
