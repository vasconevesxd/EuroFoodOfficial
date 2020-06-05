<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div style=" display: flex;width: 100%" class="container">

        <div class="col-sm"
             style="color: white ;width: 35%;background-image: linear-gradient(to right, #ffad33,#ffd699);border-radius: 5px; padding-left: 30px;margin-right: 30px">
                <h3>Users</h3>
                <div class="row" style="display: flex;padding-left: 15px;width: 25%">
                    <div class="column" style="alignment: bottom"><h4><?= $users ?></h4></div>
                    <div class="column" style="padding-left: 30px"><i class="fas fa-user fa-4x"></i></div>
                </div>
        </div>

        <div class="col-sm"
             style="color: white ;width: 35%;background-image: linear-gradient(to right, #00aaff,#80d4ff);border-radius: 5px; padding-left: 30px;margin-right: 30px">
            <h3>Countries</h3>
            <div class="row" style="display: flex;padding-left: 15px;width: 25%">
                <div class="column" style="alignment: bottom"><h4><?= $countries ?></h4></div>
                <div class="column" style="padding-left: 30px"><i class="fas fa-globe fa-4x"></i></div>
            </div>
        </div>


        <div class="col-sm"
             style="color: white ;width: 35%;background-image: linear-gradient(to right, #00cc00,#99ff99);border-radius: 5px; padding-left: 30px;margin-right: 30px">
            <h3>Experiences</h3>
            <div class="row" style="display: flex;padding-left: 15px">
                <div class="column" style="alignment: bottom "><h4><?= $experiences ?></h4></div>
                <div class="column" style="padding-left: 30px"><i class="fas fa-file fa-4x"></i></div>
            </div>
        </div>

    </div>
</div>

