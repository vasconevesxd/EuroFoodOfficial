<?php

/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = 'EuroFood';
?>

<div class="container" style="padding-top:20px;padding-bottom: 50px;">
    <h2 class="text-center" style="color:#4a525d">HOW IT WORKS</h2>
    <div class="row" style="padding-top:20px;">
        <div class="col-md-4 text-center">
            <i class="fas fa-map-marked-alt fa-4x discover-i"></i>
            <h4 class="discover">DISCOVER</h4>
            <p class="discover-text">A cooking class in Rome, a rooftop dinner party in Barcelona, a supper club in
                London…Browse culinary events with our hand-selected hosts</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-calendar-check fa-4x discover-i"></i>
            <h4 class="discover">BOOK</h4>
            <p class="discover-text">Select your favorite food experience and book a date that works for you.
                You’ll be able to chat with your host directly</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-utensils fa-4x discover-i"></i>
            <h4 class="discover">ENJOY</h4>
            <p class="discover-text"> Discover delicious food, meet passionate people & experience the magic of
                Eatwith</p>
        </div>
    </div>
</div>
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
        <?php $i = 1; foreach ($country as $disp_country): ?>
            <a href="<?= Url::to(['/experience-type/list-experience', 'id' => $disp_country->id]) ?>">
                <div class="cat-fav">
                    <div class="card text-white ">
                        <?php
                        $image = $disp_country->image;
                        ?>
                        <img class="card-img img-responsive" src="<?php echo $image ;?>" alt="Card image">
                        <div class="card-img-overlay">
                            <h5 class="card-title centered country-card"><?= Html::encode("{$disp_country->name}") ?></h5>
                        </div>
                    </div>
                </div>
            </a>
        <?php if($i == 3){break;} $i++; endforeach; ?>
    </div>
</div>

<div class="jumbotron">
    <div class="container">
        <h1 class="display-6" style="color:white;">DELICIOUS FOOD WITH ONE CHEF</h1>
    </div>
</div>
<div class="container-fluid show-experience">
    <div class="container">
        <h3 class="text-center" style="color:#4a525d">EXPLORE DELICIOUS FOOD EXPERIENCES WITH HAND-SELECTED
            HOSTS</h3>
        <div class="row">
            <div class="container">
                <div class="row userMain">
                    <?php $i = 1; foreach ($experiences as $experience => $key): ?>
                    <a class="experience_test" href="<?= Url::to(['/order/create', 'id' => $key['id']]) ?>">
                    <div class="col-md-4 col-sm-4">
                        <div class="userBlock">
                            <div class="backgrounImg">
                                <img class="img-responsive" src="<?=explode(",", $key['images'])[0] ?>">
                            </div>
                            <div class="userImg">
                                <?php if($key['image'] == null):?>

                                    <img src="images/user.png">


                                <?php else: ?>

                                    <img src="<?= $key['image']?>">

                                <?php endif; ?>
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
                    <?php if($i == 3){break;} $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>