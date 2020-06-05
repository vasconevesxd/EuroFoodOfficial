<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Experience';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Experience Type', ['create'], ['class' => 'btn btn-exp']) ?>
    </p>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Images</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; $status = ''; ?>
        <?php foreach ($allexperience as $experiences): ?>
            <?php if ($experiences['status'] == 1) {
                $status = "Pending";
            } else if ($experiences['status'] == 2) {
                $status = "Aproved";
            } ?>
            <tr>

                <th scope="row"><?= $i++ ?></th>
                <td><?= $experiences['id'] ?></td>
                <td><?= $experiences['title'] ?></td>
                <td><?= $experiences['images'] ?></td>
                <td><?= $status ?></td>
                <td>
                    <ul style="display: inline-block;padding-left: 0px;">
                        <li style="display: inline;">
                            <a class="allexperience"
                               href="<?= Url::to(['/experience-type/view?id=' . $experiences['id']]) ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="display: inline;">
                            <a class="allexperience"
                               href="<?= Url::to(['/experience-type/update?id=' . $experiences['id']]) ?>">
                                <i class="fa fa-paint-brush" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php foreach ($allemptyexperiences as $emptyexperiences): ?>

                            <?php if ($experiences['id'] == $emptyexperiences['id']): ?>
                                <li style="display: inline;">
                                    <a class="allexperience"
                                       href="<?= Url::to(['/experience-type/delete?id=' . $experiences['id']]) ?>"data-method="post">
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

</div>

