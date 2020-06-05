<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ExperienceType */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Experience Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php foreach ($deleterestricition as $emptyexperiences): ?>

            <?php if ($model['id'] == $emptyexperiences['id']):?>

                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif;?>
        <?php endforeach; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'images',
            'maps',
            'price',
            'description',
            'id_chef',
            'start_time',
            'end_time',
            'id_meal',
            'id_countries',
            'status',
        ],
    ]) ?>

</div>
