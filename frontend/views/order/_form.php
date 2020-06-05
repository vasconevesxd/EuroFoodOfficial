<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'EuroFood';

?>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

        <?php $i=0; foreach ($images as $img): ?>
            <li data-target="#myCarousel" data-slide-to="<?=$i?>"></li>
        <?php if($i == 0){break;} $i++; endforeach; ?>
    </ol>
    <div class="carousel-inner" role="listbox">

        <?php $i=0; foreach ($images as $img): ?>

            <?php if($i == 0): ?>
                <div class="item active">
                    <img class="first-slide" src="../<?=$img;?>" alt="First slide">
                </div>

            <?php else: ?>

                <div class="item">
                    <img class="first-slide" src="../<?=$img;?>" alt="First slide">
                </div>

            <?php endif; ?>

            <?php $i++; endforeach; ?>

    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>



<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-8" style="padding-left: 0px;">
            <h1 class="titles-experience" style="text-transform: uppercase;"><?= $experience_type->title ?></h1>
            <hr>
            <div class="row experience-info">
                <div class="col-md-1">
                    <i class="far fa-clock fa-3x"></i>
                </div>
                <div class="col-md-3">
                    <h4 style="display: inline;"><?= substr($experience_type->start_time, 0, -3);?>-</h4>
                    <h4 style="display: inline-block;"><?= substr($experience_type->end_time, 0, -3); ?></h4>
                </div>
                <div class="col-md-1">
                    <i class="fas fa-utensils fa-3x"></i>
                </div>
                <div class="col-md-3">
                    <h4><?= $meal->name;?></h4>
                </div>
            </div>
            <br>
            <h3 class="titles-experience">A WORD ABOUT THE EXPERIENCE</h3>
            <br>
            <div class="text-justify">
                <?=$experience_type->description?>
            </div>
            <div class="container" style="padding-left: 0px;padding-bottom: 10px;">
                <div id='map'></div>
            </div>

        </div>
        <div class="col-md-4" style="box-shadow: 0 5px 30px -6px black;margin-bottom: 10px;">
                <span class="pull-right" style="margin-top: 10px">
                    <div class="row">
                        <div class="col-md-2">
                            <h2 class="text-price">€<?=$experience_type->price?></h2>
                        </div>
                        <div class="col-md-5">
                            <p class="text-price" style="margin: 25px 10px 10px;">Price per guest</p>
                        </div>
                        <div class="col-md-5">
                            <ul id="img-list" style="display: inline-block;padding-left: 0px;">
                                <li style="display: inline;">
                                    <?php if($user_exis_exp['n_like']==0): ?>
                                        <?= Html::a(Html::img('../images/liked.png', ['class' => 'like-image']), ['order/like']); ?>
                                    <?php else: ?>
                                        <?= Html::a(Html::img('../images/like.png', ['class' => 'like-image']), ['order/like']); ?>
                                    <?php endif; ?>
                                </li>
                                <li style="display: inline;">
                                    <?php if($user_exis_exp['dislike']==0): ?>
                                        <?= Html::a(Html::img('../images/desliked.png', ['class' => 'like-image']), ['order/dislike']); ?>
                                    <?php else: ?>
                                        <?= Html::a(Html::img('../images/deslike.png', ['class' => 'like-image']), ['order/dislike']); ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'order-form']); ?>
                    <?php
                    echo $form->field($model, 'guest_number')->dropDownList(
                        ['0','1','2','3','4','5','6','7','8','9','10','11','12']
                    ); ?>

                    <?= $form->field($model, 'experience_time')->widget(\janisto\timepicker\TimePicker::className(), [
                        //'language' => 'fi',
                        'mode' => 'date',
                        'clientOptions' => [
                            'dateFormat' => 'yy-mm-dd',
                        ]
                    ]); ?>

                    <?= $form->field($model, 'id_user')->hiddenInput()->label(false);?>

                    <?= $form->field($model, 'id_experiences_type')->hiddenInput()->label(false);?>

                    <?= $form->field($model, 'data_order')->hiddenInput()->label(false);?>

                    <div class="form-group">
                        <?= Html::submitButton('REQUEST BOOKING', ['class' => 'btn btn-block input-button btn-lg']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </span>
        </div>
    </div>
</div>

<div class="container">
    <?php $form = ActiveForm::begin(['id' => 'comment-form']);?>

    <?= $form->field($model_comment, 'comments')->textarea(['maxlength' => true]) ?>

    <?= Html::a('Comment',null,['class' => 'btn input-button  pull-right' ,'onclick' => 'commentPostAJAX("'.Yii::$app->request->baseUrl.'","'.$model_comment->comments.'","'.$_GET['id'].'","'.Yii::$app->request->getCsrfToken().'")']);?>

    <?php ActiveForm::end();?>
    <div class="row">
        <div class="col-md-6">
            <?php foreach ($dataProvider as $comment)
                {
                    echo '<div class="panel panel-default">';
                        echo '<div class="panel-body">';

                            echo "<img src='../".$comment['image']."'class='img-circle'>";
                            print ($comment['username']);
                            echo '<p id="comments"></p>';
                            print($comment['comments'].'<br /><br />');
                            print($comment['create_at'].'<br />');
                        echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiZXhhbXBsZXMiLCJhIjoiY2lqbmpqazdlMDBsdnRva284cWd3bm11byJ9.V6Hg2oYJwMAxeoR9GEzkAA';
    var map = new mapboxgl.Map({
        container: 'map', // Container ID
        style: 'mapbox://styles/mapbox/streets-v10', // Map style to use
        center: [<?=$experience_type->maps?>], // Starting position [lng, lat]
        zoom: 12, // Starting zoom level
    });

    var marker = new mapboxgl.Marker() // Initialize a new marker
        .setLngLat([<?=$experience_type->maps?>]) // Marker [lng, lat] coordinates
        .addTo(map); // Add the marker to the map




    function commentPostAJAX($url,$id,$id_exp,$csrf){
        $.ajax({
            url: $url + '/order/comment',
            type: 'post',
            data: {
                comments: $("#comment-comments").val() ,
                id_experience : $id_exp ,
                _csrf : $csrf
            }
        })
            .done( function (data) {

                $('.col-md-6').prepend('<div class="panel panel-default"><div class="panel-body"><p id="comments"></p>'+'<img src="../<?=$user_image['image'];?>"class="img-circle">'+'<?=$user_image['username'];?>'+'</br>'+data.check+'</br></br>'+'<?=date("Y-m-d H:i:s")?>');

            })
            .fail( function (xhr, textStatus, errorThrown){
                $(".col-md-6").html("Something went wrong, refresh page and if this error persists, contact support");
                console.log(errorThrown);
            });
    }

</script>

