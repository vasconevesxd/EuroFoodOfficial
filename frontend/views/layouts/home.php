<?php

/* @var $this \yii\web\View */
/* @var $content string */

use kartik\select2\Select2;
use yii\helpers\Html;
use frontend\assets\MainAsset;
use yii\widgets\ActiveForm;

$countries = $this->params['listcountry'];

$model = $this->params['model'];

if(!Yii::$app->user->isGuest){

    $user = $this->params['user'];

    $user_profile = $this->params['user_profile'];

    $user_role = $this->params['user_role'];

}
MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>
<body>
<?php $this->beginBody() ?>

<section class="first">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" style="margin-bottom: 20px;"><img src="images/logo.png"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " href="<?= yii\helpers\Url::to(['/']) ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= yii\helpers\Url::to(['/site/country']) ?>">Countries</a>
                    </li>
                    <?php if(!Yii::$app->user->isGuest): ?>
                        <?php foreach ($user_role as $role => $key):?>
                            <?php if($key->name == 'chef'):?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= yii\helpers\Url::to(['/experience-type']) ?>">Experience Type</a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= yii\helpers\Url::to(['/site/about']) ?>">About</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(Yii::$app->user->isGuest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= yii\helpers\Url::to(['/site/login']) ?>">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= yii\helpers\Url::to(['/site/signup']) ?>" class="btn btn-default active" id="btn-signup" role="button" aria-pressed="true">Sign up </a>
                    </li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white;">
                                <span class="glyphicon glyphicon-user"></span> 
                                <strong><?=$user->username?></strong>
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <p>
                                    <div class="navbar-login" style="width: 305px;padding: 10px;padding-bottom: 0px;">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center"></p>
                                              <?php if (!isset($user_profile->image)): ?>
                                                  <i class="fas fa-users fa-4x"></i>

                                              <?php else: ?>
                                                <img class="img-responsive img-rounded" src="<?= $user_profile->image?>">
                                              <?php endif; ?>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong><?=$user->username?></strong></p>
                                                <p class="text-left small"><?=$user->email?></p>
                                                <p class="text-left">
                                                    <a href="<?= yii\helpers\Url::to(['/user-profile/update','id' => $user_profile->id]) ?>" class="btn input-button btn-block btn-sm">Update Profile</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <?= Html::a('Logout', ['site/logout'], ['class'=> 'nav-link', 'id' =>'btn-signup','data' => ['method' => 'post']]) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="padding-top: 100px;">
        <h1 class="text-center" id="p5" style="color:white;">EXCEPTIONAL CULINARY EXPERIENCES WORLDWIDE</h1>
        <h4 class="text-center" style="color:white;font-weight: bold;">This fall, share unique dinners, cooking
            classes, food tours &
            supper clubs with hand-selected hosts</h4>
        <div class="row" style="padding-top:100px;">
            <?php $form = ActiveForm::begin(); ?>
                <div class="input-group">
                    <?= $form->field($model, 'name')->widget(Select2::classname(), [
                        'data' => $countries,
                        'language' => 'en',
                        'bsVersion' => '3.x',
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => ['placeholder' => 'Select a country ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>

                    <span class="input-group-btn" style="padding-top:8px;">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-search']) ?>
                    </span>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
</section>

<?= $content ?>

<footer class="container-fluid py-5">
    <div class="row">
        <div class="col-md-2">
            <img src="images/logo.png">
            <small class="d-block mb-3 text-muted text-center">&copy; 2017-2018</small>
        </div>
        <div class="col-md-3">
            <h5 class="footer-h5">HomePage</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Home</a></li>
                <li><a class="text-muted" href="/site/about">About</a></li>
                <li><a class="text-muted" href="/site/contact">Contacts</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <h5 class="footer-h5">Experiences</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="/site/country">Countries</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <h5 class="footer-h5">Account</h5>
            <ul class="list-unstyled text-small">
                <?php if(Yii::$app->user->isGuest): ?>
                    <li><a class="text-muted" href="#">Login</a></li>
                    <li><a class="text-muted" href="#">SignUp</a></li>
                <?php else: ?>
                    <li class="nav-item">
                        <?= Html::a('Logout', ['site/logout'], ['class'=> 'text-muted','data' => ['method' => 'post']]) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</footer>


<?php $this->endBody() ?>

<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>
