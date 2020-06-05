<?php

use yii\db\Migration;

/**
 * Class m181210_161029_init_rbac
 */
class m181210_161029_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181210_161029_init_rbac cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $auth = Yii::$app->authManager;



        /*=============Admin===========*/

        $viewCountries = $auth->createPermission('viewCountries');
        $viewCountries->description = 'View Countries';
        $auth->add($viewCountries);

        $createCountries = $auth->createPermission('createCountries');
        $createCountries->description = 'Create Countries';
        $auth->add($createCountries);

        $updateCountries = $auth->createPermission('updateCountries');
        $updateCountries->description = 'Update Countries';
        $auth->add($updateCountries);

        $deleteCountries = $auth->createPermission('deleteCountries');
        $deleteCountries->description = 'Delete Countries';
        $auth->add($deleteCountries);



        $viewUsers = $auth->createPermission('viewUsers');
        $viewUsers->description = 'View Users';
        $auth->add($viewUsers);

        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Create Users';
        $auth->add($createUsers);

        $updateUsers = $auth->createPermission('updateUsers');
        $updateUsers->description = 'Update Users';
        $auth->add($updateUsers);

        $deleteUsers = $auth->createPermission('deleteUsers');
        $deleteUsers->description = 'Delete Users';
        $auth->add($deleteUsers);


        /*=============Chef===========*/

        $viewChefs = $auth->createPermission('viewChefs');
        $viewChefs->description = 'View Chefs';
        $auth->add($viewChefs);

        $createChefs = $auth->createPermission('createChefs');
        $createChefs->description = 'Create Chefs';
        $auth->add($createChefs);

        $updateChefs = $auth->createPermission('updateChefs');
        $updateChefs->description = 'Update Chefs';
        $auth->add($updateChefs);

        $deleteChefs = $auth->createPermission('deleteChefs');
        $deleteChefs->description = 'Delete Chefs';
        $auth->add($deleteChefs);



        $viewExperiencesTypes = $auth->createPermission('viewExperiencesTypes');
        $viewExperiencesTypes->description = 'View a Experience Type';
        $auth->add($viewExperiencesTypes);

        $createExperiencesTypes = $auth->createPermission('createExperienceType');
        $createExperiencesTypes->description = 'Create a Experience Type';
        $auth->add($createExperiencesTypes);

        $updateExperiencesTypes = $auth->createPermission('updateExperienceType');
        $updateExperiencesTypes->description = 'Update a Experience Type';
        $auth->add($updateExperiencesTypes);

        $deleteExperiencesTypes = $auth->createPermission('deleteExperienceType');
        $deleteExperiencesTypes->description = 'Delete a Experience Type';
        $auth->add($deleteExperiencesTypes);


        /*=============User===========*/

        $viewOrder = $auth->createPermission('viewOrder');
        $viewOrder->description = 'View a Orders';
        $auth->add($viewOrder);

        $createOrder = $auth->createPermission('createOrder');
        $createOrder->description = 'Create a Orders';
        $auth->add($createOrder);

        $updateOrder = $auth->createPermission('updateOrder');
        $updateOrder->description = 'Update a Orders';
        $auth->add($updateOrder);

        $deleteOrder = $auth->createPermission('deleteOrder');
        $deleteOrder->description = 'Delete a Orders';
        $auth->add($deleteOrder);



        $viewPayment = $auth->createPermission('viewPayment');
        $viewPayment->description = 'View a Payments';
        $auth->add($viewPayment);

        $createPayment = $auth->createPermission('createPayment');
        $createPayment->description = 'Create a Payments';
        $auth->add($createPayment);

        $updatePayment = $auth->createPermission('updatePayment');
        $updatePayment->description = 'Update a Payments';
        $auth->add($updatePayment);

        $deletePayment = $auth->createPermission('deletePayment');
        $deletePayment->description = 'Delete a Payments';
        $auth->add($deletePayment);



        $viewComment = $auth->createPermission('viewComment');
        $viewComment->description = 'View a Commnets';
        $auth->add($viewComment);

        $createComment = $auth->createPermission('createComment');
        $createComment->description = 'Create a Commnets';
        $auth->add($createComment);

        $updateComment = $auth->createPermission('updateComment');
        $updateComment->description = 'Update a Commnets';
        $auth->add($updateComment);

        $deleteComment = $auth->createPermission('deleteComment');
        $deleteComment->description = 'Delete a Commnets';
        $auth->add($deleteComment);


        $viewUsersProfiles = $auth->createPermission('viewUsersProfiles');
        $viewUsersProfiles->description = 'View Users Profiles';
        $auth->add($viewUsersProfiles);

        $createUsersProfiles = $auth->createPermission('createUsersProfiles');
        $createUsersProfiles->description = 'Create Users Profiles';
        $auth->add($createUsersProfiles);

        $updateUsersProfiles = $auth->createPermission('updateUsersProfiles');
        $updateUsersProfiles->description = 'Update Users Profiles';
        $auth->add($updateUsersProfiles);

        $deleteUsersProfiles = $auth->createPermission('deleteUsersProfiles');
        $deleteUsersProfiles->description = 'Delete Users Profiles';
        $auth->add($deleteUsersProfiles);




        $costummers = $auth->createRole('costumer');
        $auth->add($costummers);
        $chef = $auth->createRole('chef');
        $auth->add($chef);
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($chef, $costummers);

    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
