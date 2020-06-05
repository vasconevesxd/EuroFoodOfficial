<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserProfileTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">ID</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Birthday</th>
        <th scope="col">Role</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    <?php foreach ($alluser as $user => $key_user):?>
        <tr>
            <th scope="row"><?php print_r($i++); ?></th>
            <th><?php print_r($key_user->id);?></th>
            <td><?php print_r($key_user->first_name);?></td>
            <td><?php print_r($key_user->last_name);?></td>
            <td><?php print_r($key_user->birthday);?></td>
                <?php $user_role = Yii::$app->authManager->getRolesByUser($key_user['id_users']) ?>
            <td><?php foreach ($user_role as $role => $key){
                    print_r(ucfirst($key->name));
                }
                 ?></td>
            <td>
                <?php foreach ($user_role as $role => $key_role):?>
                    <?php $form = ActiveForm::begin(); ?>

                        <?php if($key_role->name != 'admin'){

                            echo Html::submitButton('Admin',[ 'name'=>'submit', 'value' => 'admin|'.$key_user['id'], 'class' => 'btn btn-danger btn-block']);

                        }

                        if($key_role->name != 'chef'){

                            echo Html::submitButton('Chef',[ 'name'=>'submit', 'value' => 'chef|'.$key_user['id'], 'class' => 'btn btn-success btn-block']);

                        }

                        if($key_role->name != 'costumer'){

                            echo Html::submitButton('Costumer',[ 'name'=>'submit', 'value' => 'costumer|'.$key_user['id'], 'class' => 'btn btn-primary btn-block']);

                        }
                        ?>

                    <?php ActiveForm::end(); ?>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>