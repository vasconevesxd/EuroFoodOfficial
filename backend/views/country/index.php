<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Countries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Country', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Images</th>
            <th scope="col"></th>

        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($allcountries as $countries): ?>
            <tr>
                <th scope="row"><?= $i++ ?></th>
                <td><?= $countries['id'] ?></td>
                <td><?= $countries['name'] ?></td>
                <td><?= $countries['image'] ?></td>
                <td style="">
                    <ul style="display: inline-block;padding-left: 0px;">
                        <li style="display: inline;">
                            <a class="allexperience"
                               href="<?= Url::to(['/country/view?id=' . $countries['id']]) ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="display: inline;">
                            <a class="allexperience"
                               href="<?= Url::to(['/country/update?id=' . $countries['id']]) ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php foreach ($allemptycountries as $emptycountries): ?>

                            <?php  if ($countries['id'] == $emptycountries['id']): ?>
                                <li style="display: inline;">
                                    <a class="allexperience"
                                       href="<?= Url::to(['/country/delete?id=' . $countries['id']]) ?>"data-method="post">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </li>
                            <?php endif;?>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

